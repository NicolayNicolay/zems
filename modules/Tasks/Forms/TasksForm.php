<?php

declare(strict_types=1);

namespace Modules\Tasks\Forms;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\Pure;
use Modules\Projects\Models\Projects;
use Modules\System\Forms\AbstractForm;
use Modules\System\Forms\Inputs\InputText;
use Modules\System\Forms\Inputs\InputTextarea;
use Modules\Tasks\Models\Tasks;
use Modules\Users\Models\User;

class TasksForm extends AbstractForm
{
    /**
     * @var User Текущий авторизованный пользователь
     */
    public User $user;

    public Projects $projects;

    public function __construct(int $entity_id = 0)
    {
        $this->entity_id = $entity_id;
        $user = \Auth::user();
        if ($user) {
            $this->user = $user;
        }
        $this->projects = (new Projects());
        $this->getEntity();
    }

    protected function getEntity(): void
    {
        $this->entity_data = (new Tasks())->find($this->entity_id);
    }

    /**
     * @inheritDoc
     */
    public function form(): AbstractForm
    {
        $this->form = [
            'id'          => $this->entity_id,
            /**
             * Основные поля
             */
            'name'        => (new InputText())
                ->setLabel('Название')
                ->setValidationRule('required')
                ->setNameAndId('name')
                ->setValue($this->getFieldValue('name'))
                ->get(),
            'description' => (new InputTextarea())
                ->setLabel('Описание')
                ->setValidationRule('nullable')
                ->setNameAndId('description')
                ->setValue($this->getFieldValue('description'))
                ->get(),
            'project_id'  => (new InputText())
                ->setLabel('Проект')
                ->setValidationRule('required')
                ->setNameAndId('project_id')
                ->setValue($this->getFieldValue('project_id'))
                ->get(),
        ];

        // Добавляем дополнительные служебные поля для существующих объектов
        return $this;
    }

    public function collectValidationRules(mixed $form): void
    {
        foreach ($form as $key => $item) {
            if (! is_array($item)) {
                continue;
            }
            if (Arr::has($item, ['validation_rule', 'id', 'name'])) {
                if (! empty($item['validation_rule'])) {
                    $this->validation_rules[$key] = explode("|", $item['validation_rule']);
                }
            } else {
                $this->collectValidationRules($item);
            }
        }
    }

    public function getFieldsDefinition()
    {
        return config('tasks.fields');
    }

    public function validationAttributes()
    {
        return config('tasks.attr');
    }

    /**
     * Метод собирает значения полей из запроса
     *
     * @return array
     */
    public function getFieldsFromRequest(): array
    {
        $this->getFieldsNames($this->form);

        /** @var Request $request */
        $request = app(Request::class);

        $fields_completed = [];

        $fields = $this->getFieldsDefinition();
        // Собираем поля из запроса
        foreach ($fields as $field => $path) {
            if (array_key_exists($path, $this->completed_fields)) {
                $fields_completed[$field] = $request->input($path);
            }
        }
        // Пробрасываем id объекта
        if (! empty($this->entity_data)) {
            $fields_completed['id'] = $this->entity_data->id;
        }
        $fields_completed['create_user_id'] = $this->user->id;

        return $fields_completed;
    }

    /**
     * Выполняем валидацию данных формы
     */
    public function validate($rules)
    {
        $validator = Validator::make(
            data:       $this->getFieldsFromRequest(),
            rules:      $rules,
            attributes: $this->validationAttributes()
        );
        $validator->validated();
    }
}
