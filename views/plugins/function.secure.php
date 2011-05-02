<?php

function smarty_function_button($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{button} command requires Form helper.", E_USER_ERROR);
	}
	
	$title = 'button';
	
	extract(compact('template') + $params);
	
	unset($params['title']);
	
	$form = $template->smarty->view->loaded['form'];
	
	
	return $form->button($title, $params);
}

