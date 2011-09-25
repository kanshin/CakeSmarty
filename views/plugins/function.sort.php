<?php

function smarty_function_sort($params, $template) {
	$s = $template->smarty;
	$paginator = $s->viewHelper('sort', 'paginator');
	$s->fixHtmlAttributes($params);
	
	$title = $s->fetchVar($params, 'title', 'label');
	$name = $s->fetchVar($params, 'name', 'key', 'fieldName');
	
	return $paginator->sort($title, $name, $params);
}

