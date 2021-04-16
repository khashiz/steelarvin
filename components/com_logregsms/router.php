<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_logregsms
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Routing class from com_logregsms
 *
 * @package     Joomla.Site
 * @subpackage  com_logregsms
 * @since       3.3
 */
class LogRegSmsRouter extends JComponentRouterBase
{
	
	public $_db = null;
	
	public function __construct() {
		parent::__construct();
		$this->_db = JFactory::getDbo();
	}
	/*
	 * Build the route for the com_content component
	 *
	 * @param   array  &$query  An array of URL arguments
	 *
	 * @return  array  The URL arguments to use to assemble the subsequent URL.
	 *
	 * @since   3.3
	 */
	public function build(&$query)
	{		

	}

	/**
	 * Parse the segments of a URL.
	 *
	 * @param   array  &$segments  The segments of the URL to parse.
	 *
	 * @return  array  The URL attributes to be used by the application.
	 *
	 * @since   3.3
	 */
	public function parse(&$segments)
	{
		
	}// function

	public function getItemId($category_id)
	{
		$app      = JFactory::getApplication();
		$menus    = $app->getMenu('site');	
		$component  = JComponentHelper::getComponent('com_logregsms');
		$attributes = array('component_id');
		$values     = array($component->id);
		$category_id = (int) $category_id;	
		$items = $menus->getItems($attributes, $values);
		
		// if category is child item
		// system should find parent id
		$categories = $this->getCategory();
		$arrCat = array();
		for($i = 0; $i < count($categories); $i++){
			$arrCat[$i]['id'] = $categories[$i]->id;
			$arrCat[$i]['parent'] = $categories[$i]->parent_id;
		}
	
		$parent_ids = $this->get_parent($arrCat,$category_id,array());
		if( is_array($parent_ids) and !empty($parent_ids) ){
			foreach($parent_ids as $category_id){
				$category_id = intval($category_id);
				foreach( $items as $item){
					if($item->component == "com_logregsms" && isset($item->query['category_id'])){
						$MCatid = (int)$item->query['category_id'];
						if($MCatid === $category_id)
							return $item->id;
					}
				}
			}
		}
		
		
		// if this category has no menu 
		foreach( $items as $item){
			if(isset($item->query['view']) && $item->query['view'] == "categories")
				return $item->id;
		}

		$default = $menus->getDefault();
		return !empty($default->id) ? $default->id : null;	
	}// function
	
	public function get_key($arr, $id)
	{
		
		foreach ($arr as $key => $val) {
			if ($val['id'] == $id) {
				return $key;
			}
		}
		return null;
	}// function
	
	public function get_parent($arr, $id,$result=array())
	{
		$id = (string)$id;
		$key = $this->get_key($arr, $id);
		if($key === null)
			return null;
		if ($arr[$key]['parent'] == '1'){
			$result[] = $id;
			return $result;
		}else{	
			$result[] = $id;	
			return self::get_parent($arr, $arr[$key]['parent'],$result);
		}
	}// function
	
	public function getCategory($id = 0, $alias = ""){
		// clear database
		$this->_db->clear();
		
		// query
		$query = $this->_db->getQuery(true)
			->select("*")
			->from('#__categories')
			->where($this->_db->quoteName('extension') . ' = ' . $this->_db->quote('com_logregsms'))
			->where($this->_db->quoteName('published') . ' = 1');
		
		if(intval($id) > 0) {
			$query->where($this->_db->quoteName('id') . ' = ' . intval($id));
		}
		
		if(!empty($alias)) {
			$query->where($this->_db->quoteName('alias') . ' = ' . $this->_db->quote($alias));
		}
		
		$this->_db->setQuery($query);
		
		if(intval($id) > 0 || !empty($alias)){
			$result = $this->_db->loadObject();
		} else {
			$result = $this->_db->loadObjectList();
		}
		
		return $result;
	}// function
	
	public function getOneMenu($view = "") {
		$app      = JFactory::getApplication();
		$menus    = $app->getMenu('site');	
		$component  = JComponentHelper::getComponent('com_logregsms');
		$attributes = array('component_id');
		$values     = array($component->id);	
		$items = $menus->getItems($attributes, $values);
		
		// if this category has no menu 
		foreach( $items as $item){
			if(isset($item->query['view']) && $item->query['view'] == $view)
				return $item->id;
		}

		$default = $menus->getDefault();
		return !empty($default->id) ? $default->id : null;	
	}// function
}// class

/**
 * Content router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function LogRegSmsBuildRoute(&$query)
{
	//$router = new LogRegSmsRouter();
	//return $router->build($query);
}

function LogRegSmsParseRoute($segments)
{
	//$router = new LogRegSmsRouter();
	//return $router->parse($segments);
}
