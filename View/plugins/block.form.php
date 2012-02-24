<?php

function smarty_block_form($params, $content, $template, &$repeat) {
	$smarty = $template->smarty;
	$form = $smarty->viewHelper('form', 'Form');
	
	if (is_null($content)) {
		// opening tag
		
		$smarty->fixHtmlAttributes($params);
		
		$model = $smarty->fetchVar($params, 'model');
		
		$html = $form->create($model, $params);
		$smarty->pushPluginVar('form:formOpen', $html);
	} else {
		// closing tag
		
		$html = $smarty->popPluginVar('form:formOpen');
		$html .= $content;
		$html .= $form->end();
		
		return $html;
	}
}

