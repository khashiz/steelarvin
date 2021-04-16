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
JFactory::getApplication()->enqueueMessage(JTEXT::_('ENTERYOURMOBILE'), 'warning');
?>
<main class="auth uk-padding-large uk-padding-remove-horizontal uk-text-zero">
    <div class="uk-container uk-container-xsmall login<?php echo $this->pageclass_sfx; ?>">
        <div>
            <div class="uk-flex-center" data-uk-grid>
                <div class="uk-width-1-1 uk-width-1-2@m">
                    <div>
                        <div class="uk-child-width-1-1 uk-grid-divider validation-mobile" data-uk-grid id="logregsms">
                            <div>
                                <form class="regularForm uk-margin-remove" action="<?php echo JRoute::_('index.php?option=com_logregsms&task=validation_mobile.step1'); ?>" method="post" name="step1form" id="step1form" onSubmit="return ValidationMobileForm()">
                                    <fieldset class="uk-padding-remove uk-margin-remove">
                                        <div>
                                            <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                                                <div>
                                                    <label class="uk-form-label" for="mobilenum"><?php echo JTEXT::_('MOBILENUMBER'); ?><strong><span class="uk-margin-small-left uk-margin-small-right">*</span></strong></label>
                                                    <input type="tel" name="mobilenum" class="uk-width-1-1 font rsform-input-box uk-input ltr uk-text-center" maxlength="11" id="mobilenum" onKeyPress="numberValidate(event)" placeholder="_ _ _ _ _ _ _ _ _ _">
                                                </div>
                                                <div>
                                                    <button type="submit" class="uk-width-1-1 uk-button-primary uk-border-rounded uk-button-large font rsform-submit-button  uk-button uk-button-primary"><?php echo JTEXT::_('CATCHAUTHCODE'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <?php /* ?>
                            <div>
                                <ul class="uk-grid-small uk-flex-center uk-grid-divider" data-uk-grid>
                                    <li>
                                        <a class="font uk-text-small uk-text-muted" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
                                    </li>
                                    <li>
                                        <a class="font uk-text-small uk-text-muted" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
                                    </li>
                                    <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
                                    <?php if ($usersConfig->get('allowUserRegistration')) : ?>
                                        <li>
                                            <a class="font uk-text-small uk-text-muted" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <?php */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>