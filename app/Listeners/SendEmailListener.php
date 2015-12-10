<?php

namespace GDGFoz\Listeners;

use GDGFoz\Events\UserCreateEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreateEvent  $event
     * @return void
     */
    public function handle(UserCreateEvent $event)
    {
        $user = $event->getUser();

        \Mail::send('sdf', [], function($message) use($input, $user)
        {
            $message->to( $user->email, $user->name)->subject('Welcome!');
        });
    }
}
