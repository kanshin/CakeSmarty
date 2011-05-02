<?php

function smarty_function_text($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('text', 'form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	
	return $form->text($name, $params);
}

