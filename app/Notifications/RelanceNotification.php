<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RelanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $nom;
    public $login;
    public $defaultPassword;
    public $link;

    public function __construct($email, $nom, $login, $defaultPassword, $link)
    {
        $this->email = $email;
        $this->nom = $nom;
        $this->login = $login;
        $this->defaultPassword = $defaultPassword;
        $this->link = $link;
    }

    public function build()
    {
        return $this->view('emails.relance')
                    ->with([
                        'nom' => $this->nom,
                        'login' => $this->login,
                        'defaultPassword' => $this->defaultPassword,
                        'link' => $this->link,
                    ])
                    ->subject('Relance pour votre formation');
    }
}
