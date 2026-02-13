<?php
	ini_set('log_errors', true);
	ini_set('error_log', 'logs/ipn_errors.log');

	include('ipnlistener.php');

	define("KERNEL","../../");
	define("ROOT","http://gclearning.pt");
	define("HOST", "localhost");     // The host you want to connect to.
	define("USER", "adotinne_alunos");    // The database username.
	define("PASSWORD", "5,TfdB$13_Ve");    // The database password.
	define("DATABASE", "adotinne_alunos");    // The database name.


	include_once (KERNEL.'tools.php');
	include_once (KERNEL.'basedados.php');


	$BD = new BaseDeDados;
	$listener = new IpnListener;

	$listener->use_sandbox = false;
	$listener->force_ssl_v3 = false;
	$listener->use_ssl = true;

	/*
	$curl_info = curl_version();
	error_log("#######".$curl_info['ssl_version']."###############");
	*/

	try {

		$listener->requirePostMethod();
		$verified = $listener->processIpn();

	} catch (Exception $e) {
		//error_log($listener->getTextReport());
		error_log(date('[Y-m-d H:i e] '). $e->getMessage());
		exit(0);
	}

	if ($verified) {
		
		$hash = $listener->getCustomField();
        
		$pergunta2 = "INSERT INTO transactions_paypal VALUES (0,'".$hash."','".$listener->getPayer()."','".$listener->getTxnId()."','".$listener->getVerifySign()."',NOW() );";
        $BD->Pergunta($pergunta2);
  
       	$pergunta="UPDATE licenca SET  inicio = now() WHERE hash = '".$hash."';";
        $BD->Pergunta($pergunta);
       
		$pergunta="SELECT * FROM `licenca` WHERE hash = '".$hash."';";
        $BD->Pergunta($pergunta);
        $licenca=$BD->ResultadoSeguinte();
		
        $pergunta="UPDATE membros SET activo = 1 WHERE id = ".$licenca['user_id'].";";
        $BD->Pergunta($pergunta);
		
		error_log($pergunta2);
	} else {
		error_log(date('[Y-m-d H:i e] '). $listener->getTextReport());
	}

	$BD->Fechar();

?>
