<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use PHPMailer\PHPMailer;
use App\Models\ActivityLogs;
use Carbon\Carbon;

class EmailController extends Controller
{
    //
    public function send_notification(ActivityLogs $m_activity_logs){

        // get logs for mailing
        $logs = $m_activity_logs->get_logs_for_mail();

        $mail             = new PHPMailer\PHPMailer(); // create a n
        $mail->SMTPAuth   = true; // authentication enabled
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host       = "smtp.office365.com";
        $mail->Port       = 587; // or 587
        $mail->IsSMTP();
        $mail->Username = "interface-notification@isuzuphil.com";
        $mail->Password = "NJI99ijn";
        $mail->SetFrom("interface-notification@isuzuphil.com", 'Notification');

        $mail->Subject = 'Fleet Ordering System';

        


        foreach($logs as $log){
             $content = [
                'message' => $log->content
            ];
            $mail->Body    = view('mail.notification', $content);
            $mail->isHTML(true);
            $mail->addCC($log->mail_recipient);
            //mail->addBCC('paul-alcabasa@isuzuphil.com');
            $mailSend = $mail->Send();
            
            if($mailSend){
                // update notification status to sent
                $m_activity_logs->update_sent_flag($log->log_id,  Carbon::now());
            }

        }
       
    }
}
