<?php
/**
 * @package RSForm! Pro
 * @copyright (C) 2007-2019 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');
?>
<?php if ($this->params->get('show_page_heading', 0)) { ?>
    <section class="bgPrimary uk-padding uk-padding-remove-horizontal uk-text-zero pageHeading">
        <div class="uk-container">
            <div>
                <div class="uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-1">
                        <h1 class="uk-margin-remove uk-text-white uk-text-center font"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<main data-uk-height-viewport="expand: true">
    <div class="uk-padding uk-padding-remove-horizontal">
        <div>
            <div class="uk-container uk-container-xsmall">
                <div>
                    <div class="uk-card uk-card-default uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
                        <div><?php echo RSFormProHelper::displayForm($this->formId); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>