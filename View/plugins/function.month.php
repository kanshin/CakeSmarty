<?php

function smarty_function_month($params, $template) {
	if (property_exists($template->smarty->view, 'Form')) {
		trigger_error("{month} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'month';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['title']);
	unset($params['selected']);
	
	$form = $template->smarty->view->Form;
	
	return $form->month($title, $selected, $params);
}

