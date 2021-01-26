<?php

namespace Source;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class Email
{
    private $data;

    private $mail;

    private $message;


    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->data = new \stdClass();
        $this->message = new Message();

        //setup
        $this->mail->isSMTP();
        $this->mail->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->mail->isHTML(CONF_MAIL_OPTION_HTML);
        $this->mail->SMTPAuth = CONF_MAIL_OPTION_AUTH;
        $this->mail->SMTPSecure = CONF_MAIL_OPTION_SECURE;
        $this->mail->CharSet = CONF_MAIL_OPTION_CHARSET;

        //auth
        $this->mail->Host = CONF_MAIL_HOST;
        $this->mail->Port = CONF_MAIL_PORT;
        $this->mail->Username = CONF_MAIL_USER;
        $this->mail->Password = CONF_MAIL_PASS;
    }


    public function bootstrap(string $subject, string $body, string $recipient, string $recipientName): Email
    {
        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->recipient_email = $recipient;
        $this->data->recipient_name = $recipientName;
        return $this;
    }


    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }


    public function send(string $from = CONF_MAIL_SENDER['address'], string $fromName = CONF_MAIL_SENDER["name"]): bool
    {
        if (empty($this->data)) {
            $this->message->error("Erro ao enviar, favor verifique os dados");
            return false;
        }

        if (!is_email($this->data->recipient_email)) {
            $this->message->warning("O e-mail de destinatário não é válido");
            return false;
        }

        if (!is_email($from)) {
            $this->message->warning("O e-mail de remetente não é válido");
            return false;
        }

        try {
            $this->mail->Subject = $this->data->subject;
            $this->mail->msgHTML($this->data->body);
            $this->mail->addAddress($this->data->recipient_email, $this->data->recipient_name);
            $this->mail->setFrom($from, $fromName);

            if (!empty($this->data->attach)) {
                foreach ($this->data->attach as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();
            return true;
        } catch (Exception $exception) {
            $this->message->error($exception->getMessage());
            return false;
        }
    }

    public function mail(): PHPMailer
    {
        return $this->mail;
    }

    public function message(): Message
    {
        return $this->message;
    }
}