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
$url_itemid = (isset($this->url_itemid)) ? $this->url_itemid : '';
$cancel_orders = false;
$print_invoice = false;
?>
<div>
	<h3 class="hika_cpanel_main_data_title uk-margin-bottom uk-text-accent uk-text-bold uk-h4 font"><?php echo $this->cpanel_data->cpanel_title; ?></h3>
</div>
<?php if(empty($this->cpanel_data->cpanel_orders)) { ?>
    <div class="uk-text-center hika_no_orders">
        <div class="uk-margin-medium-bottom"><img src="<?php echo JURI::base().'images/sprite.svg#box-open'; ?>" width="128" height="128" alt="<?php echo $sitename; ?>" data-uk-svg></div>
        <p class="uk-margin-remove uk-text-danger uk-text-small uk-text-bold font"><?php echo JTEXT::_('HIKA_CPANEL_NO_ORDERS'); ?></p>
    </div>
<?php } ?>
<?php $cancel_url = '&cancel_url='.base64_encode(hikashop_currentURL()); ?>
    <div class="uk-text-zer">
        <div class="uk-child-width-1-1 uk-grid-divider" data-uk-grid>
            <?php foreach($this->cpanel_data->cpanel_orders as $order_id => $order) { ?>
                <?php $order_link = hikashop_completeLink('order&task=show&cid='.$order_id.$url_itemid.$cancel_url); ?>
                <div>
                    <div>
                        <div>
                            <?php /* if(!empty($order->order_invoice_number)) { ?>
                                <div><?php echo JText::_('INVOICE_NUMBER'); ?> : <?php echo $order->order_invoice_number; ?></div>
                            <?php } */ ?>
                            <span class="uk-display-block uk-text-tiny uk-text-muted font"><?php echo JText::sprintf('ORDERNUMBERX', $order->order_number); ?></span>
                            <div>
                                <div class="uk-grid-small" data-uk-grid>
                                    <div class="uk-width-auto uk-flex uk-flex-middle">
                                        <div>
                                            <div class="uk-grid-small uk-child-width-auto uk-grid-divider" data-uk-grid>
                                                <div>
                                                    <time class="uk-text-small uk-text-secondary font myOrderMetaItem" datetime="<?php echo hikashop_getDate((int)$order->order_created, '%d %B %Y %H:%M'); ?>"><?php echo hikashop_getDate((int)$order->order_created, 'D ، d M Y'); ?></time>
                                                </div>
                                                <div>
                                                    <span class="uk-text-small uk-text-secondary font myOrderMetaItem"><?php echo $this->currencyClass->format($order->order_full_price, $order->order_currency_id); ?></span>
                                                </div>
                                                <div>
                                                    <span class="uk-text-small uk-text-<?php echo $order->order_status; ?> font myOrderMetaItem"><?php echo hikashop_orderStatus($order->order_status); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="uk-width-expand">
                                        <div>
                                            <div class="uk-grid-small uk-flex-left" data-uk-grid>
                                                <div>
                                                    <a class="uk-button uk-button-small uk-box-shadow-small uk-border-rounded uk-button-success" href="<?php echo $order_link; ?>">frerfff</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <div>
                                <?php // if(!empty($order->extraData->topLeft)) { echo implode("\r\n", $order->extraData->topLeft); } ?>
                                <?php // if(!empty($order->extraData->bottomLeft)) { echo implode("\r\n", $order->extraData->bottomLeft); } ?>
                                <?php // if(!empty($order->extraData->topMiddle)) { echo implode("\r\n", $order->extraData->topMiddle); } ?>
                                <?php // if(!empty($order->extraData->bottomMiddle)) { echo implode("\r\n", $order->extraData->bottomMiddle); } ?>
                            </div>
                            <div>
                                <?php if(!empty($order->extraData->topRight)) {
                                    echo implode("\r\n", $order->extraData->topRight);
                                } ?>
                                <?php
                                $dropData = array(
                                        array(
                                            'name' => JText::_('HIKA_DETAILS'),
                                            'link' => $order_link
                                        )
                                );

		if(!empty($order->show_print_button)) {
			$print_invoice = true;
			$dropData[] = array(
				'name' => JText::_('PRINT_INVOICE'),
				'link' => '#print_invoice',
				'click' => 'return window.localPage.printInvoice('.(int)$order->order_id.');',
			);
		}
		if(!empty($order->show_cancel_button)) {
			$cancel_orders = true;
			$dropData[] = array(
				'name' => '<i class="fas fa-ban"></i> '. JText::_('CANCEL_ORDER'),
				'link' => '#cancel_order',
				'click' => 'return window.localPage.cancelOrder('.(int)$order->order_id.',\''.$order->order_number.'\');',
			);
		}
		if(!empty($order->show_payment_button) && bccomp($order->order_full_price, 0, 5) > 0) {
			$url_param = ($this->payment_change) ? '&select_payment=1' : '';
			$url = hikashop_completeLink('order&task=pay&order_id='.$order->order_id.$url_param.$url_itemid);
			if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
				$url = str_replace('http://','https://', $url);
			$dropData[] = array(
				'name' => '<i class="fas fa-money-bill-alt"></i> '. JText::_('PAY_NOW'),
				'link' => $url
			);
		}
		if($this->config->get('allow_reorder', 0)) {
			$url = hikashop_completeLink('order&task=reorder&order_id='.$order->order_id.$url_itemid);
			if($this->config->get('force_ssl',0) && strpos('https://',$url) === false)
				$url = str_replace('http://','https://', $url);
			$dropData[] = array(
				'name' => '<i class="fas fa-redo-alt"></i> '. JText::_('REORDER'),
				'link' => $url
			);
		}

		if(!empty($order->actions)) {
			$dropData = array_merge($dropData, $order->actions);
		}

		if(!empty($dropData)) {
			echo $this->dropdownHelper->display(
				JText::_('HIKASHOP_ACTIONS'),
				$dropData,
				array('type' => 'btn', 'right' => true, 'up' => false)
			);
		}
?>
<?php if(!empty($order->extraData->bottomRight)) { echo implode("\r\n", $order->extraData->bottomRight); } ?>
			</div>
		</div>
	</div>
	<div>
		<div>
<?php if(!empty($order->extraData->beforeProductsListing)) { echo implode("\r\n", $order->extraData->beforeProductsListing); } ?>
<?php
	$show_more = false;
	$max_products = (int)$this->config->get('max_products_cpanel', 4);
	if($max_products <= 0) $max_products = 4;
	if(count($order->products) > $max_products) {
		$order->products = array_slice($order->products, 0, $max_products);
		$show_more = true;
	}
	$group = $this->config->get('group_options',0);
	foreach($order->products as $product) {
		if($group && $product->order_product_option_parent_id)
			continue;
		$link = '#';
		if(!empty($product->product_id) && !empty($this->products[$product->product_id]) && !empty($this->products[$product->product_id]->product_published))
			$link = hikashop_contentLink('product&task=show&cid='.$product->product_id.'&name='.@$this->products[$product->product_id]->alias . $url_itemid, $this->products[$product->product_id]);

?>
			<div>
<?php
		if(!empty($this->cpanel_data->cpanel_order_image)) {
			$img = $this->imageHelper->getThumbnail(@$product->images[0]->file_path, array(50, 50), array('default' => true, 'forcesize' => true,  'scale' => 'outside'));
			if(!empty($img) && $img->success) {
?>
				<a class="hika_cpanel_product_image_link" href="<?php echo $link; ?>"><img class="hika_cpanel_product_image" src="<?php echo $img->url; ?>" alt="" /></a>
<?php
			}
		}
?>
		<a href="<?php echo $link; ?>">
			<span class="hika_cpanel_product_name"><?php echo $product->order_product_name; ?></span>
<?php
		if($this->config->get('show_code')) {
?>
			<span class="hikashop_cpanel_product_code"><?php echo $product->order_product_code; ?></span>
<?php
		}
		if($group) {
			foreach($order->products as $j => $optionElement) {
				if($optionElement->order_product_option_parent_id != $product->order_product_id)
					continue;
				$product->order_product_price += $optionElement->order_product_price;
				$product->order_product_tax += $optionElement->order_product_tax;
				$product->order_product_total_price += $optionElement->order_product_total_price;
				$product->order_product_total_price_no_vat += $optionElement->order_product_total_price_no_vat;
			}
		}
?>
		</a>
				<p class="hika_cpanel_product_price">
					<span class="hika_cpanel_product_price_quantity">
						<?php echo  $product->order_product_quantity; ?>
					</span>
					<span class="hika_cpanel_product_price_times"> x
					</span>
					<span class="hika_cpanel_product_price_amount">
						<?php echo  $this->currencyClass->format( $product->order_product_price + $product->order_product_tax, $order->order_currency_id ); ?>
					</span>
				</p>
<?php
		if(!empty($product->extraData))
			echo '<p class="hikashop_order_product_extra">' . (is_string($product->extraData) ? $product->extraData : implode('<br/>', $product->extraData)) . '</p>';
?>
			</div>
<?php } if($show_more) { ?>
			<a href="<?php echo $order_link; ?>"><?php echo JText::_('SHOW_MORE_PRODUCTS'); ?></a>
    <?php } ?>
<?php if(!empty($order->extraData->afterProductsListing)) { echo implode("\r\n", $order->extraData->afterProductsListing); } ?>
		</div>
		<div>
<?php if(!empty($order->extraData->beforeInfo)) { echo implode("\r\n", $order->extraData->beforeInfo); } ?>
			<dl class="hika_cpanel_order_methods">
<?php if(!empty($order->payment)) { ?>
				<dt><?php echo JText::_('HIKASHOP_PAYMENT_METHOD'); ?></dt>
				<dd><?php echo $order->payment->payment_name; ?></dd>
<?php } ?>
<?php if(!empty($order->shippings)) { ?>
				<dt><?php echo JText::_('HIKASHOP_SHIPPING_METHOD'); ?></dt>
				<dd><?php
		$shippingClass = hikashop_get('class.shipping');
		$shippings_data = $shippingClass->getAllShippingNames($order);
		if(!empty($shippings_data)) {
			if(count($shippings_data) > 1) {
				echo '<ul><li>'.implode('</li><li>', $shippings_data).'</li></ul>';
			} else {
				echo reset($shippings_data);
			}
		}
?></dd>
<?php } ?>
			</dl>
<?php if(!empty($order->extraData->afterInfo)) { echo implode("\r\n", $order->extraData->afterInfo); } ?>
		</div>
	</div>
</div>
    <?php } ?>
    </div>
