<?php

declare(strict_types=1);

namespace Modules\Tasks\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Forms\ProjectForm;
use Modules\Projects\Models\Projects;
use Modules\Projects\Resources\ProjectResource;
use Modules\Tasks\Forms\TasksForm;
use Modules\Tasks\Models\Tasks;
use Illuminate\Support\Carbon;

class TasksController extends Controller
{
    private Tasks $tasks;

    private int $task_id = 0;

    /** @var TasksForm */
    public TasksForm $form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Tasks $tasks)
    {
        $route = Route::current();
        $request_id = $request->input('id');
        if ($route !== null && ! empty($route->parameters['id'])) {
            $this->task_id = (int) $route->parameters['id'];
        } elseif (! empty($request_id)) {
            $this->task_id = (int) $request_id;
        }
        // Создаем объект формы
        $this->middleware(
            function ($request, $next) {
                $this->form = (new TasksForm($this->task_id));
                return $next($request);
            }
        );
        $this->tasks = $tasks;
    }

    /**
     * Валидация полей и сохранение объекта
     *
     * @return bool
     */
    public function store(): bool
    {
        // Получаем правила валидации из формы
        $this->form->form();
        $validation_rules = $this->form->getValidationRules();
        $this->form->validate($validation_rules);
        // Получаем заполненные поля из запроса
        $fields = $this->form->getFieldsFromRequest();
        if ($this->task_id) {
            // Обновляем объект если во входящих параметрах есть идентификатор
            $project = $this->tasks->find($this->form->entity_id);
            $project->update($fields);
        } else {
            // Создаем новый объект
            $this->tasks->create($fields);
        }
        return true;
    }

    /**
     * Изменение статуса задачи
     *
     */
    public function changeState(Request $request): void
    {
        $state = $request->input('state');
        $states = config('tasks.states_value');
        if ($state) {
            $task = $this->tasks->find($request->input('id'));
            $task?->update(['state' => $states[$state]]);
        }
    }

    /**
     * Начало выполнения задачи
     *
     */
    public function startTask(Request $request): ?array
    {
        $id = $request->input('id');
        if ($id) {
            $task = $this->tasks->find($id);
            if (! $task->make_user_id) {
                $task?->update([
                                   'make_user_id' => Auth::user()->id,
                                   'start'        => Carbon::now()->format('Y-m-d H:i:s'),
                                   'state' => 2,
                               ]);
                return [
                    'status' => true,
                    'error'  => '',
                    'user'   => Auth::user()->name,
                ];
            } else {
                return [
                    'status' => false,
                    'error'  => 'Задача взята в работу другим пользователем',
                ];
            }
        }
        return null;
    }

    /**
     * Конец выполнения задачи
     *
     */
    public function endTask(Request $request): ?array
    {
        $id = $request->input('id');
        if ($id) {
            $task = $this->tasks->find($id);
            if ($task->make_user_id && ! $task->end) {
                $end_time = Carbon::now()->format('Y-m-d H:i:s');
                $task?->update([
                                   'state' => 4,
                                   'end'   => $end_time,
                               ]);
                return [
                    'status'   => true,
                    'error'    => '',
                    'end_time' => $end_time,
                ];
            } else {
                return [
                    'status' => false,
                    'error'  => 'Задача уже выполнена',
                ];
            }
        }
        return null;
    }

    /**
     * Удаление проекта.
     *
     */
    public function destroy(): void
    {
        $unit = $this->tasks->find($this->task_id);
        $unit?->delete();
    }
}
