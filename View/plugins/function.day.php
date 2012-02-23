<?php

function smarty_function_day($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('day', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$selected = $s->fetchVar($params, 'selected');
	
	return $form->day($name, $selected, $params);
}

