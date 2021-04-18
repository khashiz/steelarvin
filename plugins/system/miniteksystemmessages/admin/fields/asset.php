<?php
/**
* @title				Minitek System Messages
* @copyright   	Copyright (C) 2011-2020 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   https://www.minitek.gr/
* @developers   Minitek.gr / Yannis Maragos
*/

defined('_JEXEC') or die;

class JFormFieldAsset extends JFormField
{
  protected $type = 'Asset';

  protected function getInput()
	{
    $document = JFactory::getDocument();
    $document->addStyleSheet(JURI::root().$this->element['path'].'style.css');
    $document->addStyleSheet('https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css');
    
		return null;
  }
}
