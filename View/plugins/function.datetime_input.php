<?php

function smarty_function_datetime($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('datetime', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$date = $s->fetchVar($params, 'date');
	$time = $s->fetchVar($params, 'time');
	$selected = $s->fetchVar($params, 'selected');
	
	if (!$date) $date = 'YMD';
	if (!$time) $time = '24';
	
	return $form->datetime($name, $date, $time, $selected, $params);
}

