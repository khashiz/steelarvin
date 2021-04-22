<?php
/**
 * @package	HikaShop for Joomla!
 * @version	4.4.1
 * @author	hikashop.com
 * @copyright	(C) 2010-2021 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
if(!empty($this->filters)){
	$count=0;
	$filterActivated=false;
	$widthPercent=(100/$this->maxColumn)-1;
	$widthPercent=round($widthPercent);
	static $i = 0;
	$i++;
	$filters = array();
	$url = hikaInput::get()->getVar('return_url', '');
	$attributes = '';
	$submit = "document.forms['hikashop_filter_form_" . $this->params->get('main_div_name') . "'].submit();";

	if(!empty($this->params) && $this->params->get('module') == 'mod_hikashop_filter' && ($this->params->get('force_redirect',0) || (hikaInput::get()->getVar('force_using_filters', 0) !== 1 && empty($this->currentId) && (hikaInput::get()->getVar('option','')!='com_hikashop'|| !in_array(hikaInput::get()->getVar('ctrl','product'),array('product','category')) ||hikaInput::get()->getVar('task','listing')!='listing')))){
		if(empty($url)) {
			$type = 'category';
			$menusClass = hikashop_get('class.menus');
			$idInModule = $this->params->get('itemid',0);

			if(!empty($idInModule))
				$id = $menusClass->loadAMenuItemId($type, 'listing', $idInModule);
			if(empty($id)){
				if(!empty($idInModule))
					$id = $menusClass->loadAMenuItemId('product', 'listing', $idInModule);
				if(empty($id)){
					$id = $menusClass->loadAMenuItemId('product','listing');
					if(empty($id))
						$id = $menusClass->loadAMenuItemId($type,'listing');
					else
						$type = 'product';
				}else{
					$type = 'product';
				}
			}
			$url = hikashop_completeLink($type.'&task=listing&Itemid='.$id);
		}

		$conf = JFactory::getConfig();
		if($conf->get('sef') == 1 && !empty($_SERVER['QUERY_STRING']) && strpos($_SERVER['QUERY_STRING'], 'option=com_hikashop&') === false) {
			$sep = '?';
			if(strpos($url,'?'))
				$sep = '&';
			$url .= $sep.$_SERVER['QUERY_STRING'];
		}
	} elseif($this->config->get('ajax_filters', 1)) {
		$submit = 'window.hikashop.refreshFilters(this);';
		$url = preg_replace('#&return_url=[^&]+#i','',hikashop_currentURL());
		$attributes = 'data-container-div="hikashop_filter_form_'.$this->params->get('main_div_name').'"';
	}

	foreach($this->filters as $filter) {
		if((empty($this->displayedFilters) || in_array($filter->filter_namekey,$this->displayedFilters)) && ($this->filterClass->cleanFilter($filter))) {
			$filters[] = $filter;
		}
		$data = $this->filterTypeClass->display($filter, '', $this);
		$selected[] = $data;
		if(!empty($data) && !in_array($data, array(' ', 'none'))) {
			$filter->filterActive = true;
			$filterActivated = true;
		}
	}

	if(!$filterActivated && empty($this->rows) && $this->params->get('module') != 'mod_hikashop_filter') return;

	if(!count($filters)) return;

	if(!$filterActivated)
		$this->showResetButton = false;

	$content_classes = 'hikashop_filter_main_div hikashop_filter_main_div_'.$this->params->get('main_div_name');
	$extra_attributes = '';
	$display_title_class = '';
	$form_attributes = '';


	if($this->collapsable){
		$content_classes .= '';
		$title_classes = 'hikashop_filter_collapsable_title';
		$display_title_class = '_mobile';

		if($this->collapsable == 'always'){
			$display_title_class = '_always';
			$extra_attributes .= ' style="display: none;"';
		}
?>
<?php
	}
	if($this->ajax) {
		if($this->params->get('module') == 'mod_hikashop_filter') {
			$url = hikaInput::get()->getVar('return_url', hikashop_currentURL());
		}
		$submit = 'window.hikashop.refreshFilters(this);';
		$attributes = ' data-container-div="hikashop_filter_form_'.$this->params->get('main_div_name').'"';
		$form_attributes .= 'onsubmit="'.$submit.' return false;"'.$attributes;
	}
	if($this->params->get('module') == 'mod_hikashop_filter') {
		$display_title_class .= ' filter_refresh_div';
		$refreshUrl = 'index.php?option=com_hikashop&ctrl=product&task=filter&tmpl=raw&filter=1&module_id='.$this->ajax.'&cid='.$this->currentId.'&from_option='.$this->option.'&from_ctrl='.$this->ctrl.'&from_task='.$this->task.'&from_itemid='.$this->itemid;
		$extra_attributes .= ' data-refresh-class="hikashop_checkout_loading" data-refresh-url="' . $refreshUrl . '"';
	}
	if($this->scrollToTop) {
		$form_attributes.=' data-scroll="1"';
	}
?>
    <div class="uk-width-1-1 uk-width-1-4@m filtersContainer">
        <div data-uk-sticky="offset: 110; bottom: true; media: @m">
            <div class="uk-card uk-card-default uk-border-rounded uk-overflow-hidden uk-box-shadow-small">
                <div id="filtersAccordion" data-uk-accordion>
                    <div class="uk-open">
                        <div class="uk-visible@m blockHeader">
                            <h3 class="uk-h5 uk-margin-remove uk-padding-small uk-text-bold uk-text-center font"><img src="<?php echo JURI::base().'images/sprite.svg#filter'; ?>" width="16" height="16" alt="<?php echo $sitename; ?>" class="uk-margin-small-left" data-uk-svg><?php echo JText::_('FILTERPRODUCTS'); ?></h3>
                        </div>
                        <div onclick="UIkit.accordion('#filtersAccordion').toggle(0);" class="uk-hidden@m blockHeader">
                            <h3 class="uk-h5 uk-margin-remove uk-padding-small uk-text-bold uk-text-center font"><img src="<?php echo JURI::base().'images/sprite.svg#filter'; ?>" width="16" height="16" alt="<?php echo $sitename; ?>" class="uk-margin-small-left" data-uk-svg><?php echo JText::_('FILTERPRODUCTS'); ?></h3>
                        </div>
                        <div class="uk-accordion-content uk-margin-remove">
                            <div class="uk-padding-small">
                                <div id="hikashop_filter_main_div_<?php echo $this->params->get('main_div_name'); ?>" class="<?php echo $content_classes.$display_title_class; ?>" <?php echo $extra_attributes; ?>>
                                    <?php
                                    if($this->params->get('module') == 'mod_hikashop_filter') {
                                        ?>
                                        <div class="hikashop_checkout_loading_elem"></div>
                                        <div class="hikashop_checkout_loading_spinner"></div>
                                        <?php
                                    }
                                    $datas = array();
                                    if(isset($this->listingQuery)){
                                        $html=array();
                                        $datas=$this->filterClass->getProductList($this, $filters);
                                    }

                                    foreach($filters as $key => $filter){
                                        $html[$key]=$this->filterClass->displayFilter($filter, $this->params->get('main_div_name'), $this, $datas);
                                    }

                                    if($this->displayFieldset){ ?>

                                    <div class="hikashop_filter_fieldset<?php echo $display_title_class ?>">
                                        <?php } ?>

                                        <form action="<?php echo $url; ?>" method="post" name="hikashop_filter_form_<?php echo $this->params->get('main_div_name'); ?>" <?php echo $form_attributes; ?> enctype="multipart/form-data" class="regForm">
                                            <div class="uk-child-width-1-1 uk-grid-small uk-grid-divider" data-uk-grid>
                                                <?php
                                                while($count<$this->maxFilter+1){
                                                    $height='';
                                                    $activeClass = '';
                                                    if(!empty($filters[$count]->filter_height)){
                                                        $height='min-height:'.$filters[$count]->filter_height.'px;';
                                                    }else if(!empty($this->heightConfig)){
                                                        $height='min-height:'.$this->heightConfig.'px;';
                                                    }
                                                    if(!empty($filters[$count]->filterActive)){
                                                        $activeClass = 'filter_active ';
                                                    }
                                                    if(!empty($html[$count])){
                                                        if($filters[$count]->filter_options['column_width']>$this->maxColumn) $filters[$count]->filter_options['column_width'] = $this->maxColumn;
                                                        ?>
                                                        <div class="hikashop_filter_main hikashop_filter_main_<?php echo $filters[$count]->filter_namekey; ?>">
                                                            <?php echo '<div class="uk-text=zero '.$activeClass.'hikashop_filter_'.$filters[$count]->filter_namekey.'">'.$html[$count].'</div>'; ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    $count++;
                                                }
                                                if($this->buttonPosition=='inside'){
                                                    if($this->showButton ){
                                                        $js = "
document.getElementById('hikashop_filtered_" . $this->params->get('main_div_name') . "').value='1';
" . $submit . "
return false;
";
                                                        ?>
                                                        <div class="hikashop_filter_button_inside">
                                                            <input type="submit" id="hikashop_filter_button_<?php echo $this->params->get('main_div_name'); ?>" class="<?php echo $this->config->get('css_button', 'hikabtn'); ?>" <?php echo $attributes; ?> onclick="<?php echo $js; ?>" value="<?php echo JText::_('FILTER'); ?>" />
                                                        </div>
                                                        <?php
                                                    }
                                                    if($this->showResetButton ){
                                                        $js = "
document.getElementById('hikashop_reseted_" . $this->params->get('main_div_name') . "').value='1';
" . $submit . "
return false;
";
                                                        ?>
                                                        <div class="hikashop_reset_button_inside">
                                                            <a href="#" id="hikashop_reset_button_<?php echo $this->params->get('main_div_name'); ?>" class="<?php echo $this->config->get('css_button', 'hikabtn'); ?>" <?php echo $attributes; ?> onclick="<?php echo $js; ?>"><?php echo JText::_('RESET'); ?></a>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="return_url" value="<?php echo $url;?>"/>
                                                <input type="hidden" name="filtered" id="hikashop_filtered_<?php echo $this->params->get('main_div_name');?>" value="1" />
                                                <input type="hidden" name="reseted" id="hikashop_reseted_<?php echo $this->params->get('main_div_name');?>" value="0" />
                                            </div>
                                        </form>
                                        <?php
                                        if($this->displayFieldset){
                                        ?>
                                    </div>
                                <?php
                                }
                                if($this->buttonPosition!='inside'){
                                    $style='';
                                    if($this->buttonPosition=='right'){ $style=''; }
                                    if($this->showButton){
                                        $js = "
document.getElementById('hikashop_filtered_" . $this->params->get('main_div_name') . "').value='1';
" . $submit . "
return false;
";
                                        ?>
                                        <span class="hikashop_filter_button_outside">
                                            <div class="uk-padding-small uk-padding-remove-horizontal"><hr class="uk-margin-remove"></div>
		<input type="submit" id="hikashop_filter_button_<?php echo $this->params->get('main_div_name'); ?>" class="uk-button uk-button-success uk-border-rounded uk-width-1-1 uk-display-block uk-box-shadow-small font <?php echo $this->config->get('css_button', 'hikabtn'); ?>" onclick="<?php echo $js; ?>" <?php echo $attributes; ?> value="<?php echo JText::_('FILTERPRODUCTS'); ?>" />
	</span>
                                        <?php
                                    }
                                    if($this->showResetButton){
                                        $js = "
document.getElementById('hikashop_reseted_" . $this->params->get('main_div_name') . "').value='1';
" . $submit . "
return false;
";
                                        ?>
                                        <span class="hikashop_reset_button_outside" <?php echo $style; ?>>
		<a href="#" id="hikashop_reset_button_<?php echo $this->params->get('main_div_name'); ?>" class="<?php echo $this->config->get('css_button', 'hikabtn'); ?>" onclick="<?php echo $js; ?>" <?php echo $attributes; ?> ><?php echo JText::_('RESET'); ?></a>
	</span>
                                        <?php
                                    }
                                }
                                ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script type="text/javascript">
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        jQuery(document).ready(function () {
            UIkit.accordion('#filtersAccordion').toggle(0, false);
        });
    }
</script>