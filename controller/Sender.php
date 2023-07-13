<?php

require 'vendor/phpmailer/class.phpmailer.php';
require 'vendor/phpmailer/class.phpmaileroauth.php';
require 'vendor/phpmailer/class.phpmaileroauthgoogle.php';
require 'vendor/phpmailer/class.smtp.php';
require 'vendor/phpmailer/class.pop3.php';

Class Sender {

    public function __construct()
    {
        
    }

    static public function contato() {
        $nome = Req::post('con_name','string');
        $email = Req::post('con_email','string');
        $fone = Req::post('con_tel','string');
        $assunto = Req::post('con_title','string');
        $msg = Req::post('con_message','string');
        $body = "";
        $body .= "Nome:  $nome <br>";
        $body .= "Email:  $email <br>";
        $body .= "Fone:  $fone <br>";
        $body .= "Fone:  $fone <br>";
        $body .= "Mensagem: $msg";

        $data = [
            'destinatario' => "",
            'assunto' => $assunto,
            'mensagem' => $body,
            'responder' => ''
        ];
      
        self::mail($data);

    }    

    // static public function __runtest() {
    //     $data = array(
    //         'destinatario' => 'paulacavalcantedeoliveira@gmail.com',
    //         'assunto' => 'ASSUNTO TESTE',
    //         'mensagem' => 'MENSAGEM TESTE',
    //         'responder' => ''
    //     );
    //     self::mail($data);
    // }

    static public function mail($data) {
        try {
            $host = (new Orm('smtp'))->find(1);

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            if($host->smtp_secure == 2){
                $mail->SMTPSecure = 'ssl';
            }
            if($host->smtp_secure == 3){
                $mail->SMTPSecure = 'tls';
            }
            $mail->SMTPAuth = true;
            $mail->Port = $host->smtp_port;
            $mail->Host = $host->smtp_host;
            $mail->Username = $host->smtp_email;
            $mail->Password = $host->smtp_pass;
            $mail->setFrom($host->smtp_email, $host->smtp_nome);
            
            $mail->addAddress($data['destinatario']);
            $mail->Subject = utf8_decode($data['assunto']);
            $mail->msgHTML(utf8_decode($data['mensagem']));
            $mail->AltBody = '';

            if (!$mail->send()) {
                throw new Exception("Mailer Error: " . $mail->ErrorInfo);
            } else {
                return ['status' => 'success'];
            }

        } catch(Exception $e) {
            return ['status' => 'error', 'msg' => $e->getMessage()];
        }

    }

    static public function __mail($data)
    {
        $host = (new Orm('smtp'))->find(1);
        $from = $host->smtp_email;
        $from_name = $host->smtp_nome;
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From: {$from_name} <{$from}>";
        $assunto = $data['assunto'];
        $msg = $data['mensagem'];
        $destinatario = $data['destinatario'];
        ini_set("SMTP", $host->smtp_host);
        ini_set("smtp_port", $host->smtp_port);
        return mail($destinatario, $assunto, $msg, implode("\r\n", $headers));
        
    }

    public function test() {
        $send = Sender::mail([
            'destinatario' => "pedro.marcos.etec@gmail.com",
            'assunto' => "Imobiliária - Contato via Site",
            'mensagem' => "eita nois",
        ]);

        echo json_encode($send);
    }
}
