## Envio de e-mail com uma abstração da classe PHPMailer.

**Para usar é necessário baixar a classe PHPMailer com o composer:**

```json
"require": {  
  "phpmailer/phpmailer": "~6.0"  
}
```
**Para consumir as classes usei o autoload do composer:**

```php
require __DIR__ . "/vendor/autoload.php";
```

```php
$mail = new Source\Email();
```

**Ao instanciar a classe Email que é uma abstração da PHPMailer, o construtor já configura boa parte da classe, sem a necessidade de se repetir a cada necessidade de envio de e-mail em partes de um sistema.**

```php
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
```

**Para configurar o assunto, o conteúdo, o destinatário e o e-mail do destinatário, use o método bootstrap:**

```php
$mail->bootstrap("Meu assunto vem aqui", "Minha mensagem vem aqui", "email@destinatário.com", "Nome destinatário");
```

**Para envio de anexo,  use attach:**
```php
$mail->attach("path/img.jpg", "Nome do arquivo");
```

**Para finalmente enviar, use o método send:**

```php
$mail->attach("path/img.jpg", "Nome do arquivo");
```








