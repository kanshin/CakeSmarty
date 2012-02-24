<?php

function smarty_function_querystring($params, $template) {
	if (count($params) == 1 and isset($params['params'])) {
		$params = $params['params'];
	}
	
	return Router::queryString($params);
}

