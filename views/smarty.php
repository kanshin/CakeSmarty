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
App::import('View', 'Theme');

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

class SmartyView extends ThemeView {
	static public function smarty($view = null) {
		$smarty = new CakeSmarty();
		$smarty->view = $view;
		
		$smarty->plugins_dir[] = VIEWS.'plugins'.DS;
		$smarty->plugins_dir[] = dirname(__FILE__). DS. 'plugins'.DS;
		$smarty->compile_dir = TMP.'smarty'.DS.'compile'.DS;
		$smarty->cache_dir = TMP.'smarty'.DS.'cache'.DS;
		$smarty->template_dir = VIEWS.DS;
		$smarty->config_dir = VIEWS. DS. 'config'.DS;
		
		$smarty->cache = false;
		
		try {
			$smarty->configLoad('default.ini');
		} catch (SmartyException $e) {
			$obj = new Object();
			$obj->log("can't find 'default.ini'", LOG_DEBUG);
			// ignore
		}
		
		return $smarty;
	}
	
/**
 * SmartyView constructor
 *
 * @param  $controller instance of calling controller
 */
	function __construct (&$controller) {
		parent::__construct($controller);
		
		$this->Smarty = SmartyView::smarty($this);
		
		if ($this->ext == '.ctp') {
			$this->ext = '.html';
		}
	}

/**
 * Renders and returns output for given view filename with its
 * array of data. If viewFilename has extension .ctp, then it delegates
 * the rendering to parent.
 *
 * @param string $___viewFn Filename of the view
 * @param array $___dataForView Data to include in rendered view
 * @param boolean $loadHelpers Boolean to indicate that helpers should be loaded.
 * @param boolean $cached Whether or not to trigger the creation of a cache file.
 * @return string Rendered output
 * @access protected
 */
	function _render($___viewFn, $___data_for_view, $loadHelpers = true, $cached = false) {
		$ext = pathinfo($___viewFn, PATHINFO_EXTENSION);
		if ($ext == 'ctp') {
			return parent::_render($___viewFn, $___data_for_view, $loadHelpers, $cached);
		}
		
		if ($this->helpers != false and $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);
			$helpers = array_keys($loadedHelpers);
			
			foreach ($loadedHelpers as $name => $helper) {
				$helperName = Inflector::variable($name);
				$this->loaded[$helperName] = $helper;
				$this->{$name} = $helper;
			}
			$this->_triggerHelpers('beforeRender');
			
			foreach ($this->loaded as $name => $helper) {
				$this->Smarty->assignByRef($name, $helper);
			}
		}
		
		foreach($___data_for_view as $data => $value) {
			if (!is_object($data)) {
				$this->Smarty->assign($data, $value);
			}
		}
		
		$this->Smarty->assignByRef('view', $this);
		$this->Smarty->cache = $cached;
		
		$out = $this->Smarty->fetch($___viewFn);
		
		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}
		
		return $out;
	}
}

