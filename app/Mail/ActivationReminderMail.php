<?php

// app/Mail/ActivationReminderMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $apprenant;
    public $tempPassword;

    public function __construct($apprenant, $tempPassword)
    {
        $this->apprenant = $apprenant;
        $this->tempPassword = $tempPassword;
    }

    public function build()
    {
        return $this->subject('Rappel d\'activation de compte')
                    ->view('emails.activation')
                    ->with([
                        'nom' => $this->apprenant['nom'],
                        'prenom' => $this->apprenant['prenom'],
                        'tempPassword' => $this->tempPassword,
                    ]);
    }
}
