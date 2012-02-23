<?php

function smarty_function_numbers($params, $template) {
	$s = $template->smarty;
	$paginator = $s->viewHelper('numbers', 'Paginator');
	$s->fixHtmlAttributes($params);
	
	return $paginator->numbers($params);
}

