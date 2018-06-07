<?php

namespace App\Listeners;

use App\Events\ReplyWasReported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminAboutReport
{
    /**
     * Handle the event.
     *
     * @param  ReplyWasReported  $event
     * @return void
     */
    public function handle(ReplyWasReported $event)
    {
        $text = "Uporabnik " . $event->report->user->name . " je prijavil komentar uporabnika " . $event->report->reply->owner->name . " z vsebino " . $event->report->reply->body . " \r\n"
            . "Povezava do komentarja: " . env('APP_URL') . $event->report->reply->path();

        Mail::raw($text, function ($message) {
            $message->from('predlagam.vladi@test.test', 'Prijavljen neprimeren komentar na predlagam.vladi.si');
            $message->to('admin@predlagam.si');
        });
    }
}
