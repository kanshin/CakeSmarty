<?php

function smarty_function_meridian($params, $template) {
	if (property_exists($template->smarty->view, 'Form')) {
		trigger_error("{meridian} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'meridian';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['selected']);
	
	$form = $template->smarty->view->Form;
	
	return $form->meridian($name, $selected, $params);
}

