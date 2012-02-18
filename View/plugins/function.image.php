<?php

function smarty_function_image($params, $template) {
	$smarty = $template->smarty;
	
	$html = $smarty->viewHelper('image', 'Html');
	$url = $smarty->fetchVar($params, 'src', 'path', 'url');
	
	$smarty->fixHtmlAttributes($params);
	
	return $html->image($url, $params);
}

