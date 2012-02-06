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
 * @package      cake
 * @subpackage   cake.app.views
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License

/**
 * Include Smarty. By default expects it at ( VENDORS.'smarty'.DS.'Smarty.class.php' )
 */

//App::import('Vendor', 'Smarty.Smarty', array('file' => 'libs'.DS.'Smarty.class.php'));
//App::import('Vendor', 'Smarty', array('file' => 'smarty'.DS.'Smarty.class.php'));
App::import('View', 'Theme');
App::uses('CakeSmarty', 'Smarty.View');

class SmartyView extends ThemeView {
	private $smarty;

	static public function smarty($view = null) {
		$smarty = new CakeSmarty();
		$smarty->view = $view;

		$smarty->setPluginsDir(array(
			dirname(__FILE__).DS.'..'.DS.'Vendor'.DS.'smarty'.DS.'libs'.DS.'plugins'.DS,
			dirname(__FILE__).DS.'plugins'.DS,
			APP.DS.'View'.DS.'Smarty'.DS.'plugins'.DS,
		));
		$smarty->compile_dir = TMP.'smarty'.DS.'compile'.DS;
		$smarty->cache_dir = TMP.'smarty'.DS.'cache'.DS;
		$smarty->template_dir = APP.DS.'View'.DS;
		$smarty->config_dir = APP.DS.'View'. DS. 'Smarty'.DS;

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

		if ($this->ext == '.ctp') {
			$this->ext = '.tpl';
		}
		$this->smarty = SmartyView::smarty($this);
		$this->viewVars['params'] = $this->params;
		$this->Helpers = new HelperCollection($this);
	}

/**
* Renders and returns output for given view filename with its
* array of data. If viewFilename has extension .ctp, then it delegates
* the rendering to parent.
*
* @param string $___viewFn Filename of the view
* @param array $___dataForView Data to include in rendered view
* @return string Rendered output
* @access protected
*/
	function _render($___viewFn, $___data_for_view = array()) {
		$ext = pathinfo($___viewFn, PATHINFO_EXTENSION);
		if ($ext == 'ctp') {
			return parent::_render($___viewFn, $___data_for_view);
		}

		if (empty($___data_for_view)) {
			$___data_for_view = $this->viewVars;
		}
		extract($___data_for_view, EXTR_SKIP);

		foreach($___data_for_view as $data => $value) {
			if (!is_object($data)) {
				$this->smarty->assign($data, $value);
			}
		}

		$this->smarty->assignByRef('view', $this);

		$out = $this->smarty->fetch($___viewFn);

		return $out;
	}

/**
 * Interact with the HelperCollection to load all the helpers.
 *
 * @return void
 */
	public function loadHelpers() {
		$helpers = HelperCollection::normalizeObjectArray($this->helpers);
		foreach ($helpers as $name => $properties) {
			list($plugin, $class) = pluginSplit($properties['class']);
			$this->{$class} = $this->Helpers->load($properties['class'], $properties['settings']);
			$this->smarty->assign($name, $this->{$class});
		}
		$this->_helpersLoaded = true;
	}

}

