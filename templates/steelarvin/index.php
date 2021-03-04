<?php
defined('_JEXEC') or die;
/** @var JDocumentHtml $this */
$app  = JFactory::getApplication();
$user = JFactory::getUser();
// Output as HTML5
$this->setHtml5(true);
// Getting params from template
$params = $app->getTemplate(true)->params;
$menu = $app->getMenu();
$active = $menu->getActive();
$pageparams = $menu->getParams( $active->id );
$pageclass = $pageparams->get( 'pageclass_sfx' );
// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');
$netparsi = JTEXT::_('NETPARSI');

$lang = JFactory::getLanguage();
$languages = JLanguageHelper::getLanguages('lang_code');
$languageCode = $languages[ $lang->getTag() ]->sef;

// Add Stylesheets
if (JFactory::getLanguage()->isRtl()) {
    JHtml::_('stylesheet', 'uikit-rtl.min.css', array('version' => 'auto', 'relative' => true));
    JHtml::_('stylesheet', 'rtl/arvin-rtl.css', array('version' => 'auto', 'relative' => true));
} else {
    JHtml::_('stylesheet', 'uikit.min.css', array('version' => 'auto', 'relative' => true));
    JHtml::_('stylesheet', 'ltr/arvin-ltr.css', array('version' => 'auto', 'relative' => true));
}

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'uikit-icons.min.js', array('version' => 'auto', 'relative' => true));
if (JFactory::getLanguage()->isRtl()) {JHtml::_('script', 'persianumber.min.js', array('version' => 'auto', 'relative' => true));}

$socialsicons = json_decode( $params->get('socials'),true);
$total = count($socialsicons['icon']);
?>
<!DOCTYPE html>
<html lang="<?php echo JFactory::getLanguage()->getTag(); ?>" dir="<?php echo JFactory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="<?php echo $params->get('presetcolor'); ?>">
    <jdoc:include type="head" />
