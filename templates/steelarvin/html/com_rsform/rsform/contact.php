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
            <div class="uk-container">
                <div>
                    <div class="uk-card uk-card-default uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
                        <div class="uk-padding">
                            <div class="uk-grid-divider" data-uk-grid>
                                <div class="uk-width-1-1 uk-width-expand@m"><?php echo RSFormProHelper::displayForm($this->formId); ?></div>
                                <div class="uk-width-1-1 uk-width-1-3@m">
                                    <div>
                                        <div class="uk-child-width-1-1 uk-grid-divider" data-uk-grid>
                                            <div>
                                                <h2 class="uk-margin-bottom uk-text-accent uk-text-bold uk-h4 font"><?php echo JText::sprintf('CONTACTINFO'); ?></h2>
                                                <div></div>
                                            </div>
                                            <div>
                                                <h2 class="uk-margin-bottom uk-text-accent uk-text-bold uk-h4 font"><?php echo JText::sprintf('SOCIALMEDIA'); ?></h2>
                                                <div></div>
                                            </div>
                                            <div>
                                                <h2 class="uk-margin-bottom uk-text-accent uk-text-bold uk-h4 font"><?php echo JText::sprintf('PATHFINDER'); ?></h2>
                                                <div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>