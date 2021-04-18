<?php
/**
* @title				Minitek System Messages
* @copyright   	Copyright (C) 2011-2020 Minitek, All rights reserved.
* @license   		GNU General Public License version 3 or later.
* @author url   https://www.minitek.gr/
* @developers   Minitek.gr / Yannis Maragos
*/

defined('_JEXEC') or die;

class JFormFieldAlertBox extends JFormField
{
	public $type = 'AlertBox';
	private $params = null;

	protected function getLabel()
	{
		return '';
	}

	protected function getInput()
	{
		$this->params = $this->element->attributes();

		$alert = $this->get('alert') ? $this->get('alert') : 'info';
		$label = $this->get('label');
		$icon = $this->get('icon');

		if (!$description = $this->get('description'))
		{
			return;
		}

		$html = '<div class="alert alert-'.$alert.'">';

		if ($label)
		{
			$html .= '<h3>';

			if ($icon)
			{
				$html .= '<i class="icon icon-'.$icon.'"></i>&nbsp;&nbsp;';
			}

			$html .= JText::_($label).'</h3>';
		}

		$html .= '<p>'.JText::_($description).'</p>';
		$html .= '</div>';

		return $html;
	}

	private function get($val, $default = '')
	{
		return (isset($this->params[$val]) && (string) $this->params[$val] != '') ? (string) $this->params[$val] : $default;
	}
}
