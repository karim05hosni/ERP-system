<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class mail {
    private $to;
    private $subject;
    private $message;
    public function __construct($to, $subject, $message) {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
    }
    public function send():bool{
        $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'kokehosny9@gmail.com';               //SMTP username
                $mail->Password   = 'wpwa qmeq ideq rayl';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('kokehosny9@gmail.com', 'Ecommerce');
                $mail->addAddress("$this->to");               //Name is optional

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = "$this->subject";
                $mail->Body    = "$this->message";

                $mail->send();
                echo 'Message has been sent';
                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                return false;
            }
        }
    }
