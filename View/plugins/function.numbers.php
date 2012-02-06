<?php

function smarty_function_numbers($params, $template) {
	$s = $template->smarty;
	$paginator = $s->viewHelper('numbers', 'paginator');
	$s->fixHtmlAttributes($params);
	
	return $paginator->numbers($params);
}

