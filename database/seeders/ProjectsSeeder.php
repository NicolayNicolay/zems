<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Projects\Models\Projects;
use Modules\Tasks\Models\Tasks;
use Modules\Users\Models\User;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'name'     => 'admin',
            'email'    => 'admin@admin.ru',
            'password' => Hash::make('password'),
        ];
        $projects = [
            [
                'name'        => 'Проекты/Задачи',
                'description' => 'Реализация пользовательского интерфейса. В рамках задачи реализуется процесс авторизации и регистрации, а также административная панель сервиса.',
                'tasks'       => [
                    [
                        'name'        => 'Авторизация/Регистрация',
                        'description' => 'В рамках задачи реализуется процес авторизации и регистрации',
                        'start'       => '2024-01-13 12:01:36',
                        'end'         => '2024-01-13 15:01:36',
                        'state'       => 4,
                    ],
                    [
                        'name'        => 'Верстка и реализация административной панели сервиса',
                        'description' => 'В рамках задачи реализуется верстка и основная работа компонентов административной панели',
                        'start'       => '2024-01-13 15:01:36',
                        'end'         => '2024-01-13 19:01:36',
                        'state'       => 4,
                    ],
                    [
                        'name'        => 'Реализация мобильного меню сервиса',
                        'description' => 'В рамках задачи реализуется верстка мобильного меню сервиса',
                        'state'       => 1,
                    ],
                    [
                        'name'        => 'Реализация инкапсуляции vue компонентов для модальных окон ',
                        'description' => 'В рамках задачи реализуется верстка мобильного меню сервиса',
                        'start'       => '2024-01-13 20:10:10',
                        'end'         => '2024-01-13 22:05:01',
                        'state'       => 4,
                    ],
                    [
                        'name'        => 'Мобильная адаптация Дашборда задач в разделе проектов',
                        'description' => 'В рамках задачи необходимо реализовать мобильную адаптацию процесса переноса состояний задач',
                        'state'       => 1,
                    ],
                ],
            ],
            [
                'name'        => 'Статистика',
                'description' => 'Реализация раздела статистика. В рамках задачи реализуется процесс подсчета данных по выполненным задачам',
                'tasks'       => [
                    [
                        'name'        => 'Базовая установка библиотеки для работы с графиком',
                        'description' => 'В рамках задачи мы установили библиотеку для работы с графиком',
                        'start'       => '2024-01-14 12:01:36',
                        'end'         => '2024-01-14 13:02:36',
                        'state'       => 4,
                    ],
                    [
                        'name'        => 'Реализация сбора данных',
                        'description' => 'В рамках задачи реализуется сбор данных для отрисовки графика',
                        'start'       => '2024-01-14 13:03:40',
                        'end'         => '2024-01-14 15:01:36',
                        'state'       => 4,
                    ],

                ],
            ],
            [
                'name'        => 'Тест',
                'description' => 'Тестирования сервиса',
                'tasks'       => [
                    [
                        'name'        => 'Проверка работы разделов сервиса',
                        'description' => 'В рамках задачи мы проверяем Front and Back части сайта',
                        'start'       => '2024-01-14 12:01:36',
                        'end'         => '2024-01-14 13:02:36',
                        'state'       => 4,
                    ],
                ],
            ],
            [
                'name'        => 'Наполнение сервиса',
                'description' => 'Наполнения тестовых данных сервиса ',
                'tasks'       => [
                    [
                        'name'        => 'Написание команды для наполнения тестовыми данными сервиса',
                        'description' => 'В рамках задачи необходимо написать seed файл для наполнения сервиса тестовыми данными',
                        'start'       => '2024-01-14 14:01:36',
                        'end'         => '2024-01-14 16:02:36',
                        'state'       => 4,
                    ],
                ],
            ],
        ];

        $user = User::query()->create(
            [
                'name'     => 'admin',
                'email'    => 'admin@admin.ru',
                'password' => Hash::make('password'),
            ]
        );
        foreach ($projects as $project) {
            $current_project = (new Projects())->create(
                [
                    'name'           => $project['name'],
                    'description'    => $project['description'],
                    'create_user_id' => $user->id,
                ]
            );
            foreach ($project['tasks'] as $task) {
                (new Tasks())->create([
                                          'name'           => $task['name'],
                                          'description'    => $task['description'],
                                          'start'          => $task['start'] ?? null,
                                          'end'            => $task['end'] ?? null,
                                          'create_user_id' => $user->id,
                                          'make_user_id'   => $user->id,
                                          'state'          => $task['state'],
                                          'project_id'     => $current_project->id,
                                      ]);
            }
        }
    }
}
