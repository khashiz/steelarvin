<?php
/**
* @package RSForm! Pro
* @copyright (C) 2007-2019 www.rsjoomla.com
* @license GPL, http://www.gnu.org/copyleft/gpl.html
*/

defined('_JEXEC') or die('Restricted access');
?>
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