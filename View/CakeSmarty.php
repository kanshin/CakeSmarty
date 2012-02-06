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
 * Include Smarty. By default expects it at ( 'Vendor'.DS.'smarty'.DS.'Smarty.class.php' )
 */

App::import('Vendor', 'Smarty.Smarty', array('file' => 'smarty'.DS.'libs'.DS.'Smarty.class.php'));
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
		if (!property_exists($this->view, $name)) {
			$name = ucfirst($name);
			trigger_error("{$command} command requires $name helper.", E_USER_ERROR);
		}

		return $this->view->$name;
	}
}
