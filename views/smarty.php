<?php
/* SVN FILE: $Id$ */

/**
 * Methods for displaying presentation data
 *
 *
 * PHP versions 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright (c) 2005, Cake Software Foundation, Inc.
 *                     1785 E. Sahara Avenue, Suite 490-204
 *                     Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright    Copyright (c) 2005, Cake Software Foundation, Inc.
 * @link         http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @version      1.0.0.7
 * @package      cake
 * @subpackage   cake.app.views
 * @since        CakePHP v 0.10.4.1693
 * @version      $Revision$
 * @modifiedby   $LastChangedBy$
 * @lastmodified $Date$
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * update: 10/03/07 by tclineks

/**
 * Include Smarty. By default expects it at ( VENDORS.'smarty'.DS.'Smarty.class.php' )
 */

App::import('Vendor', 'Smarty.Smarty', array('file' => 'libs'.DS.'Smarty.class.php'));

class CakeSmarty extends Smarty {
	public $view;
	
	private $plugin_vars = array();
	
	public function pushPluginVar($name, $value) {
		if (empty($this->plugin_vars[$name])) {
			$this->plugin_vars[$name] = array();
		}
		
		$this->plugin_vars[$name][] = $value;
	}
	
	public function popPluginVar($name) {
		if (!empty($this->plugin_vars[$name])) {
			return array_pop($this->plugin_vars[$name]);
		}
	}
	
	public function fetchVar(&$params, $name /* , $name2 */) {
		$args = func_get_args();
		
		foreach (array_slice($args, 1) as $name) {
			if (isset($params[$name])) {
				$var = $params[$name];
				unset($params[$name]);
				return $var;
			}
		}
		
		return null;
	}
	
	public function fixHtmlAttributes(&$params) {
		foreach (array_keys($params) as $key) {
			if (strpos($key, '_') !== false) {
				$params[str_replace('_', '-', $key)] = $params[$key];
				unset($params[$key]);
			}
		}
	}
	
	public function viewHelper($command, $name) {
		if (empty($this->view->loaded[$name])) {
			$name = ucfirst($name);
			trigger_error("{$command} command requires $name helper.", E_USER_ERROR);
		}
		
		return $this->view->loaded[$name];
	}
}

class SmartyView extends View
{
	static public function smarty($view = null) {
		$smarty = new CakeSmarty();
		$smarty->view = $view;
		
		$smarty->plugins_dir[] = VIEWS.'plugins'.DS;
		$smarty->plugins_dir[] = __DIR__. DS. 'plugins'.DS;
		$smarty->compile_dir = TMP.'smarty'.DS.'compile'.DS;
		$smarty->cache_dir = TMP.'smarty'.DS.'cache'.DS;
		$smarty->template_dir = VIEWS.DS;
		$smarty->config_dir = VIEWS. DS. 'config'.DS;
		
		$smarty->cache = true;
		
		try {
			$smarty->configLoad('default.ini');
		} catch (SmartyException $e) {
			$this->debug("can't find 'default.ini'");
			// ignore
		}
		
		return $smarty;
	}
	
/**
 * SmartyView constructor
 *
 * @param  $controller instance of calling controller
 */
	function __construct (&$controller)
	{
		parent::__construct($controller);
		$this->Smarty = SmartyView::smarty($this);
		
		$this->ext= '.html';
	}

/**
 * Overrides the View::_render()
 * Sets variables used in CakePHP to Smarty variables
 *
 * @param string $___viewFn
 * @param string $___data_for_view
 * @param string $___play_safe
 * @param string $loadHelpers
 * @return rendered views
 */
	function _render($___viewFn, $___data_for_view, $___play_safe = true, $loadHelpers = true)
	{
		if ($this->helpers != false && $loadHelpers === true)
		{
			$loadedHelpers =  array();
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);

			foreach(array_keys($loadedHelpers) as $helper)
			{
				$replace = strtolower(substr($helper, 0, 1));
				$camelBackedHelper = preg_replace('/\\w/', $replace, $helper, 1);

				${$camelBackedHelper} =& $loadedHelpers[$helper];
				if(isset(${$camelBackedHelper}->helpers) && is_array(${$camelBackedHelper}->helpers))
				{
					foreach(${$camelBackedHelper}->helpers as $subHelper)
					{
						${$camelBackedHelper}->{$subHelper} =& $loadedHelpers[$subHelper];
					}
				}
				$this->loaded[$camelBackedHelper] = (${$camelBackedHelper});
				$this->Smarty->assignByRef($camelBackedHelper, ${$camelBackedHelper});
			}
		}

		$this->register_functions();

		foreach($___data_for_view as $data => $value)
		{
			if(!is_object($data))
			{
				$this->Smarty->assign($data, $value);
			}
		}
		$this->Smarty->assignByRef('view', $this);
		return $this->Smarty->fetch($___viewFn);
	}
	
/**
 * Returns layout filename for this template as a string.
 *
 * @param string $name The name of the layout to find.
 * @return string Filename for layout file.
 * @return string Filename for layout file.
 * @access private
 */
	function _getLayoutFileName($name = null) {
		if ($name === null) {
			$name = $this->layout;
		}
		$subDir = null;

		if (!is_null($this->layoutPath)) {
			$subDir = $this->layoutPath . DS;
		}
		
		if (isset($this->plugin) && !is_null($this->plugin)) {
			$layoutFileName = APP . 'plugins' . DS . $this->plugin . DS . 'views' . DS . 'layouts' . DS . $this->layout . $this->ext;
			if (file_exists($layoutFileName)) {
				return $layoutFileName;
			}
		}
		
        foreach(App::path('views') as $view_path) { 
            $layoutFileName = $view_path . 'layouts' . DS . $this->layout . $this->ext; 
            if (file_exists($layoutFileName)) { 
                return $layoutFileName; 
            } 
        } 

		$layoutFileName = __DIR__ . DS . 'layouts' . DS . $this->layout. '.html';
		return $layoutFileName;
	}

/**
 * Returns filename of given action's template file (.tpl) as a string. CamelCased action names will be under_scored! This means that you can have LongActionNames that refer to long_action_names views.
 *
 * @param string $action Controller action to find template filename for
 * @return string Template filename
 * @access private
 */
	function _getViewFileName($action) {
		$action = Inflector::underscore($action);

		if (empty($action)) {
			$action = $this->action;
		}

		$position = strpos($action, '..');

		if ($position === false) {
		} else {
			$action = explode('/', $action);
			$i = array_search('..', $action);
			unset($action[$i - 1]);
			unset($action[$i]);
			$action='..' . DS . implode(DS, $action);
		}

		foreach(App::path('views') as $view_path) {
			$viewFileName = $view_path . $this->viewPath . DS . $action . $this->ext;
			if (file_exists($viewFileName)) {
				return $viewFileName;
			}
		}

		$viewFileName = VIEWS . $this->viewPath . DS . $action . $this->ext;

		return $viewFileName;
	}

	/**
	 * checks for existence of special method on loaded helpers, invoking it if it exists
	 * this allows helpers to register smarty functions, modifiers, blocks, etc.
	 */
	function register_functions() {
		foreach(array_keys($this->loaded) as $helper) {
			if (method_exists($this->loaded[$helper], '_register_smarty_functions')) {
				$this->loaded[$helper]->_register_smarty_functions($this->Smarty);
			}
		}
	}
	
	private function path(/* ... */) {
		$cmp = func_get_args();
		return join(DS, array_filter($cmp));
	}
}

