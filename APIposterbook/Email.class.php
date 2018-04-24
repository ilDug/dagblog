<?php
require_once __DIR__ . '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
require_once __DIR__ . '/ServerResponse.class.php';

/**
 * classe per l'invio dimail con l'account FLATMAC
 */
class PBMail
{
    private $sender;
    private $pw;
    private $user;
    private $host;
    private $port;
    private $recipient;
    private $subject;
    private $body;


    function __construct($recipient, $subject, $body, $sender)
    {
		$this->recipient = $recipient;
		$this->subject = $subject;
		$this->body = $body;

        $this->host = "mail.posterbook.it ";
		$this->port = 25;


        switch ($sender) {
            case 'hello':
                $this->pw = 'LS1gptD9qHzm';
                $this->user = "hello@posterbook.it";
                $this->sender->address = "hello@posterbook.it";
                $this->sender->name="PosterBook";
                break;

            case 'support':
                $this->pw = 'MThyP8DTFChw';
                $this->user = "support@posterbook.it";
                $this->sender->address = "support@posterbook.it";
                $this->sender->name="Supporto PosterBook";
                break;

            case 'shop':
                $this->pw = 'T14TGCphWzPo';
                $this->user = "shop@posterbook.it";
                $this->sender->address = "shop@posterbook.it";
                $this->sender->name="PosterBook Shop";
                break;

            default:
                $this->pw = 'MThyP8DTFChw';
                $this->user = "support@posterbook.it";
                $this->sender->address = "support@posterbook.it";
                $this->sender->name="Supporto PosterBook";
                break;
        }

    }




    /**
     * invia la mail e ritorna il risultato della risposta
     */
    public function send(){
        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        //Tell PHPMailer to use SMTP
        //                                      $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';


        //Set the hostname of the mail server
        $mail->Host = $this->host;
        //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->Port = $this->port;
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication
        $mail->Username = $this->user;
        //Password to use for SMTP authentication
        $mail->Password = $this->pw;
        //Set who the message is to be sent from
        $mail->setFrom($this->sender->address, $this->sender->name);


        //Set an alternative reply-to address
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //Set who the message is to be sent to
        $mail->addAddress($this->recipient);
        //Set the subject line
        $mail->Subject = $this->subject;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML($this->body);
        //Replace the plain text body with one created manually
        $mail->AltBody = 'error - Please, try read this mail in a HTML reader';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.png');


        //send the message, check for errors
        if (!$mail->send()) {
                $delivery = new ServerResponse(false,  $mail->ErrorInfo);
        } else {
                $delivery = new ServerResponse(true,  "Message sent!");
        }

        $mail->SmtpClose();
        unset($mail);
        return $delivery;
    }


}//chide classe
 ?>
