<?php

namespace App\Events;


use Illuminate\Queue\SerializesModels;

class JoeyCreateEvent
{
    use SerializesModels;

    public $user;
    public $token;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {

        $this->user = $user;
    }
}
