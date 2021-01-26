<?php
require __DIR__ . "/vendor/autoload.php";

$mail = new Source\Email();
$mail->bootstrap("Meu assunto vem aqui", "Minha mensagem vem aqui", "email@destinatário.com", "Nome destinatário");
$mail->attach("path/img.jpg", "Nome do arquivo");

if (!$mail->send("de@email.com", "Meu e-mail")) {
    echo $mail->message()->render();
    return;
}

echo $mail->message()->success("E-mail enviado com sucesso")->render();
