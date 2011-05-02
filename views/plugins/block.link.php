<?php

function smarty_block_link($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	
	if (!is_null($content)) {
		$html = $smarty->viewHelper('link', 'html');
		
		$url = $smarty->fetchVar($params, 'href', 'url');
		$confirm = $smarty->fetchVar($params, 'confirm', 'confirmMessage');
		
		$smarty->fixHtmlAttributes($params);
		
		return $html->link($content, $url, $params, $confirm);
	}
}

