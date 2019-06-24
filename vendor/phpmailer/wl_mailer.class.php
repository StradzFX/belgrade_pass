<?php



require_once('PHPMailer.php');
require_once('SMTP.php');


class wl_mailer{

    private $mail_obj = NULL;
    private $send_to_admin = false;
    private $admin_email = "";
    private $subject = "";
    private $html_email_content = "";
    private $send_to_email = array();
    private $send_to_cc = array();
    private $send_to_bcc = array();
    private $send_attachments = array();
    private $send_images = array();
    private $plain_email_content = "";

    public function __construct($username = '', $password = '', $sent_from = array('', ''), $reply_to = array('', ''), $host = 'mailcluster.loopia.se', $port = 25, $priority = 3, $char_set = 'UTF-8', $SMTPSecure = null){

        $this->mail_obj = new PHPMailer(true);
        $this->mail_obj->IsSMTP();
        $this->mail_obj->Username = $username;
        $this->mail_obj->Password = $password;
        $this->mail_obj->Host = $host;
        $this->mail_obj->Port = $port;
        $this->mail_obj->CharSet = $char_set;
        $this->mail_obj->Priority = $priority;
        $this->mail_obj->SMTPDebug = 0;
        $this->mail_obj->SMTPAuth = true;
        if($SMTPSecure){
             $this->mail_obj->SMTPSecure = $SMTPSecure;  
        }
        $this->mail_obj->AddReplyTo($reply_to[0], $reply_to[1]);
        $this->mail_obj->SetFrom($sent_from[0], $sent_from[1]);

        /*$this->mail_obj->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );*/
    }

    public function start_debugger(){
        $this->mail_obj->SMTPDebug = 1;
    }



    public function stop_debugger(){
        $this->mail_obj->SMTPDebug = 0;
    }



    public function set_subject($subject){
        $this->subject = $subject;
    }



    public function set_email_content($content){
        $this->html_email_content = $content;
    }



    public function add_admin($admin_email){
        $this->send_to_admin = true;
        $this->admin_email = $admin_email;
    }



    public function add_address($send_to_email, $send_to_email_name){
        $this->send_to_email[] = array($send_to_email, $send_to_email_name);
        $this->mail_obj->AddAddress($send_to_email, $send_to_email_name);
    }



    public function add_to_cc($send_to_email, $send_to_email_name){
        $this->send_to_cc[] = array($send_to_email, $send_to_email_name);
        $this->mail_obj->AddCC($send_to_email, $send_to_email_name);
    }



    public function add_to_bcc($send_to_email, $send_to_email_name){
        $this->send_to_bcc[] = array($send_to_email, $send_to_email_name);
        $this->mail_obj->AddBCC($send_to_email, $send_to_email_name);
    }



    public function add_image($image_path, $cid_name, $image_name){
        $this->send_images[] = array("image_url" => $image_path, "cid_name" => $cid_name, "name" => $image_name);
    }



    public function add_attachment($attachment_path, $attachment_name){
        $this->send_attachments[] = array("attachment_path" => $attachment_path, "attachment_name" => $attachment_name);
    }



    public function send_email(){
        if($this->send_to_admin){
            $this->mail_obj->AddBCC($this->admin_email, '');
        }

        $this->mail_obj->Subject = $this->subject;
        $this->mail_obj->AltBody = $this->plain_email_content;
        $this->mail_obj->MsgHTML($this->html_email_content);

        if(sizeof($this->send_images) > 0){
            for($i = 0; $i < sizeof($this->send_images); $i++){
                $this->mail_obj->AddEmbeddedImage($this->send_images[$i]["image_url"], $this->send_images[$i]["cid_name"], $this->send_images[$i]["name"]);
            }
        }

        if(sizeof($this->send_attachments) > 0){
            for($i = 0; $i < sizeof($this->send_attachments); $i++){
                $this->mail_obj->AddAttachment($this->send_attachments[$i]["attachment_path"], $this->send_attachments[$i]["attachment_name"]);
            }
        }

        try{
            $this->mail_obj->Send();
            $this->mail_obj->ClearAddresses();
            $this->mail_obj->ClearAttachments();
        }catch(phpmailerException $e){
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
        }catch(Exception $e){
         echo $e->getMessage(); //Boring error messages from anything else!
        }
    }
}