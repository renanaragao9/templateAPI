<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    private mixed $url;
    private mixed $name;

    public function __construct($url, $name)
    {
        $this->url = $url;
        $this->name = $name;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Alterar Senha')
            ->line('Prezado(a) ' . $this->name . ',')
            ->line('Você está recebendo este e-mail porque recebemos um pedido de redefinição de senha para sua conta.')
            ->action('Resetar Senha', $this->url)
            ->line('Se você não solicitou uma alteração da senha, nenhuma ação adicional é necessária.');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
