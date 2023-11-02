<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Company;

class registration extends Mailable
{
    use Queueable, SerializesModels;
    public $company;
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
    public function build()
    {
        $company = $this->company;
        return $this->subject('Welcome to Our Platform')
            ->view('mail.mail', ['company' => $company]);
    }
}