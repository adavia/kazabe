<?php 

namespace App\Mail;

use App\Mail\Mailer\Mailable;

class Contact extends Mailable
{
    protected $contact;

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function build()
    {
        return $this->subject("Has recibido un nuevo mensaje de {$this->contact['name']}")
            ->view('emails/contact.html')
            // ->from('anothermail@email.com', 'another')
            ->with([
                'contact' => $this->contact
            ]);
    }
}