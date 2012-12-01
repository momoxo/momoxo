<?php

/**
 * This is an exmine class for mail.
 */
use XCore\Kernel\Root;

class Xcore_Mailer extends PHPMailer
{
	/**
	 * @type XCube_Delegate
	 */
	var $mConvertLocal = null;
	
	function Xcore_Mailer()
	{
		$this->mConvertLocal =new XCube_Delegate();
		$this->mConvertLocal->register('Xcore_Mailer.ConvertLocal');
	}
	
	function prepare()
	{
		$root = Root::getSingleton();
		
		$handler =& xoops_gethandler('config');
		$xoopsMailerConfig =& $handler->getConfigsByCat(XOOPS_CONF_MAILER);
		$this->reset();
		
		if ($xoopsMailerConfig['from'] == '') {
			$this->From = $root->mContext->mXoopsConfig['adminmail'];
		}
		else {
			$this->From = $xoopsMailerConfig['from'];
		}
		
		$this->Sender = $root->mContext->mXoopsConfig['adminmail'];
		
		$this->SetLanguage = XCORE_MAIL_LANG;
		$this->CharSet = XCORE_MAIL_CHAR;
		$this->Encoding = XCORE_MAIL_ENCO;
		
		switch ($xoopsMailerConfig['mailmethod']) {
			case 'smtpauth':
				$this->IsSMTP();
				$this->SMTPAuth = true;
				$this->Host = implode(';', $xoopsMailerConfig['smtphost']);
				$this->Username = $xoopsMailerConfig['smtpuser'];
				$this->Password = $xoopsMailerConfig['smtppass'];
				break;
				
			case 'smtp':
				$this->IsSMTP();
				$this->SMTPAuth = false;
				$this->Host = implode(';', $xoopsMailerConfig['smtphost']);
				break;
				
			case 'sendmail':
				$this->IsSendmail();
				$this->Sendmail = $xoopsMailerConfig['sendmailpath'];
				break;
		}
		
		return true;
	}
	
	function setFrom($text)
	{
		$this->From = $text;
	}
	
	function setFromname($text)
	{
		$this->FromName = $this->convertLocal($text, 2);
	}
	
	function setSubject($text)
	{
		$this->Subject = $this->convertLocal($text, true);
	}
  
	function setBody($text)
	{
		$this->Body = $this->convertLocal($text);
	}
	
	function setTo($add, $name)
	{
		$this->AddAddress($add, $this->convertLocal($name, true));
	}
	
	function reset()
	{
		$this->ClearAllRecipients();
		$this->Body = "";
		$this->Subject = "";
	}
	
	function convertLocal($text, $mime = false)
	{
		$this->mConvertLocal->call(new XCube_Ref($text), $mime);
		return $text;
	}
}

