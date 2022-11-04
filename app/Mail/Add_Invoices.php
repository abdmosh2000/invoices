<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Add_Invoices extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $invoice_id;
    public $user;
    public function __construct($invoice_id, $user)
    {
        $this->invoice_id=$invoice_id;
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.AddInvoices')->with([
        'user'=>$this->user,
            'invoice_id'=>$this->invoice_id,
    ]);;
    }
}