</head>
<body>
<header id="header"><jdoc:include type="modules" name="header" style="xhtml" /></header>
<main data-uk-height-viewport="expand: true"></main>
<jdoc:include type="modules" name="pagetop" style="xhtml" />
<jdoc:include type="message" />
<jdoc:include type="component" />
<jdoc:include type="modules" name="pagebottom" style="xhtml" />
<footer class="uk-text-zero">
    <div class="socials">
        <div class="uk-container">
            <div>
                <div class="uk-child-width-1-1 uk-child-width-1-3@m" data-uk-grid>
                    <div>
                        <div class="uk-padding-small bgAccent">
                            <div class="uk-grid-small uk-child-width-auto uk-flex-center" data-uk-grid>
                                <div class="uk-flex uk-flex-middle"><span class="uk-text-white uk-text-small font"><?php echo JTEXT::_('FOLLOWUS'); ?></span></div>
                                <div>
                                    <div>
                                        <div class="uk-child-width-auto uk-grid-small" data-uk-grid>
                                            <?php for($i=0;$i<$total;$i++) { ?>
                                                <?php if ($socialsicons['link'][$i] != '') { ?>
                                                    <div>
                                                        <a href="<?php echo $socialsicons['link'][$i]; ?>" class="uk-text-white hoverWhite" target="_blank" title="<?php echo $socialsicons['title'][$i]; ?>" data-uk-tooltip="offset: 28"><img src="<?php echo JURI::base().'images/sprite.svg#'.$socialsicons['icon'][$i] ?>" width="24" height="24" data-uk-svg></a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
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
    <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-top footer bgDark">
        <div class="uk-container">
            <div data-uk-grid>
                <div class="uk-width-1-1 uk-width-1-3@m">
                    <div>
                        <div class="uk-padding bgWhite">
                            <div>
                                <div class="uk-child-width-1-1 uk-grid-medium" data-uk-grid>
                                    <div>
                                        <a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>" class="uk-display-inline-block uk-text-primary hoverPrimary" target="_self"><img src="<?php echo JURI::base().'images/sprite.svg#logo'.$languageCode; ?>" width="150" alt="<?php echo $sitename; ?>" data-uk-svg></a>
                                    </div>
                                    <?php if (!empty($params->get('address'.$languageCode)) || !empty($params->get('phone')) || !empty($params->get('fax')) || !empty($params->get('cellphone')) || !empty($params->get('email'))) { ?>
                                        <div>
                                            <div>
                                                <div class="uk-child-width-1-1 uk-grid-divider uk-grid-small" data-uk-grid>
                                                    <?php if (!empty($params->get('address'.$languageCode))) { ?>
                                                        <div>
                                                            <div>
                                                                <div class="uk-grid-small contactFields" data-uk-grid>
                                                                    <div class="uk-width-auto uk-text-accent"><img src="<?php echo JURI::base().'images/sprite.svg#map' ?>" width="20" height="20" alt="" data-uk-svg></div>
                                                                    <div class="uk-width-expand"><span class="uk-text-tiny uk-text-primary value font"><?php echo $params->get('address'.$languageCode); ?></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (!empty($params->get('phone')) || !empty($params->get('fax')) || !empty($params->get('cellphone'))) { ?>
                                                        <div>
                                                            <div>
                                                                <div class="uk-child-width-1-2" data-uk-grid>
                                                                    <?php if (!empty($params->get('phone'))) { ?>
                                                                        <div>
                                                                            <div>
                                                                                <div class="uk-grid-small contactFields" data-uk-grid>
                                                                                    <div class="uk-width-auto uk-text-accent"><img src="<?php echo JURI::base().'images/sprite.svg#phone' ?>" width="20" height="20" alt="" data-uk-svg></div>
                                                                                    <div class="uk-width-expand"><span class="uk-text-small uk-text-primary value font"><?php echo nl2br($params->get('phone')); ?></span></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                    <?php if (!empty($params->get('fax')) || !empty($params->get('cellphone'))) { ?>
                                                                        <div>
                                                                            <div>
                                                                                <div class="uk-child-width-1-1 uk-grid-small" data-uk-grid>
                                                                                    <?php if (!empty($params->get('fax'))) { ?>
                                                                                        <div>
                                                                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                                                                <div class="uk-width-auto uk-text-accent"><img src="<?php echo JURI::base().'images/sprite.svg#fax' ?>" width="20" height="20" alt="" data-uk-svg></div>
                                                                                                <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-primary value font"><?php echo $params->get('fax'); ?></span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                    <?php if (!empty($params->get('cellphone'))) { ?>
                                                                                        <div>
                                                                                            <div class="uk-grid-small contactFields" data-uk-grid>
                                                                                                <div class="uk-width-auto uk-text-accent"><img src="<?php echo JURI::base().'images/sprite.svg#mobile' ?>" width="20" height="20" alt="" data-uk-svg></div>
                                                                                                <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-primary value font"><?php echo $params->get('cellphone'); ?></span></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if (!empty($params->get('email'))) { ?>
                                                        <div>
                                                            <div>
                                                                <div class="uk-grid-small contactFields" data-uk-grid>
                                                                    <div class="uk-width-auto uk-text-accent"><img src="<?php echo JURI::base().'images/sprite.svg#envelope' ?>" width="20" height="20" alt="" data-uk-svg></div>
                                                                    <div class="uk-width-expand uk-flex uk-flex-middle"><span class="uk-text-small uk-text-primary value font"><?php echo $params->get('email'); ?></span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-1 uk-width-2-3@m">
                    <div>
                        <div class="uk-padding uk-padding-remove-horizontal uk-padding-remove-bottom modulesWrapper">
                            <div>
                                <div class="uk-child-width-1-1 uk-child-width-1-4@m" data-uk-grid>
                                    <jdoc:include type="modules" name="footer" style="xhtml" />
                                    <div class="uk-flex uk-flex-column uk-flex-between">
                                        <div class="uk-padding-small uk-text-center enamadWrapper"><img src="images/enamad.png" width="125" height="136"></div>
                                        <div class="uk-text-left uk-visible@m">
                                            <a class="transition uk-flex uk-flex-middle uk-flex-left font goToTop" href="#header" data-uk-scroll>
                                                <span><img src="<?php echo JURI::base().'images/sprite.svg#chevron-circle-up' ?>" width="12" height="12" alt="" data-uk-svg></span>
                                                <span class="uk-text-tiny">&ensp;<?php echo JTEXT::_('GOTOTOP'); ?></span>
                                            </a>
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
    <div class="copyright">
        <div class="uk-container">
            <div class="uk-padding-small uk-padding-remove-horizontal">
                <div class="uk-grid-small uk-text-white uk-text-center uk-text-<?php echo JFactory::getLanguage()->isRtl() ? 'right' : 'left' ?>@m font" data-uk-grid>
                    <div class="uk-width-1-1 uk-width-expand@m">
                        <p class="uk-text-tiny"><?php echo JTEXT::sprintf('COPYRIGHT', $sitename); ?></p>
                    </div>
                    <div class="uk-width-1-1 uk-width-auto@m">
                        <p class="uk-text-tiny"><?php echo JTEXT::sprintf('DESIGNER', '<a href="https://netparsi.com" class="uk-text-white hoverAccent" target="_blank" title="'.$netparsi.'">'.$netparsi.'</a>'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>