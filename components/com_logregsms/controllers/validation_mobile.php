<?php
/**
 * @package    logregsms
 * @subpackage C:
 * @author     Mohammad Hosein Mir {@link https://joomina.ir}
 * @author     Created on 22-Feb-2019
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


/**
 * logregsms Model.
 *
 * @package    logregsms
 * @subpackage Models
 */
class LogregsmsControllerValidation_mobile extends JControllerForm
{
	/**
	 * Gets the Data.
	 *
	 * @return string The greeting to be displayed to the user
	 */
	public function step1()
	{
		$helper = new LRSHelper();
		$mobile = $helper::$_app->input->get('mobilenum', '');
		
		$user = $helper::User();
		if($user->guest == false) {
			$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile'), 'شما قبلا به سایت وارد شده اید.');
			exit;
		}
		
		$validation = LRSHelper::Validation($mobile, 'mobile');
		if($validation['result'] == false) {
			JError::raiseWarning(100, $validation['msg']);
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'));
			exit;
		}
		
		$params = $helper::getParams();
		$text = $params->get('smstext', 'کد تاییدیه شما: {code}');
		$username = $params->get('username', '');
		$password = $params->get('password', '');
		$line = $params->get('line', '');
		$reseller = $params->get('reseller', '');
		if(empty($username)) {
			JError::raiseWarning(100, 'لطفا از بخش تنظیمات کامپوننت ثبت نام پیامکی ، اطلاعات مربوط به پنل پیامک تان را درج کنید.');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'));
			exit;
		}
		
		// check 0
		$seprated = str_split($mobile);
		if($seprated[0] == "0") {
			unset($seprated[0]);
			$mobile = null;
			foreach ($seprated as $k => $v) {
				$mobile .= $v;
			}
		}
        
        // check if user register before or not
		$mobile2 = $mobile;
		if(strlen($mobile2) == 10) {
		    $mobile2 = "0".$mobile2;
		}
		$user_id = $this->FindUser($mobile, $mobile2); 
		if(!$user_id) {
		    $helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'), 'موبایل وارد شده در سیستم یافت نشد!');
			/*$session->set('smsregAllowReg', '1');
			$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'), 'لطفا فرم زیر را جهت ثبت نام پر کنید');*/
			exit;
		}
		
		// create code
		$code = LRSHelper::rndNums(5);
		
		// prepare text
		$data = array('code' => $code);
		$data = LRSHelper::Prepare($text, $data);
				
		// send sms
		$result = LRSSendSms::SendSms ($username, $password, $line, $reseller, $data, $mobile);
		$sms_result = isset($result['SendSimpleSMS2Result']) ? $result['SendSimpleSMS2Result'] : -1;
		
		LRSHelper::Insert(
			array(
				'created_on' => date('Y-m-d'),
				'time' => date('H:i:s'),
				'to' => $mobile,
				'from' => $line,
				'message' => $data,
				'result' => $sms_result
			),
			'#__logregsms_smsarchives'
		);
		
		$session = JFactory::getSession();
		$session->set('smsregCode', $code);
		$session->set('smsregMobile', $mobile);
		$msg = 'لطفا کد ارسال شده به موبایل خود را وارد کنید.';
		JFactory::getApplication()->enqueueMessage($msg, 'warning');
		$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_code'));
		exit;
	}
	
	public function FindUser ($mobile, $mobile2) {
	    
	    $db = JFactory::getDBO();
	    $db->setQuery('SELECT fv.item_id FROM #__fields_values AS fv LEFT JOIN #__fields AS f ON fv.field_id = f.id WHERE f.name = "mobile" AND (fv.value = "'.$mobile.'" OR fv.value = "'.$mobile2.'")');
	    $user_id = $db->loadResult();
	    return $user_id;
	}
}
