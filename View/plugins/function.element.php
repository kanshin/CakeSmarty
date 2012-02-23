<?php

function smarty_function_element($params, $template) {
	return $template->smarty->view->element($params['name']);
}

