<?php

function smarty_function_month($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{month} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'month';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['title']);
	unset($params['selected']);
	
	$form = $template->smarty->view->loaded['form'];
	
	return $form->month($title, $selected, $params);
}

