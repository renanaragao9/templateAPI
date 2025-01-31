<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;

class SendResetPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $url;

    public function __construct(User $user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    public function handle()
    {
        $this->user->notify(new ResetPasswordNotification($this->url));
    }
}
