<?php

namespace App\Listeners;


use App\Events\JoeyCreateEvent;
use App\Notifications\JoeyCreateNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class JoeyCreateListener
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

    public function handle(JoeyCreateEvent $event)
    {
        $user = $event->user;


            $user->notify(new JoeyCreateNotification());
    }
}
