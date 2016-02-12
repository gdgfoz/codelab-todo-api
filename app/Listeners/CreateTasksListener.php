<?php

namespace App\Listeners;

use App\User;
use Faker\Generator;
use App\Events\UserCreateEvent;
use GDGFoz\Todo\Category\Category;
use GDGFoz\Todo\Task\Task;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateTasksListener
{
    private $faker;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Handle the event.
     *
     * @param  UserCreateEvent  $event
     * @return void
     */
    public function handle(UserCreateEvent $event)
    {
        $this->seedCategories($event->getUser());
        $this->seedTasks($event->getUser());
    }


    protected function seedCategories(User $user)
    {

        $data = [
            [
                'category' => 'Trabalho',
                'path_icon' => '/uploads/categories/trabalho.jpg',
                'path_thumb' => '/uploads/categories/trabalho-icon.png',
                'color' => '#3F51B5'
            ],
            [
                'category' => 'Lazer',
                'path_icon' => '/uploads/categories/lazer.jpg',
                'path_thumb' => '/uploads/categories/lazer-icon.png',
                'color' => '#43A047'
            ],
            [
                'category' => 'Família',
                'path_icon' => '/uploads/categories/familia.jpg',
                'path_thumb' => '/uploads/categories/familia-icon.png',
                'color' => '#E57373'
            ],
            [
                'category' => 'Estudos',
                'path_icon' => '/uploads/categories/estudos.jpg',
                'path_thumb' => '/uploads/categories/estudos-icon.png',
                'color' => '#9C27B0'
            ],
            [
                'category' => 'Viagem',
                'path_icon' => '/uploads/categories/viagem.jpg',
                'path_thumb' => '/uploads/categories/viagem-icon.png',
                'color' => '#FFC107'
            ],
            [
                'category' => 'Projetos pessoais',
                'path_icon' => '/uploads/categories/projetos-pessoais.jpg',
                'path_thumb' => '/uploads/categories/projetos-pessoais-icon.png',
                'color' => '#F06292'
            ],
        ];


        foreach ($data as $k=>$row) {
            $category = Category::create($row);
            $user->categories()->attach($category);
        }

    }

    protected function seedTasks(User $user)
    {
        $categories = $user->categories()->take(4)->orderByRaw("RAND()")->get();

        foreach($categories as $category) {

            for ($i = 0; $i < 4; $i++) {

                $data = [
                    'name' => $this->faker->sentence,
                    'description' => $this->faker->paragraph(2),
                    'category_id' => $category->id,
                    'user_id' => $user->id,
                    'status' => $this->faker->boolean(80),
                ];

                Task::create($data);
            }

        }
    }
}
