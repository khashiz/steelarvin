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
if ($this->direction == 'rtl') {
    JHtml::_('stylesheet', 'uikit-'.$this->direction.'.min.css', array('version' => 'auto', 'relative' => true));
} else {
    JHtml::_('stylesheet', 'uikit.min.css', array('version' => 'auto', 'relative' => true));
}
JHtml::_('stylesheet', $this->direction.'/arvin-'.$this->direction.'.css', array('version' => 'auto', 'relative' => true));

// Add js
JHtml::_('script', 'uikit.min.js', array('version' => 'auto', 'relative' => true));
JHtml::_('script', 'uikit-icons.min.js', array('version' => 'auto', 'relative' => true));
if ($this->direction == 'rtl') {JHtml::_('script', 'persianumber.min.js', array('version' => 'auto', 'relative' => true));}

//$socialsicons = json_decode( $params->get('socials'),true);
//$total = count($socialsicons['icon']);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="<?php echo $params->get('presetcolor'); ?>">
    <jdoc:include type="head" />
</head>
<body>
<header></header>
<jdoc:include type="modules" name="pagetop" style="xhtml" />
<jdoc:include type="message" />
<jdoc:include type="component" />
<jdoc:include type="modules" name="pagebottom" style="xhtml" />
<footer class="uk-text-zero">
    <div class="socials"></div>
    <div class="footer uk-height-small"></div>
    <div class="copyright">
        <div class="uk-container">
            <div class="uk-padding-small uk-padding-remove-horizontal">
                <div class="uk-text-white font" data-uk-grid>
                    <div class="uk-width-1-1 uk-width-expand@m">
                        <p class="uk-text-tiny"><?php echo JTEXT::sprintf('COPYRIGHT', $sitename); ?></p>
                    </div>
                    <div class="uk-width-1-1 uk-width-auto@m">
                        <p class="uk-text-tiny"><?php echo JTEXT::sprintf('DESIGNER', '<a href="https://netparsi.com" class="uk-text-white hover accent" target="_blank" title="'.$netparsi.'">'.$netparsi.'</a>'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>