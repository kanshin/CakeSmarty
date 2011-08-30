<?php

function smarty_function_password($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('password', 'form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	
	return $form->password($name, $params);
}

