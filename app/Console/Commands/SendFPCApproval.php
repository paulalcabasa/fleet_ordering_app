<?php
namespace App\Console\Commands;


use Illuminate\Console\Command;
use PHPMailer\PHPMailer;
use App\Models\FPC;
use App\Models\FPC_Project;
use Carbon\Carbon;
use App\Models\Email;
use App\Models\ModuleApproval;

class SendFPCApproval extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fpc_approval:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending FPC Notification';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        
        $email = new Email;
        $mailCredentials = $email->getMailCredentials();

        $fpc = new FPC;
        $fpc_project = new FPC_Project;

        // get logs for mailing
        $approval = $fpc->get_pending();
     
        foreach($approval as $row){

            $mail             = new PHPMailer\PHPMailer(); // create a n
            $mail->SMTPAuth   = true; // authentication enabled
            $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host       = "smtp.office365.com";
            $mail->Port       = 587; // or 587
            $mail->IsSMTP();
            $mail->Username = $mailCredentials->email;
            $mail->Password = $mailCredentials->email_password;
            $mail->SetFrom($mailCredentials->email, 'Fleet Registration');

            $project_headers       = $fpc_project->get_projects($row->fpc_id);
            
            $mail->Subject = 'System Notification : Fleet Registration';
            $content = [
                'fpc_header' => $row,
                'approve_link' => url('/') . '/api/fpc/approve/' . $row->approval_id,
                'reject_link' => url('/')  . '/api/fpc/reject/' . $row->approval_id,
                'fpc_projects' => $project_headers,
                'print_url' => url('/')  . '/api/fpc/project/print/'
            ];
            
            $mail->Body    = view('mail.fpc_approval', $content);
            $mail->isHTML(true);
            $mail->AddEmbeddedImage(config('app.project_root') . 'public/img/isuzu-logo-compressor.png', 'isuzu_logo');
            // $mail->addAddress($row->email_address, $row->approver_name);	// Add a recipient, Name is optional
            $mail->addAddress('paul-alcabasa@isuzuphil.com', 'Paul');	// Add a recipient, Name is optional
            $mail->addBCC('paul-alcabasa@isuzuphil.com');
           $mailSend = $mail->Send();
            
            if($mailSend){
                $moduleApproval = ModuleApproval::findOrFail($row->approval_id);
                $moduleApproval->date_sent = Carbon::now();
                $moduleApproval->save();
                // update notification status to sent
               // $m_activity_logs->update_sent_flag($log->log_id,  Carbon::now());
            }

        }
    }

}