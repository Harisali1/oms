<?php

namespace App\Listeners;


use App\Events\JoeyAgreementCreateEvent;
use App\Notifications\JoeyAgreementCreateNotification;


class JoeyAgreementCreateListener
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

    public function handle(JoeyAgreementCreateEvent $event)
    {
        $user = $event->user;


            $user->notify(new JoeyAgreementCreateNotification());
    }
}
