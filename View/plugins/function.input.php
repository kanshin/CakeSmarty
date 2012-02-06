<?php

function smarty_function_input($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('input', 'form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	
	return $form->input($name, $params);
}

