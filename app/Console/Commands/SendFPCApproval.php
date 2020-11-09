<?php
namespace App\Console\Commands;


use Illuminate\Console\Command;
use PHPMailer\PHPMailer;
use App\Models\FPC;
use App\Models\FPC_Project;
use Carbon\Carbon;
use App\Models\Email;
use App\Models\ModuleApproval;
use App\Models\FPC_Item;
use App\Models\Competitor;

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

            $project_headers = $fpc_project->get_projects($row->fpc_id);
        
            $projects           = [];
            $fpcItem = new FPC_Item;
            $competitor = new Competitor;

            $projectIds = "";

            foreach($project_headers as $project){
                $requirements            = $fpcItem->get_item_requirements($project->fpc_project_id);
                $competitors             = $competitor->get_competitors($project->project_id);

                $temp_arr                = [
                    'project_id'              => $project->project_id,
                    'payment_terms'           => $project->payment_terms,
                    'validity'                => $project->validity,
                    'availability'            => $project->availability,
                    'note'                    => $project->note,
                    'dealer_name'             => $project->dealer_name,
                    'dealer_account'          => $project->dealer_account,
                    'project_status'          => $project->project_status,
                    'fpc_project_id'          => $project->fpc_project_id,
                    'requirements'            => $requirements,
                    'competitors'             => $competitors,
                    'term_name'               => $project->term_name,
                    'validity_disp'           => $project->validity_disp,
                    'competitor_flag'         => $project->competitor_flag,
                    'competitor_remarks'      => $project->competitor_remarks,
                    'print_fpc_url'           => url('/') . '/api/print-fpc/' . $project->fpc_project_id
                ];
                array_push($projects,$temp_arr);

                $projectIds .= $project->project_id . ';';
            }

       
            $subject = 'System Notification : FROS - Fpc No. ' . $row->fpc_id . ' | ' . $row->customer_name . ' | ' . $project->dealer_account;

            $mail->Subject = $subject;

        

            $content = [
                'fpc_header' => $row,
                'approve_link' => url('/') . '/api/fpc/approve/' . $row->approval_id,
                'reject_link' => url('/')  . '/api/fpc/reject/' . $row->approval_id,
                'inquiry_link' => url('/')  . '/api/fpc/inquiry/' . $row->approval_id,
                'fpc_projects' => $projects,
                'print_url' => url('/')  . '/api/fpc/project/print/',
                
            ];


       
            
            $mail->Body    = view('mail.fpc_approval', $content);
            $mail->isHTML(true);
            $mail->AddEmbeddedImage(config('app.project_root') . 'public/img/isuzu-logo-compressor.png', 'isuzu_logo');

            // uncomment this on go live
            
            // $mail->addAddress($row->email_address, $row->approver_name);	// Add a recipient, Name is optional
            
            // this is for testing purposes only
            //$mail->addAddress('jennifer-olivera@isuzuphil.com', 'Jen');	// Add a recipient, Name is optional
           // $mail->addAddress('mary-orias@isuzuphil.com', 'Mabeth');	// Add a recipient, Name is optional
            //$mail->addAddress('efhraim-reas@isuzuphil.com', 'Regan');	// Add a recipient, Name is optional

            $mail->addAddress('paul-alcabasa@isuzuphil.com');
            $mail->addBCC('paul-alcabasa@isuzuphil.com');
            $mailSend = $mail->Send();
            
            if($mailSend){
                // update notification status to sent
                $moduleApproval = ModuleApproval::findOrFail($row->approval_id);
                $moduleApproval->date_sent = Carbon::now();
                $moduleApproval->save();
            }

        }
    }

}