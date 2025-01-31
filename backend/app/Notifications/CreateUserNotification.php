<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateUserNotification extends Notification
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
            ->subject('Ativação de  Acesso - Enexe')
            ->line('Prezado(a) '.$this->name.',')
            ->line('Como parte do processo de ativação da sua conta em nosso sistema, solicitamos que crie uma senha para acessar o sistema Enexe. Para isso, pedimos que clique no botão abaixo e siga as instruções para definir sua senha pessoal.')
            ->line('Ao acessar o link abaixo, você será redirecionado para uma página segura onde poderá inserir sua nova senha. Lembre-se de escolher uma senha forte e única, que contenha uma combinação de letras maiúsculas e minúsculas, números e caracteres especiais. Essas medidas ajudarão a proteger sua conta e garantir a segurança dos seus dados.')
            ->action('Acessar', $this->url);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
