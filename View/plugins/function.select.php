<?php

function smarty_function_select($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('select', 'Form');
	$s->fixHtmlAttributes($params);
	
	$name = $s->fetchVar($params, 'name', 'fieldName');
	$options = $s->fetchVar($params, 'options');
	$selected = $s->fetchVar($params, 'selected');
	
	return $form->select($name, $options, $selected, $params);
}

