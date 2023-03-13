<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GeneratedPayrollPeriod extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $message;
    private $dates;
    public function __construct($message, $dates)
    {
        $this->message = $message;
        $this->dates = $dates;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Generated Payroll Period")
            ->view('mails.generated-payroll-period')
            ->with(['message_body' => $this->message, 'dates' => $this->dates]);
    }
}
