<?php

namespace GDGFoz\Listeners;

use Faker\Generator;
use GDGFoz\Category;
use GDGFoz\Events\UserCreateEvent;
use GDGFoz\Task;
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
        $categories = Category::get()->lists('id')->toArray();

        for($i=0;$i<40;$i++) {

            $data = [
                'name' => $this->faker->sentence,
                'description' => $this->faker->paragraph(2),
                'user_id' => $event->getUser()->id,
                'category_id' => $this->faker->randomElement( $categories ),
                'status' => $this->faker->boolean(80),
            ];

            Task::create($data);
        }

    }
}
