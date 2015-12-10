<?php

namespace GDGFoz\Events;

use GDGFoz\Events\Event;
use GDGFoz\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreateEvent extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * UserCreateEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */


    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

}
