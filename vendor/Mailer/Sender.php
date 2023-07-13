<?php
namespace Mailer;

require 'vendor/phpmailer/class.phpmailer.php';
require 'vendor/phpmailer/class.smtp.php';

Class Sender {

    static public function runtest() {
        $data = [
            'destinatario' => 'rafadinix@gmail.com',
            'assunto' => 'ASSUNTO TESTE',
            'mensagem' => 'MENSAGEM TESTE',
            'responder' => ''
        ];
        echo '<p><b>Sender</b>: Enviando Email...</p>';
        //self::mail($data);
    }

    static public function mail($data) {
        $host = (new \Orm('smtp'))->get()[0];
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = 3;
        $mail->tls = 1;
        //$mail->Debugoutput = 'html';        
        $mail->SMTPAuth = true;
        $mail->Port = $host->smtp_port;;
        $mail->Host = $host->smtp_host;;
        $mail->Username = $host->smtp_username;
        $mail->Password = $host->smtp_password;
        $mail->setFrom($host->smtp_username, utf8_decode($host->smtp_fromname));
        if (isset($data['responder']) && !empty($data['responder'])) {
            $mail->addReplyTo($data['responder']);
        }
        if (isset($data['copia']) && is_array($data['copia'])) {
            foreach ($data['copia'] as $copia) {
                $mail->addAddress("$copia");
            }
        }
        $mail->addAddress($data['destinatario']);
        $mail->Subject = utf8_decode($data['assunto']);
        //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
        $mail->msgHTML(utf8_decode($data['mensagem']));
        $mail->AltBody = '';
        //$mail->addAttachment('images/phpmailer_mini.png');
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            //echo 1;
        }
    }

}
