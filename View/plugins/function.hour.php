<?php

function smarty_function_hour($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('hour', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$format24hours = $s->fetchVar($params, 'format24hours', 'format24', 'f24', 'twentyfour');
	$selected = $s->fetchVar($params, 'selected');
	
	if (!is_null($format24hours)) $format24hours = true;
	
	return $form->hour($name, $format24hours, $selected, $params);
}

