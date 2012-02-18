<?php

function smarty_function_inputs($params, $template) {
	if (property_exists($template->smarty->view, 'Form')) {
		trigger_error("{inputs} command requires Form helper.", E_USER_ERROR);
	}
	
	$fields = null;
	
	extract(compact('template') + $params);
	
	unset($params['fields']);
	
	$form = $template->smarty->view->Form;
	
	
	return $form->inputs($fields, $params);
}

