<?php

function smarty_block_link($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	
	if (!is_null($content)) {
		$html = $smarty->viewHelper('link', 'html');
		
		$url = $smarty->fetchVar($params, 'href', 'url');
		$confirm = $smarty->fetchVar($params, 'confirm', 'confirmMessage');
		
		if (empty($url)) {
			$url = Router::url($params);
			unset($params['controller']);
			unset($params['action']);
			unset($params['plugin']);
			unset($params['prefix']);
		}
		
		$smarty->fixHtmlAttributes($params);
		
		$params['escape'] = false;
		return $html->link($content, $url, $params, $confirm);
	}
}

