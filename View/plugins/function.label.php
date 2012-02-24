<?php

function smarty_function_label($params, $template) {
	if (property_exists($template->smarty->view, 'Form')) {
			trigger_error("{label} command requires Form helper.", E_USER_ERROR);
	}
	
	$name = 'foo';
	$text = null;
	
	extract(compact('template') + $params);
	
	unset($params['name']);
	unset($params['text']);
	
	$form = $template->smarty->view->Form;
	
	
	return $form->label($name, $text, $params);
}

