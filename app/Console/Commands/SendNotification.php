<?php
namespace App\Console\Commands;

ini_set('max_execution_time', 3600);
use Illuminate\Console\Command;
use PHPMailer\PHPMailer;
use App\Models\ActivityLogs;
use Carbon\Carbon;
use App\Models\Email;
class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Notification';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ActivityLogs $m_activity_logs)
    {   
       
        // get logs for mailing
        $logs = $m_activity_logs->get_logs_for_mail();
        $email = new Email;
        $mailCredentials = $email->getMailCredentials();

        foreach($logs as $log){

            $mail             = new PHPMailer\PHPMailer(); // create a n
            $mail->SMTPAuth   = true; // authentication enabled
            $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host       = "smtp.office365.com";
            $mail->Port       = 587; // or 587
            $mail->IsSMTP();
            $mail->Username = $mailCredentials->email;
            $mail->Password = $mailCredentials->email_password;
            $mail->SetFrom($mailCredentials->email, 'Fleet Registration');
            $mail->Subject = 'Fleet Ordering System';
            $content = [
                'message' => $log->content
            ];
            $mail->Body    = view('mail.notification', $content);
            $mail->isHTML(true);
            $mail->addAddress($log->mail_recipient);
            $mail->addBCC('paul-alcabasa@isuzuphil.com');
            $mailSend = $mail->Send();
            
            if($mailSend){
                // update notification status to sent
                $m_activity_logs->update_sent_flag($log->log_id,  Carbon::now());
            }

        }
    }

}