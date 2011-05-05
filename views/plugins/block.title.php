<?php

function smarty_block_title($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	
	if (!is_null($content)) {
		$title = trim($content);
		if ($title) {
			$smarty->view->set('title_for_layout', $title);
		}
	}
}

