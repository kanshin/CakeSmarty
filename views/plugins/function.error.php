<?php

function smarty_function_error($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{error} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'foo';
	$text = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['text']);
	
	$form = $template->smarty->view->loaded['form'];
	
	return $form->error($name, $text, $params);
}

