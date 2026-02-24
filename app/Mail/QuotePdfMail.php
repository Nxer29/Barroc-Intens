<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotePdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Quote $quote) {}

    public function build()
    {
        $pdf = Pdf::loadView('quotes.pdf', ['quote' => $this->quote]);

        return $this->subject('Offerte ' . $this->quote->quote_number)
            ->view('emails.quote')
            ->attachData($pdf->output(), 'offerte-'.$this->quote->quote_number.'.pdf');
    }
}