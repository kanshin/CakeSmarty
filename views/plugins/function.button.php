<?php

function smarty_function_button($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('button', 'form');
	$s->fixHtmlAttributes($params);
	
	$title = $s->fetchVar($params, 'title', 'value');
	
	return $form->button($title, $params);
}

