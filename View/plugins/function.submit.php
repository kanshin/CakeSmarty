<?php

function smarty_function_submit($params, $template) {
	$s = $template->smarty;
	$form = $s->viewHelper('submit', 'Form');
	$s->fixHtmlAttributes($params);
	
	$caption = $s->fetchVar($params, 'caption', 'title', 'value', 'src', 'url');
	
	return $form->submit($caption, $params);
}

