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

?>
<main class="auth uk-padding-large uk-padding-remove-horizontal uk-text-zero">
    <div class="uk-container uk-container-xsmall login<?php echo $this->pageclass_sfx; ?>">
        <div>
            <div class="uk-flex-center" data-uk-grid>
                <div class="uk-width-1-1 uk-width-1-2@m validation-code" id="logregsms">
                    <div>
                        <div class="uk-child-width-1-1 uk-grid-divider validation-mobile" data-uk-grid>
                            <div>
                                <form class="regularForm uk-margin-remove" action="<?php echo JRoute::_('index.php?option=com_logregsms&task=validation_code.step2'); ?>" method="post" name="step2form" id="step2form" onSubmit="return ValidationCodeForm()">
                                    <fieldset class="uk-padding-remove uk-margin-remove">
                                        <div>
                                            <div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
                                                <div class="form-group">
                                                    <label for="codenum" class="uk-form-label"><?php echo JTEXT::_('AUTHCODE'); ?><strong><span class="uk-margin-small-left uk-margin-small-right">*</span></strong></label>
                                                    <input type="tel" name="codenum" class="uk-width-1-1 font rsform-input-box uk-input ltr uk-text-center" maxlength="5" id="codenum" onKeyPress="numberValidate(event)" placeholder="_ _ _ _ _">
                                                </div>
                                                <div>
                                                    <button type="submit" class="uk-width-1-1 uk-button-primary uk-border-rounded uk-button-large font rsform-submit-button  uk-button uk-button-primary"><?php echo JTEXT::_('CHECKAUTH'); ?></button>
                                                </div>
                                            </div>
                                            <div class="uk-text-center uk-margin-top">
                                                <p class="font uk-text-tiny" id="resendtimerlinkWrapper"><?php echo '<span id="resendtimerlink"></span>'; ?></p>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    window.onload = function () {
        var wrapper = document.querySelector('#resendtimerlinkWrapper');
        var timer = document.querySelector('#resendtimerlink');
        var duration = 60;
        startTimerLR(duration, timer, '<?php echo JRoute::_('index.php?option=com_logregsms&task=validation_code.resend'); ?>');
    };
</script>