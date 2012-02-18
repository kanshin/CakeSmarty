<?php

function smarty_function_textarea($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('textarea', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	
	return $form->textarea($name, $params);
}

