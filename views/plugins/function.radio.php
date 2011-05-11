<?php

function smarty_function_radio($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('radio', 'form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$options = $s->fetchVar($params, 'options', 'values');
	
	return $form->radio($name, $options, $params);
}

