<?php

function smarty_function_minute($params, $template) {
	if (property_exists($template->smarty->view, 'Form')) {
		trigger_error("{minute} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'minute';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['selected']);
	
	$form = $template->smarty->view->Form;
	
	return $form->minute($name, $selected, $params);
}

