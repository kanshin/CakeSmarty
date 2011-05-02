<?php

function smarty_function_password($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{password} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'foo';
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	
	$form = $template->smarty->view->loaded['form'];
	
	
	return $form->password($name, $params);
}

