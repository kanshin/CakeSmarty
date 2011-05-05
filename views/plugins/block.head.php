<?php

function smarty_block_head($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	
	if (!is_null($content)) {
		$line = trim($content);
		if ($line) {
			$smarty->view->addScript($line);
		}
	}
}

