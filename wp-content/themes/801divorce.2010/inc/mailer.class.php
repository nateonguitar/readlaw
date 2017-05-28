<?php
class Mailer {
	
	function Mailer($bSmtp=true) {
		$this->bHtml = true;
		$this->bSmtp = $bSmtp;
		$this->strSubject = '';
		$this->strMessage = '';
		$this->strFrom = '';
		$this->arTo = array();
		$this->arBcc = array();
		$this->arCc = array();
		$this->arReplyTo = array();
		$this->strDomainName = str_replace('www.','',$_SERVER['HTTP_HOST']);
		$this->strUploadDir = '';
		$this->strStatus = 'Send not attempted';
		$this->iTimeOffsetHours = 0;
		$this->bLogMessages = false;
		$this->pathToCsvLogFile = $_SERVER['DOCUMENT_ROOT'].'contact'.DIRECTORY_SEPARATOR.'log.csv';
		
		if ($this->bSmtp) {
			require_once dirname(__FILE__) . '/smtp.class.php';
			$this->smtp = new smtp_class;
			
			$this->smtp->host_name = 'localhost'; /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
			$this->smtp->host_port= 25;           /* Change this variable to the port of the SMTP server to use, like 465 */
			$this->smtp->ssl = 0;                 /* Change this variable if the SMTP server requires an secure connection using SSL */
			$this->smtp->localhost = 'localhost'; /* Your computer address */
			$this->smtp->timeout = 100;           /* Set to the number of seconds wait for a successful connection to the SMTP server */
			$this->smtp->debug = 0;               /* Set to 1 to output the communication with the SMTP server */
			$this->smtp->html_debug = 1;          /* Set to 1 to format the debug output as HTML */
			$this->smtp->pop3_auth_host = '';     /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
			$this->smtp->user = '';               /* Set to the user name if the server requires authetication */
			$this->smtp->realm = '';              /* Set to the authetication realm, usually the authentication user e-mail domain */
			$this->smtp->password = '';           /* Set to the authetication password */
			$this->smtp->workstation = '';        /* Workstation name for NTLM authentication */
			$this->smtp->authentication_mechanism= '';	/* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc.. Leave it empty to make the class negotiate if necessary */
		}
	}
	
	function sendMail() {
		// Check requirements
		if (empty($this->strMessage)) { $this->strMessage = 'Email is missing a message'; return false; }
		if (empty($this->strSubject)) { $this->strMessage = 'Email is missing a subject'; return false; }
		if (count($this->arTo) < 1) { $this->strMessage = 'Email is missing a To: address'; return false; }
		
		if (count($this->arCc) > 0) {
			$arHeaders[] = 'Cc: '.implode(';',$this->arCc);
		}
		
		if (count($this->arBcc) > 0) {
			$arHeaders[] = 'Bcc: '.implode(';',$this->arBcc);
		}
		
		if (count($this->arReplyTo) > 0) {
			$arHeaders[] = 'Reply-to: '.implode(';',$this->arReplyTo);
		}
		
		//Write to a log file if requested
		if ($this->bLogMessages) {
			$this->writeMessageToCsvLog();
		}
		
		if ($this->bSmtp) {
		/* SMTP MAILER */
			$arHeaders = array(
				'From: '.$this->strFrom,
				'To: '.implode(';',$this->arTo),
				'Date: '.strftime("%a, %d %b %Y %H:%M:%S %Z"),
				'Subject: '.$this->strSubject
			);
			if ($this->bHtml) {
				$arHeaders[] = 'Content-type:text/html;charset=utf-8';
			}
			
			$bSuccess = $this->smtp->SendMessage($this->strFrom,$this->arTo,$arHeaders,$this->strMessage);
			
			if ($bSuccess) {
				$this->strStatus = 'SMTP Mailer successfully sent';
				return true;
			} else {
				$this->strStatus = 'SMTP Mailer returned false';
				return false;
			}
		} else {
		/* PHP MAILER */
			$strHeaders  = 'From: '.$this->strFrom."\n";
			$strHeaders .= 'Date: '.strftime("%a, %d %b %Y %H:%M:%S %Z")."\n";
			if ($this->bHtml) {
				$strHeaders .= 'Content-type:text/html;charset=utf-8'."\n";
			}
			
			$strTo = implode(",",$this->arTo);
			$bSuccess = mail($strTo, $this->strSubject, $this->strMessage, $strHeaders);
			
			if ($bSuccess) {
				$this->strStatus = 'PHP Mailer successfully sent';
				return true;
			} else {
				$this->strStatus = 'PHP Mailer returned false';
				return false;
			}
		}
		
		
	}
	
	function addSubject($subject) {
		$this->strSubject .= $subject;
	}
	
	function addMessage($message) {
		$this->strMessage .= $message;
	}
	
