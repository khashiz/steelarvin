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
<div class="uk-margin-medium-bottom">
    <div data-uk-grid>
        <div class="uk-width-1-1 uk-width-2-5@m">
            <div id="hikashop_product_left_part" data-uk-sticky="offset: 110; bottom: true;">
                <?php if(!empty($this->element->extraData->leftBegin)) { echo implode("\r\n",$this->element->extraData->leftBegin); } ?>
                <?php $this->row =& $this->element; $this->setLayout('show_block_img'); echo $this->loadTemplate(); ?>
                <?php if(!empty($this->element->extraData->leftEnd)) { echo implode("\r\n",$this->element->extraData->leftEnd); } ?>
            </div>
        </div>
        <div class="uk-width-1-1 uk-width-expand@m">
            <div id="hikashop_product_top_part" class="uk-margin-medium-bottom">
                <?php if(!empty($this->element->extraData->topBegin)) { echo implode("\r\n",$this->element->extraData->topBegin); } ?>
                <div data-uk-grid>
                    <div class="uk-width-expand">
                        <span class="uk-text-tiny uk-text-muted uk-text-uppercase uk-display-block uk-margin-small-bottom font"><?php echo JText::sprintf('PRODUCT_CODE', $this->element->product_code); ?></span>
                        <h1 class="uk-margin-remove-top uk-h4">
                            <span id="hikashop_product_name_main" class="hikashop_product_name_main uk-display-block uk-text-secondary font" itemprop="name">
                                <?php
                                if(hikashop_getCID('product_id') != $this->element->product_id && isset($this->element->main->product_name))
                                    echo $this->element->main->product_name;
                                else
                                    echo $this->element->product_name;
                                ?>
                            </span>
                            <meta itemprop="sku" content="<?php echo $this->element->product_code; ?>">
                            <meta itemprop="productID" content="<?php echo $this->element->product_code; ?>">
                            <?php if ($this->config->get('show_code')) { ?>
                                <span id="hikashop_product_code_main" class="hikashop_product_code_main">
                                    <?php echo $this->element->product_code; ?>
                                </span>
                            <?php } ?>
                        </h1>
                    </div>
                    <div class="uk-width-auto">
                        <div>
                            <div>
                                <div class="uk-grid-divider uk-grid-small" data-uk-grid>
                                    <div>
                                        <div class="uk-text-muted uk-text-tiny font uk-text-center"><?php echo JText::sprintf('VOTE'); ?></div>
                                        <div id="hikashop_product_vote_mini" class="uk-text-tiny">
                                            <?php if($this->params->get('show_vote_product')) {
                                                $js = '';
                                                $this->params->set('vote_type', 'product');
                                                $this->params->set('vote_ref_id', isset($this->element->main) ? (int)$this->element->main->product_id : (int)$this->element->product_id );
                                                echo hikashop_getLayout('vote', 'mini', $this->params, $js);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-height-1-1 uk-flex uk-flex-middle"><?php $this->setLayout('show_block_social'); echo $this->loadTemplate(); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!empty($this->element->extraData->topEnd)) { echo implode("\r\n", $this->element->extraData->topEnd); } ?>
            </div>
            <div id="hikashop_product_description_main" class="hikashop_category_description uk-text-justify uk-text-small uk-text-secondary font" itemprop="description">
                <?php echo JHTML::_('content.prepare',preg_replace('#<hr *id="system-readmore" */>#i','',$this->element->product_description)); ?>
            </div>
            <div id="hikashop_product_right_part">
                <?php if(!empty($this->element->extraData->rightBegin)) { echo implode("\r\n",$this->element->extraData->rightBegin); } ?>
                <div class="productPrice">
                    <?php $itemprop_offer = ''; if (!empty($this->element->prices)) $itemprop_offer = 'itemprop="offers" itemscope itemtype="https://schema.org/Offer"'; ?>
                    <span class="uk-display-block" id="hikashop_product_price_main" <?php echo $itemprop_offer; ?>>
                        <?php
                        $main =& $this->element;
                        if(!empty($this->element->main))
                            $main =& $this->element->main;
                        if(!empty($main->product_condition) && !empty($this->element->prices)) {
                            ?>
                            <meta itemprop="itemCondition" itemtype="https://schema.org/OfferItemCondition" content="https://schema.org/<?php echo $main->product_condition; ?>" />
                            <?php
                        }
                        if($this->params->get('show_price') && (empty($this->displayVariants['prices']) || $this->params->get('characteristic_display') != 'list')) {
                            $this->row =& $this->element;
                            $this->setLayout('show_block_price');
                            echo $this->loadTemplate();
                            if (!empty($this->element->prices)) {
                                ?>
                                <meta itemprop="price" content="<?php echo $this->itemprop_price; ?>" />
                                <meta itemprop="availability" content="https://schema.org/<?php echo ($this->row->product_quantity != 0) ? 'InStock' : 'OutOfstock' ;?>" />
                                <meta itemprop="priceCurrency" content="<?php echo $this->currency->currency_code; ?>" />
                            <?php	}
                        }
                        ?>
                    </span>
                </div>
                <?php if(!empty($this->element->extraData->rightMiddle)) { echo implode("\r\n",$this->element->extraData->rightMiddle); } ?>
                <?php $this->setLayout('show_block_dimensions'); echo $this->loadTemplate(); ?>
                <?php if($this->params->get('characteristic_display') != 'list') { $this->setLayout('show_block_characteristic'); echo $this->loadTemplate(); } ?>
                <div>
                    <?php
                    $form = ',0';
                    if(!$this->config->get('ajax_add_to_cart', 1)) {
                        $form = ',\'hikashop_product_form\'';
                    }
                    if(hikashop_level(1) && !empty ($this->element->options)) {
                        ?>
                        <div id="hikashop_product_options" class="hikashop_product_options">
                            <?php
                            $this->setLayout('option');
                            echo $this->loadTemplate();
                            ?>
                        </div>
                        <?php
                        $form = ',\'hikashop_product_form\'';
                        if($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
                            ?>
                            <input type="hidden" name="popup" value="1"/>
                            <?php
                        }
                    }
                    if(!$this->params->get('catalogue') && ($this->config->get('display_add_to_cart_for_free_products') || ($this->config->get('display_add_to_wishlist_for_free_products', 1) && hikashop_level(1) && $this->params->get('add_to_wishlist') && $this->config->get('enable_wishlist', 1)) || !empty($this->element->prices))) {
                        if(!empty($this->itemFields)) {
                            $form = ',\'hikashop_product_form\'';
                            if ($this->config->get('redirect_url_after_add_cart', 'stay_if_cart') == 'ask_user') {
                                ?>
                                <input type="hidden" name="popup" value="1"/>
                                <?php
                            }
                            $this->setLayout('show_block_custom_item');
                            echo $this->loadTemplate();
                        }
                    }
                    $this->formName = $form;
                    if($this->params->get('show_price')) {
                        ?>
                        <span id="hikashop_product_price_with_options_main" class="hikashop_product_price_with_options_main"></span>
                        <?php
                    }
                    if(empty($this->element->characteristics) || $this->params->get('characteristic_display') != 'list') {
                        ?>
                        <div id="hikashop_product_quantity_main" class="hikashop_product_quantity_main uk-grid-small uk-child-width-auto" data-uk-grid>
                            <?php
                            $this->row =& $this->element;
                            $this->ajax = 'if(hikashopCheckChangeForm(\'item\',\'hikashop_product_form\')){ return hikashopModifyQuantity(\'' . (int)$this->element->product_id . '\',field,1' . $form . ',\'cart\'); } else { return false; }';
                            $this->setLayout('quantity');
                            echo $this->loadTemplate();
                            ?>
                        </div>
                        <div id="hikashop_product_quantity_alt" class="hikashop_product_quantity_main_alt" style="display:none;">
                            <?php echo JText::_('ADD_TO_CART_AVAILABLE_AFTER_CHARACTERISTIC_SELECTION'); ?>
                        </div>
                    <?php } ?>
                    <div id="hikashop_product_contact_main" class="hikashop_product_contact_main">
                        <?php
                        $contact = (int)$this->config->get('product_contact', 0);
                        if(hikashop_level(1) && ($contact == 2 || ($contact == 1 && !empty($this->element->product_contact)))) {
                            $css_button = $this->config->get('css_button', 'hikabtn');
                            ?>
                            <a rel="noindex, nofollow" href="<?php echo hikashop_completeLink('product&task=contact&cid=' . (int)$this->element->product_id . $this->url_itemid); ?>" class="<?php echo $css_button; ?>">
                                <?php echo JText::_('CONTACT_US_FOR_INFO'); ?>
                            </a>
                        <?php } ?>
                    </div>
                    <span id="hikashop_product_id_main" class="hikashop_product_id_main">
                        <input type="hidden" name="product_id" value="<?php echo (int)$this->element->product_id; ?>" />
                    </span>
                    <?php if(!empty($this->element->extraData->rightEnd)) { echo implode("\r\n",$this->element->extraData->rightEnd); } ?>
                </div>
            </div>
        </div>
        <?php $this->setLayout('show_block_short'); echo $this->loadTemplate(); ?>
        <?php if ($this->element->kgproductmsg) { ?>
            <div class="uk-width-1-1">
                <div>
                    <div class="uk-alert uk-alert-warning uk-text-center uk-border-rounded uk-box-shadow-small uk-padding-small uk-text-small f600 font uk-margin-remove">کاربر گرامی لطفا توجه داشته باشید که محصولاتی بصورت وزنی بفروش میرسند ، پس از ثبت سفارش قیمت گذاری خواهند شد.</div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>