<?php

function smarty_function_checkbox($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('checkbox', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	
	return $form->checkbox($name, $params);
}

