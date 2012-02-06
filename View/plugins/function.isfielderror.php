<?php

function smarty_function_isfielderror($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{isfielderror} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'foo';
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	
	$form = $template->smarty->view->loaded['form'];
	
	
	return $form->isfielderror($name);
}

