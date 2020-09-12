<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem{
        private $para = null;
        private $assunto = null;
        private $mensagem = null;
        public $status = array('codigo_status' => null, 'descricao_status' => '');

        public function __get($atributo){
            return $this->$atributo;
        }
        public function __set($atributo, $valor){
            return $this->$atributo = $valor;
        }

        public function MensagemValida(){
            if(empty($this->para) || empty($this->assunto) || empty($this->assunto)){
                return false;
            }

            return true;

        }



    }

    $M = new Mensagem();

    $M->__set('para', $_POST['para']);
    $M->__set('assunto', $_POST['assunto']);
    $M->__set('mensagem', $_POST['mensagem']);

    if(!$M->MensagemValida()){
        echo 'Mensagem não valida';
        header('Location: index.php');
    }        

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = false;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'pedro6489@gmail.com';                 // SMTP username
        $mail->Password = 'Pedro.10@';                           // SMTP password
        $mail->SMTPSecure = 'TLS';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('pedro6489@gmail.com', 'Pedro Henique');
        $mail->addAddress($M->__get('para'));     // Add a recipien 
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //  $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $M->__get('assunto');
        $mail->Body    = $M->__get('mensagem');
        $mail->AltBody = 'É nescessario que Utilize um client que suporte HTML pra ter acesso total para o conteudo';

        $mail->send();  
        $M->status['codigo_status'] = 1;
        $M->status['descricao_status'] = 'E-mail enviado com Sucesso';
    } catch (Exception $e) {
        $M->status['codigo_status'] = 2;
        $M->status['descricao_status'] = 'Não foi Possivel Enviar Detalhe Error: ' . $mail->ErrorInfo;
    }

    ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>

    <div id="container">

        <div class="py-3 text-center">
            <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
            <h2>Send Mail</h2>
            <p class="lead">Seu app de envio de e-mails particular!</p>
        </div>

        <div class="row">

            <div class="col-md-12">

                <?php if($M->status['codigo_status'] == 1) { ?>
                <div class="container">
                    <h1 class="display-4 text-success">Sucesso</h1>
                    <p><?= $M->status['descricao_status']?></p>
                    <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                </div>
                <?php } ?>

                <?php if($M->status['codigo_status'] == 2) { ?>
                <div class="container">
                    <h1 class="display-4 text-danger">Sucesso</h1>
                    <p><?= $M->status['descricao_status']?></p>
                    <a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                </div>
                <?php } ?>


            </div>

        </div>

    </div>

</body>

</html>