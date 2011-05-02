<?php

function smarty_function_inputs($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{inputs} command requires Form helper.", E_USER_ERROR);
	}
	
	$fields = null;
	
	extract(compact('template') + $params);
	
	unset($params['fields']);
	
	$form = $template->smarty->view->loaded['form'];
	
	
	return $form->inputs($fields, $params);
}

