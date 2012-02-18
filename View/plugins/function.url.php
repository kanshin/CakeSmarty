<?php

function smarty_function_url($params, $template) {
	$s = $template->smarty;
	$s->fixHtmlAttributes($params);

	if (isset($params['c']) and !isset($params['controller'])) {
		$params['controller'] = $params['c'];
		unset($params['c']);
	}

	if (isset($params['a']) and !isset($params['action'])) {
		$params['action'] = $params['a'];
		unset($params['a']);
	}

	if (isset($params['p']) and !isset($params['plugin'])) {
		$params['plugin'] = $params['p'];
		unset($params['p']);
	}

	//Others param that is specified with o=string or o=array
	if (isset($params['o'])) {
		$others = is_array($params['o']) ? $params['o'] : array($params['o']);
		$params = am($params, $others);
		unset($params['o']);
	}

	return Router::url($params);
}

