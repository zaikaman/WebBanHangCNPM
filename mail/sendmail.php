<?php

    include "PHPMailer/src/PHPMailer.php";
    include "PHPMailer/src/Exception.php";
    include "PHPMailer/src/OAuth.php";
    //include "PHPMailer/src/OAuthTokenProvider.php";
    include "PHPMailer/src/POP3.php";
    include "PHPMailer/src/SMTP.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
class Mailer {

    public function dathang($tieude,$noidung, $maildathang) {
        $mail = new PHPMailer(true);
        $mail->CharSet = "utf8";
        try{
            //server setting
            $mail -> SMTPDebug = 2; //Enable verbose debug output
            $mail -> isSMTP(); //Set mailer to use SMTP
            $mail -> Host='smtp.gmail.com'; //Specify main and backup SMTP servers
                $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true,
    ),
);
            $mail -> SMTPAuth = true; //Enable SMTP authentication
            $mail -> Username = 'luutrithon1996@gmail.com'; //SMTP username
            $mail -> Password = 'xwxx lyju spew lpvg'; //SMTP password
            $mail -> SMTPSecure ='tls'; //Enable TLS encryption, 'ssl' also accepted
            $mail -> Port = 587; // TCP port to connect to
    
            //recipients
            $mail ->setFrom('luutrithon1996@gmail.com','Mailer');
            $mail -> addAddress($maildathang,'Wolfdabest'); //Add a recipient
            $mail -> addAddress('nnt090904@gmail.com'); //Name is optional 
            //$mail -> addReplyTo('info@example.com','Information');
            $mail -> addCC('luutrithon1996@gmail.com');
            // $mail -> addBCC('bcc@example.com');
    
            //attachments
            // $mail -> addAttachment('/var/tmp/file.tar.gz'); //Add attachments
            // $mail -> addAttachment('/tmp/imgage.jgl','new.jpg'); //Optional name
    
            //content 
            $mail -> isHTML(true); //Set email format to HTML
            $mail -> Subject=$tieude;
            $mail -> Body = $noidung;
            //$mail -> AltBody='This is the body in plain text for non-HTML mail clients';
    
            $mail -> send();
            echo 'Message has been sent';
    
        } catch(Exception $e){
            echo 'Message could not be sent . Mailer Error: ', $mail -> ErrorInfo;
        }
    }
}
?>
