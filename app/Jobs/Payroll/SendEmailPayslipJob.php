<?php

namespace App\Jobs\Payroll;

use App\Mail\SendEmailPayslip;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailPayslipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $payslip_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payslip_id)
    {
        $this->payslip_id = $payslip_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::to('gezrylclarizg@gmail.com')->send(new SendEmailPayslip($this->payslip_id));
        $data["email"] = "gezrylclarizg@gmail.com";
        $data["title"] = "Payslip from 03/10 to 03/22";
        $data["body"] = "For questions just send an email to HR payslip id: " . $this->payslip_id;
 
        $files = [
            public_path('storage/img/huhu.jpg'),
            public_path('storage/files/report.xlsx'),
        ];
  
        Mail::send('emails.welcome', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
 
            foreach ($files as $file){
                $message->attach($file);
            }
            
        });
 
        dd('Mail sent successfully');
    }
}
