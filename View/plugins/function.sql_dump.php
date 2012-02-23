<?php

function smarty_function_sql_dump($params, $template) {
	if (class_exists('ConnectionManager') and Configure::read('debug') >= 2) {
		foreach (App::path('views') as $path) {
			$file = $path . 'elements' . DS . 'sql_dump.ctp';
			if (file_exists($file)) {
				ob_start();
				include $file;
				return ob_get_clean();
			}
		}
	}
	
	return '';
}

