<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: mail.php
 * Created On: Aug 5, 13
 * Created by: Muhammad Rizwan
 * Description: This library uses phpmailer to send emails
 * ---------------------------------------------------------------------------------------
 */
 
/*
	a small mailer script to send spam-free messages
*/
require_once ("libPhpmailer/class.smtp.php");
require_once ("libPhpmailer/class.phpmailer.php");

class mail
{
	var $body;
	var $from;
	var $from_name;
	var $to;
	var $attachment;
	var $subject;
	var $use_smtp 		= true;
	var $base_url 		= "";
	var $images_path 	= "";	
	
	function send_mail()
	{		
		$headers = "From: $this->from \r\n";
		$headers.= "Content-Type: text/html; charset=ISO-8859-1 ";
		$headers .= "MIME-Version: 1.0 ";
		//mail($this->to, $this->subject, $this->body, $headers);
		
		$mail = new PHPMailer();
		
		if($this->use_smtp==true)
		{
			$CI =& get_instance();
			$settings = $CI->config->item('email');						
			
			$mail->IsSMTP(); // send via SMTP
			$mail->Host 	= $settings['smtp_host']; 		// SMTP servers
			$mail->Port		= 25;
			$mail->SMTPAuth = true;     					// turn on SMTP authentication
			$mail->Username = $settings['smtp_username'];  	// SMTP username
			$mail->Password = $settings['smtp_password']; 	// SMTP password
		}
		

		$mail->From     = $this->from;
		$mail->FromName = $this->from_name;
		$mail->AddAddress($this->to);
		//$mail->AddReplyTo(SMTP_USER,"Information");
		$mail->IsHTML(true);								// send as HTML
		
		$mail->Subject  =  $this->subject;								
		
		if($this->attachment != '')				
			$mail->AddAttachment($this->attachment);
		
		// do we want to send pretty emails :-*
		if (SEND_PRETTY_EMAILS)
		{
			// yes we do :D :D :D
			$pretty_email = "
							<html>
							<head>
								<style>
									/* CSS Document */
									a{
										color:#4276c9;
									}
								</style>
								<title>Email Template</title>
							</head>
							<body style='margin:0px; padding:0px;'>
								<table width='100%' style='background-color:#fff; color:#333; font-family:Arial; font-size:12px;'>
									<tr>
										<td style='margin-bottom:25px;' >
											<!--<img src='". SITE_URL . IMG_PATH . "/strip.png' />-->
										</td>
									</tr>
								<tr>
									<td style='padding-left:10px;'>" . $this->body . "</td>
								</tr>
								<tr>
									<td style='margin-bottom:25px;' >
										&nbsp;
									</td>
								</tr>
								<tr>
									<td style='margin-bottom:25px; padding-left:10px;' >
										Regards,
									</td>
								</tr>
								<tr>
									<td style='margin-top:25px; height:70px; background-color:#fff; text-align:left;
										padding-left:10px; font-weight:bold; color:#6C6C6C;'>
										<span style='color:#3263AF;'>". SITE_TITLE ."</span> &copy; ".date("Y")."
									</td>
								</tr>
								</table>
							</body>
							</html>";
			
			$mail->Body = $pretty_email;
		}
		else
		{
			$mail->Body = $this->body;
		}
		
		if(!$mail->Send())
			return false;
		else
			return true;
		
	}

}


?>
