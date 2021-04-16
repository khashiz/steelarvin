<?php

/**
 * @package    Joomla SMS Registration
 * @author     ThemeIran {@link https://www.themeiran.com}
 * @author     Created on 11 October 2018
 * @license    GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

class LRSSendSms
{		
	public static function SendSms($username, $password, $smsline, $reseller, $text, $to) {
		
		LRSHelper::loadNuSoap();

		$client = new nusoap_client('http://'.$reseller.'/post/send.asmx?wsdl',true);
		$err = $client->getError();
		if ($err) 
		{
		   echo 'Constructor error' . $err;
		}

		$parameters['username'] = $username; 
		$parameters['password'] = $password; 
		$parameters['to'] = $to;
		$parameters['from'] = $smsline; 
		$parameters['text'] = $text;
		$parameters['isflash'] =false;

		$res = $client->call('SendSimpleSMS2', $parameters);  

		return $res;
		//return array('SendSimpleSMS2Result'=> '1555');
	}// function
		
}// class
?>