</div>



<?php

if(!empty($this->cpanel_data->cpanel_orders) && ($print_invoice || $cancel_orders)) {
	echo $this->popupHelper->display(
		'',
		'INVOICE',
		hikashop_completeLink('order&task=invoice'.$url_itemid.'',true),
		'hikashop_print_popup',
		760, 480, '', '', 'link'
	);
?>
<script>
if(!window.localPage) window.localPage = {};
window.localPage.cancelOrder = function(id, number) {
	var d = document, form = d.getElementById('hikashop_cancel_order_form');
	if(!form || !form.elements['order_id']) {
		console.log('Error: Form not found, cannot cancel the order');
		return false;
	}
	if(!confirm('<?php echo JText::_('HIKA_CONFIRM_CANCEL_ORDER', true); ?>'.replace(/ORDER_NUMBER/, number)))
		return false;
	form.elements['order_id'].value = id;
	form.submit();
	return false;
};
window.localPage.printInvoice = function(id) {
	hikashop.openBox('hikashop_print_popup','<?php
		$u = hikashop_completeLink('order&task=invoice'.$url_itemid,true);
		echo $u;
		echo (strpos($u, '?') === false) ? '?' : '&';
	?>order_id='+id);
	return false;
};
</script>
<form action="<?php echo hikashop_completeLink('order&task=cancel_order&email=1'); ?>" name="hikashop_cancel_order_form" id="hikashop_cancel_order_form" method="POST">
	<input type="hidden" name="Itemid" value="<?php global $Itemid; echo $Itemid; ?>"/>
	<input type="hidden" name="option" value="<?php echo HIKASHOP_COMPONENT; ?>" />
	<input type="hidden" name="task" value="cancel_order" />
	<input type="hidden" name="email" value="1" />
	<input type="hidden" name="order_id" value="" />
	<input type="hidden" name="ctrl" value="order" />
	<input type="hidden" name="redirect_url" value="<?php echo hikashop_currentURL(); ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php } ?>