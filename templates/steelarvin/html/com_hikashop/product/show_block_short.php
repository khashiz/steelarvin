<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.1
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
$this->fieldsClass->prefix = '';
$displayTitle = false;
ob_start();
?>
<?php foreach ($this->fields as $fieldName => $oneExtraField) { ?>
    <?php
    $value = '';
	if(empty($this->element->$fieldName) && !empty($this->element->main->$fieldName))
		$this->element->$fieldName = $this->element->main->$fieldName;
	if(isset($this->element->$fieldName))
		$value = trim($this->element->$fieldName);
	if(!empty($value) || $value === '0' || $oneExtraField->field_type == 'customtext') {
		$displayTitle = true;
	?>
        <?php if ($oneExtraField->field_namekey == 'short_desc') { ?>
            <div class="uk-width-1-1">
                <div class="hikashop_category_description uk-card uk-card-default uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
                    <span id="hikashop_product_custom_value_<?php echo $oneExtraField->field_id;?>" class="uk-display-block uk-padding">
                        <div class="uk-text-secondary font f500 uk-text-justify uk-text-small" itemprop="articleBody" id="<?php echo $oneExtraField->field_id;?>"><?php echo $this->fieldsClass->show($oneExtraField,$value); ?></div>
                    </span>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
<?php $specifFields = ob_get_clean(); ?>

<?php if($displayTitle) { ?>
<?php echo $specifFields; ?>
<?php } ?>