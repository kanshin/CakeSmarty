<?php

function smarty_function_year($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('year', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$minYear = $s->fetchVar($params, 'minYear', 'min');
	$maxYear = $s->fetchVar($params, 'maxYear', 'max');
	$selected = $s->fetchVar($params, 'selected');
	
	return $form->year($name, $minYear, $maxYear, $selected, $params);
}

