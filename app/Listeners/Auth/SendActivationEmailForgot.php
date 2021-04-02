<?php

namespace App\Listeners\Auth;

use App\Events\Auth\ForgotActivationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\Auth\ForgotEmail;
use Redirect,Response, DB, Config;
use Mail;


class SendActivationEmailForgot
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
     * @param  ForgotActivationEmail  $event
     * @return void
     */
    public function handle(ForgotActivationEmail $event)
    {
        $event->user;

        Mail::to($event->user->email)->send(new ForgotEmail($event->user));
    }
}
