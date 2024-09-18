<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contract extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Make $data public to be accessible in the Blade view
    private $pdfOutput;

    /**
     * Create a new message instance.
     *
     * @param array $data
     * @param string $pdfOutput (PDF content to attach)
     */    
    public function __construct($data, $pdfOutput)
    {
        $this->data = $data; // Assign the passed data to the public variable
        $this->pdfOutput = $pdfOutput; // PDF file output
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from('hardyaranzanso07@gmail.com')
                    ->subject('Lease Contract')
                    ->view('emails.contract') // This is the HTML view
                    ->with('data', $this->data) // Make sure 'data' is passed here
                    ->attachData($this->pdfOutput, 'lease-contract.pdf', [
                        'mime' => 'application/pdf',
                    ]); // Attach the generated PDF
    }
}