	function addFrom($email) {
		$this->strFrom = $email;
	}
	
	function addTo($email) {
		$this->arTo[] = $email;
	}
	
	function addCc($email) {
		$this->arCc[] = $email;
	}
	
	function addBcc($email) {
		$this->arBcc[] = $email;
	}
	
	function addReplyTo($email) {
		$this->arReplyTo[] = $email;
	}
	
	function generateFormPreloadJS() {
		$arCommands = array();
		foreach($_POST as $key => $value) {
			$arCommands[] = "\$('#$key').val('". str_replace("'","\'",$value) ."')";	
		}
		$strJS  = '<script type="text/javascript" charset="utf-8">'."\r\n";
		$strJS .= '	$(document).ready(function(){'."\r\n";
		$strJS .= implode(';',$arCommands);
		$strJS .= '	});'."\r\n";
		$strJS .= '</script>'."\r\n";
		return $strJS;
	}
	
	function addParsedPostDataToMessage() {
		unset($_POST['action']);
		unset($_POST['submit_x']);
		unset($_POST['submit_y']);
		
		// HANDLE FILE UPLOADING:
		if (!empty($this->strUploadDir)) {
			if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $this->strUploadDir)) {
				die('Class Error::MailBuilder::Path "'.$_SERVER['DOCUMENT_ROOT'].$this->strUploadDir.'" does not exist.');
			} else {
				foreach($_FILES as $key => $arFile) {
					$filename = basename($arFile['name']);
					$filedestination = $_SERVER['DOCUMENT_ROOT'] . $this->strUploadDir . $filename;
					$filedestinationURL = $this->strUploadDir . $filename;
					if (is_uploaded_file($arFile['tmp_name']) && move_uploaded_file($arFile['tmp_name'], $filedestination)) {
						$_POST[$key] = "http://".$this->strDomainName."/$filedestinationURL";
					}
				}
			}
		}
		
		$strMessage = '';
		
		$strHeadline = $this->strSubject;
		
		$arParsedEmails = array();
		
		$arCleanedValues = array();
		foreach($_POST as $key => $value) {
			if ($key == 'pv' || $key == 'action') continue;
			if (strlen($value) == 0) $value = 'not specified';
			$title = ucwords(strtr($key,"_"," "));
			//Handle Arrays
			if (is_array($value)) $value = implode(', ',$value);
			
			//Handle Email Addresses
			$strEmailRegex = '/([a-z0-9_\.\-]+@[a-z0-9_\-]+\.[a-z]{2,3}(\.[a-z]{2})?)/i';
			$iEmailCount = preg_match_all($strEmailRegex,$value,$arEmailMatches);
			if ($iEmailCount > 0) {
				foreach ($arEmailMatches[0] as $email_match) $arParsedEmails[] = $email_match;
			}
			
			$arCleanedValues[$title] = $value;
		}
		
		if ($this->bHtml) {
			//Define Mail styles
			$styleH1 = 'style="font-size: 22px; font-family: Helvetica, Arial, sans-serif; color: #3f3f3f"';
			$styleH2 = 'style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #5f5f5f"';
			$styleP = 'style="font-size: 14px; font-family: Helvetica, Arial, sans-serif; color: #5f5f5f"';
			$styleTable = 'cellpadding="5" border="0" cellspacing="0"';
			$styleTD1 = 'font-style:bold; font-size:12px; font-family: Helvetica, Arial, sans-serif; width:150px; color: #5f5f5f;';
			$styleTD2 = 'font-size:12px; font-family: Helvetica, Arial, sans-serif; width:400px; color:black;';
			$styleBorder = 'border-top:1px solid #9F9F9F;';
			$styleSpan = 'style="FONT: 12px Helvetica, Arial, sans-serif; COLOR: #3f3f3f"';
			$styleTextarea = 'width:100%;height:50px;border:1px dashed #fff;background-color:#ccc;';
			
			// ASSEMBLE MESSAGE
			$strMessage .= '<h1 '.$styleH1.'>'.$strHeadline.'</h1>'."\r\n";
			$strMessage .= "<h2 $styleH2>Received ". date('l F j, Y \a\t g:i a',$this->getOffsetTime()). '</h2>'."\r\n";
			
			if (!empty($this->strCustomMessage)) {
				$strMessage .= "<p $styleP>".trim($this->strCustomMessage).'</p>';
			}
			
			$strMessage .= "<table $styleTable>\n";
			$lineCount = 1;
			$arDataTransfer = array();
			
			foreach($arCleanedValues as $title => $value) {
				
				$strValue = $value;
				
				//Link Web Addresses
				$strValue = preg_replace('/(http:\/\/[^ ]*)/','<a href="$1">$1</a>',$value);
				
				//Link Email Addresses
				$strEmailRegex = '/([a-z0-9_\.\-]+@[a-z0-9_\-]+\.[a-z]{2,3}(\.[a-z]{2})?)/i';
				$iEmailCount = preg_match_all($strEmailRegex,$value,$arEmailMatches);
				if ($iEmailCount > 0) {
					$strValue = preg_replace($strEmailRegex,'<a href="mailto:$1">$1</a>',$value);
				}
				
				//Format Phone
				if (strpos(strtolower($title),'phone') !== false) {
					$strValue = $this->formatPhone($value);
				}
				
				if ($lineCount == 1) {
					$strMessage .= "<tr valign=\"top\"><td style=\"$styleTD1\">$title</td>\n";
					$strMessage .= "<td  style=\"$styleTD2\">$strValue</td></tr>\n";
				} else {
					$strMessage .= "<tr valign=\"top\"><td style=\"$styleTD1 $styleBorder\">$title</td>\n";
					$strMessage .= "<td style=\"$styleTD2 $styleBorder\">$strValue</td></tr>\n";
				}
				
				$arDataTransfer[] = $value;
				
				$lineCount++;
			}
			$strMessage .= '</table><br>';
			
			$strDataTransfer = implode("\t",$arDataTransfer);
			$strMessage .= "<p $styleP>If you would like to easily collect the information from this email into a spreadsheet, simply select all of the following text, copy it and paste it into your spreadsheet application.</p>";
			$strMessage .= "<textarea style=\"$styleTextarea\">$strDataTransfer</textarea>";
			
			$this->strMessage .= $strMessage;
			
		} else {
			$strMessage .= strtoupper($strHeadline)."\r\n\r\n";
			$strMessage .= "Received ". date('l F j, Y \a\t g:i a',$this->getOffsetTime())."\r\n\r\n";
			foreach($arCleanedValues as $title => $value) {
				$strMessage .= "$title: $value\r\n";
			}
			
			$this->strMessage .= $strMessage;
		}
		
		$this->arReplyTo = $arParsedEmails;
	}
	
	function formatPhone($text) {
		$strPhoneRegex = '/\(?([0-9]{3})\)?[\.\- ]?([0-9]{3})[\.\- ]?([0-9]{4})/';
		$text = preg_replace($strPhoneRegex,'($1) $2-$3',$text);
		return $text;
	}
	
	function getOffsetTime() {
		if (!empty($this->iTimeOffsetHours)) {
			return time()+($this->iTimeOffsetHours*60*60);
		} else {
			return time();
		}
	}
	
	function writeMessageToCsvLog() {
		$fr = @fopen($this->pathToCsvLogFile, 'a');
		if ($fr) {
			if (@filesize($this->pathToCsvLogFile) == 0) {
				@fputcsv($fr, array("DATE","SUBJECT","MESSAGE"));
			}
			$logresult = @fputcsv($fr, array(date('F j, Y'), $this->strSubject, $this->strMessage));
			@fclose($fr);
			if (!$logresult) {
				echo 'ERROR::Mailer Error writing to file.';
			}
		} else {
			echo 'ERROR::Mailer Could not open log file.';
		}
	}
	
	/* --- Future feature: multipart messages ---
		//Additional Headers
			"MIME-Version: 1.0",
			"Content-Type: multipart/related;",
			" boundary=\"" . $this->boundary . "\"",
			"X-Mailer: PHP/" . phpversion();
			
		//Additional Functions
		
		function addmessage($msg = "", $ctype = "text/plain"){
			//"text/html" for HTML
			$this->parts[0] = "Content-Type: $ctype; charset=ISO-8859-1\r\n" .
												"Content-Transfer-Encoding: 7bit\r\n" .
												"\r\n" . $msg;
												//chunk_split($msg, 68, "\r\n");
	}

	function addattachment($file, $ctype){
			$fname = substr(strrchr($file, "/"), 1);
			$data = file_get_contents($file);
			$i = count($this->parts);
			$content_id = "part$i." . sprintf("%09d", crc32($fname)) . strrchr($this->to_address[0], "@");
			$this->parts[$i] = "Content-Type: $ctype; name=\"$fname\"\r\n" .
												"Content-Transfer-Encoding: base64\r\n" .
												"Content-ID: <$content_id>\r\n" .
												"Content-Disposition: inline;\n" .
												" filename=\"$fname\"\r\n" .
												"\r\n" .
												chunk_split( base64_encode($data), 68, "\r\n");
			return $content_id;
	}

	function buildmessage(){
			$this->message = "This is a multipart message in mime format.\r\n";
			$cnt = count($this->parts);
			for($i=0; $i<$cnt; $i++){
				$this->message .= "--" . $this->boundary . "\r\n" .
													$this->parts[$i];
			}
	}

	# to get the message body as a string
	function getmessage(){
			$this->buildmessage();
			return $this->message;
	}
	*/
	
}
?>