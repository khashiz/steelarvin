<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>
<dd class="create">
    <time class="f500 uk-text-muted" datetime="<?php echo JHtml::_('date', $displayData['item']->created, 'c'); ?>" itemprop="dateCreated">
        <?php echo JHtml::_('date', $displayData['item']->created, JText::_('DATE_FORMAT_LC3')); ?>
    </time>
</dd>