<?php
/**
 * @package    smsarchive
 * @subpackage C:
 * @author     Mohammad Hosein Mir {@link https://joomina.ir}
 * @author     Created on 22-Feb-2019
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');


/**
 * HTML View class for the smsarchive Component.
 *
 * @package    smsarchive
 * @subpackage Views
 */
class logregsmsViewRegistration extends JViewLegacy
{
    /**
     * @var
     */
    protected $data;

    /**
     * smsarchive view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
			$helper = new LRSHelper();
			
			$session = JFactory::getSession();
			$smsregAllowReg = $session->get('smsregAllowReg', null);
			if($smsregAllowReg !== "1") {
				JError::raiseWarning(100, 'اجازه ثبت نام وجود ندارد');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=validation_mobile'));
				exit;
			}

			$this->mobile = $session->get('smsregMobile', '');
			if(empty($this->mobile)) {
				$session->clear('smsregAllowReg');
				JError::raiseWarning(100, 'مشکلی در یافتن شماره موبایل بوجود آمده است');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_logregsms&view=registration'));
				exit;
			}
			
			$user = $helper::User();
			if($user->guest == false) {
				$session->clear('smsregAllowReg');
				$helper::$_app->redirect(JRoute::_('index.php?option=com_users&view=profile'), 'شما قبلا به سایت وارد شده اید.');
				exit;
			}
			
			$dispatcher = JEventDispatcher::getInstance();
			JForm::addFormPath(JPATH_SITE . '/components/com_users/models/forms');
			$form = JForm::getInstance('com_users.registration', 'registration');
			
			$data = null;
			$dispatcher->trigger('onContentPrepareForm', array($form, $data));
			$all_groups = $form->getFieldsets();
			$field_groups = array();

			foreach (array_reverse($all_groups) as $key => $value) {
				if((strrpos($key, 'fields')) === false) continue;

				$fields = $form->getFieldset($value->name);
				$field_groups = array_merge($field_groups, array_reverse($fields));
			}

			$this->fields = !empty($field_groups) ? array_reverse($field_groups) : null;
			
      $this->params = LRSHelper::getParams();
				
      parent::display($tpl);
    }
}
