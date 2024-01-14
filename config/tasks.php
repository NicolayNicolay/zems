<?php

return [
    'fields'       => [
        'name'        => 'name',
        'description' => 'description',
        'project_id'  => 'project_id',
    ],
    'attr'         => [
        'name'        => 'Название',
        'description' => 'Описание',
        'project_id'  => 'Идентификатор проекта',
    ],
    'states'       => [
        'ideas',
        'todos',
        'inProgress',
        'completed',
    ],
    'states_value' => [
        'ideas'      => 1,
        'todos'      => 2,
        'inProgress' => 3,
        'completed'  => 4,
    ],
];

