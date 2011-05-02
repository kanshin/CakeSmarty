<?php

function smarty_function_meridian($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{meridian} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'meridian';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['selected']);
	
	$form = $template->smarty->view->loaded['form'];
	
	return $form->meridian($name, $selected, $params);
}

