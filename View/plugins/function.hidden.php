<?php

function smarty_function_hidden($params, $template) {
	if (!property_exists($template->smarty->view, 'Form')) {
		trigger_error("{hidden} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'foo';
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	
	$form = $template->smarty->view->Form;
	
	
	return $form->hidden($name, $params);
}

