<?php
	function send_mail($r_mail,$s_mail,$s_name,$recipient_arr,$cc_arr,$bcc_arr,$subject,$body,$alt_body){
		$folder_depth_mail = "";
		$prefix_mail = "";
		
		$folder_depth_mail = substr_count($_SERVER["PHP_SELF"] , "/");
		$folder_depth_mail = ($folder_depth_mail == false) ? 2 : (int)$folder_depth_mail;
		
		$prefix_mail = str_repeat("../", $folder_depth_mail - 2);

		$prefix_mail = ($prefix_mail != "" || isset($prefix_mail)) ? $prefix_mail : "";
		
		require ($prefix_mail."phpmailer/PHPMailerAutoload.php");
		
		$mail_config = array();
		
		$mail_config_file = $prefix_mail.'config_local.ini';
		
		if (file_exists ($mail_config_file)){
			$mail_config = parse_ini_file($mail_config_file, true);
		}else{
			echo ('Can not find file: '.$mail_config_file.'<br>');
			die ('Mail configuration file doesn\'t exists.<br>');
		}
		
		if (!$mail_config){
			die ('Mail configuration file read error.<br>');
		}
		
		$mail_host = $mail_config['mail_settings']['host'];
		$mail_security_channel = $mail_config['mail_settings']['security_channel'];
		$mail_port = $mail_config['mail_settings']['port'];
		$mail_user = $mail_config['mail_settings']['username'];
		$mail_password = $mail_config['mail_settings']['password'];
		$mail_default_sender_email = $mail_config['mail_settings']['default_email'];
		$mail_default_sender_name = $mail_config['mail_settings']['default_name'];
		$mail_smtp = ($mail_config['mail_settings']['smtp'] == 1) ? true : false;
		$mail_authenticate = ($mail_config['mail_settings']['authenticate'] == 1) ? true : false;
	
		$bool_result = true;
		$msg_result = "";
		$mail_result = array();
		
		$r_mail = ($r_mail == NULL || empty($r_mail)) ? $mail_default_sender_email : $r_mail;
		$s_mail = ($s_mail == NULL || empty($s_mail)) ? $mail_default_sender_email : $s_mail;
		$s_name = ($s_name == NULL || empty($s_name)) ? $mail_default_sender_name : $s_name;
		
		$mail = new PHPMailer();
		
		//$mail->SMTPDebug = 3; // Uncomment this line to enable verbose debug output
		
		if ($mail_smtp){
			$mail->IsSMTP(); // send via SMTP
		}else{
			$mail->IsMail(); // send via Postfix Mail
		}
		
		$mail->Host = $mail_host;
		$mail->SMTPAuth = $mail_authenticate; // turn on SMTP authentication
		$mail->Username = $mail_user; // SMTP username
		$mail->Password = $mail_password; // SMTP password
		$mail->SMTPSecure = $mail_security_channel;
		$mail->Port = $mail_port;
		
		$mail->setFrom($s_mail, $s_name);
		$mail->addReplyTo($r_mail, $s_name);
		
		if (count($recipient_arr) > 0){
			foreach($recipient_arr as $rec_email => $rec_name){
			   $mail->addAddress($rec_email, $rec_name);
			}
			
			if ($bool_result){
				$bool_result = true;
			}
		}else{
			$bool_result = false;
			$msg_result .= "Empty recipients";
		}
		
		if (count($cc_arr) > 0){
			foreach($cc_arr as $cc_email => $cc_name){
			   $mail->addCC($cc_email, $cc_name);
			}
		}
		
		if (count($bcc_arr) > 0){
			foreach($bcc_arr as $bcc_email => $bcc_name){
			   $mail->addBCC($bcc_email, $bcc_name);
			}
		}
		
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional attachment
		
		$mail->isHTML(true);                                  // Set email format to HTML
		
		if (!empty($subject) || $subject != NULL){
			$mail->Subject = $subject;
			
			if ($bool_result){
				$bool_result = true;
			}
		}else{
			$bool_result = false;
			$msg_result .= "Empty recipients";
		}
		
		$mail->Body    = $body;
		$mail->AltBody = $alt_body;
		
		if ($bool_result){
			if(!$mail->send()) {
				$bool_result = false;
				$msg_result .= $mail->ErrorInfo;
			} else {
				$bool_result = true;
				$msg_result = "";
			}
		}
		
		$mail_result['result'] = $bool_result;
		$mail_result['message'] = $msg_result;
		
		return $mail_result;
	}
?>