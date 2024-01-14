<?php

declare(strict_types=1);

namespace Modules\Projects\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Modules\Projects\Forms\ProjectForm;
use Modules\Projects\Models\Projects;
use Modules\Projects\Resources\ProjectResource;
use Modules\Tasks\Forms\TasksForm;

class ProjectsController extends Controller
{
    private Projects $projects;

    private int $project_id = 0;

    /** @var ProjectForm */
    public ProjectForm $form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request, Projects $projects)
    {
        $route = Route::current();
        $request_id = $request->input('id');
        if ($route !== null && ! empty($route->parameters['id'])) {
            $this->project_id = (int) $route->parameters['id'];
        } elseif (! empty($request_id)) {
            $this->project_id = (int) $request_id;
        }
        // Создаем объект формы
        $this->middleware(
            function ($request, $next) {
                $this->form = (new ProjectForm($this->project_id));
                return $next($request);
            }
        );
        $this->projects = $projects;
    }

    public function index(Request $request)
    {
        $per_page = config('app.per_page');
        return $this->projects->paginate($per_page);
    }

    public function getTasks(Request $request): Arrayable | \JsonSerializable | array
    {
        $project = $this->projects->find($this->project_id);
        return (new ProjectResource($project))->toArray($request);
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
        if ($this->project_id) {
            // Обновляем объект если во входящих параметрах есть идентификатор
            $project = $this->projects->find($this->form->entity_id);
            $project->update($fields);
        } else {
            // Создаем новый объект
            $this->projects->create($fields);
        }
        return true;
    }

    /**
     * Удаление проекта.
     *
     */
    public function destroy(): void
    {
        $unit = $this->projects->find($this->project_id);
        $unit?->delete();
    }

    /**
     * Получение параметров формы
     *
     * @return array
     */
    public function getFormParams(): array
    {
        $form['action'] = '/api/admin/projects/store';
        if (! empty($this->project_id)) {
            $form['title'] = 'Редактировать проект';
            $form['type'] = 'edit';
        } else {
            $form['title'] = 'Добавить новый проект';
            $form['type'] = 'add';
        }
        $form['form'] = $this->form->form()->getArray();
        return $form;
    }
}
