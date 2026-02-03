<?php

	require_once('mail/class.phpmailer.php');
	require_once('mail/class.smtp.php');

    function enviaMail($to,$subject,$msg){

    	//Create a new PHPMailer instance
		$mail = new PHPMailer();

        // Define os dados do servidor e tipo de conexão
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = MAIL_HOST; // Endereço do servidor SMTP
        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $mail->Username = MAIL_USER; // Usuário do servidor SMTP
        $mail->Password = MAIL_PASS; // Senha do servidor SMTP

        //$mail->SMTPDebug = 2;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Define o remetente
        $mail->From = MAIL_USER; // Seu e-mail
        $mail->FromName = MAIL_UTIL; // Seu nome

        // Define os destinatário(s)
        $mail->AddAddress($to);
        //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
        //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

        // Define os dados técnicos da Mensagem
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        // Define a mensagem (Texto e Assunto)
        $mail->Subject  = mb_convert_encoding($subject, "latin1", "auto"); // Assunto da mensagem
        $mail->Body = wordwrap(mb_convert_encoding($msg, "latin1", "auto"),70);

        // Define os anexos (opcional)
        //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

        // Envia o e-mail
        $enviado = $mail->Send();

        // Limpa os destinatários e os anexos
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();

        // Exibe uma mensagem de resultado
        if ($enviado) {
			$_SESSION['type'] = "I";
			$_SESSION['msg'] = "Email enviado com sucesso.";
            return true;
        } else {
		    $_SESSION['type'] = "E";
			$_SESSION['msg'] = "Erro no envio de email! ". $mail->ErrorInfo;
			return false;
        }

	}

	function enviaMailDe($to,$subject,$msg,$from,$fromMail){

    	//Create a new PHPMailer instance
		$mail = new PHPMailer();

        // Define os dados do servidor e tipo de conexão
        $mail->IsSMTP(); // Define que a mensagem será SMTP
        $mail->Host = MAIL_HOST; // Endereço do servidor SMTP
        $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
        $mail->Username = MAIL_USER; // Usuário do servidor SMTP
        $mail->Password = MAIL_PASS; // Senha do servidor SMTP

        //$mail->SMTPDebug = 2;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Define o remetente
        $mail->From = MAIL_USER; // Seu e-mail
        $mail->FromName = MAIL_UTIL; // Seu nome

        $mail->ClearReplyTos();
        $mail->addReplyTo($fromMail, mb_convert_encoding($from, "latin1", "auto"));

        // Define os destinatário(s)
        $mail->AddAddress($to);
        //$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
        //$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

        // Define os dados técnicos da Mensagem
        $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
        //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

        // Define a mensagem (Texto e Assunto)
        $mail->Subject  = mb_convert_encoding($subject, "latin1", "auto"); // Assunto da mensagem
        $mail->Body = wordwrap(mb_convert_encoding($msg, "latin1", "auto"),70);

        // Define os anexos (opcional)
        //$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

        // Envia o e-mail
        $enviado = $mail->Send();

        // Limpa os destinatários e os anexos
        $mail->ClearAllRecipients();
        $mail->ClearAttachments();

        // Exibe uma mensagem de resultado
        if ($enviado) {
			return true;
        } else {
		    $_SESSION['type'] = "E";
			$_SESSION['msg'] = "Erro no envio de email! ". $mail->ErrorInfo;
			return false;
        }

	}
?>  
