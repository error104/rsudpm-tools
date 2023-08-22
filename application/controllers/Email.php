<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require APPPATH . 'libraries/PHPMailer/src/Exception.php';
require APPPATH . 'libraries/PHPMailer/src/PHPMailer.php';
require APPPATH . 'libraries/PHPMailer/src/SMTP.php';
class Email extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /*   $this->load->model([
            'mdokumen' => 'md'
        ]); */
    }
    public function index()
    {

        $content = $this->load->view('email/index', '', true);
        $data['contentBody'] = $content;
        $this->load->view('layout', $data);
    }
    public function kirim()
    {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->input->post('smtphost');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->input->post('smtpuser');                     //SMTP username
            $mail->Password   = $this->input->post('smtppass');                               //SMTP password
            $mail->SMTPSecure = $this->input->post('smtpsecure');            //Enable implicit TLS encryption
            $mail->Port       = $this->input->post('smtpport');     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->input->post('smtpuser'));
            $mail->addAddress($this->input->post('emailto'), $this->input->post('emailto'));     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $this->input->post('emailsubject');
            $mail->Body    = $this->input->post('emailmessage');

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
