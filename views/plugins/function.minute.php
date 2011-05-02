<?php

function smarty_function_minute($params, $template) {
	if (empty($template->smarty->view->loaded['form'])) {
		trigger_error("{minute} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'minute';
	$selected = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['selected']);
	
	$form = $template->smarty->view->loaded['form'];
	
	return $form->minute($name, $selected, $params);
}

