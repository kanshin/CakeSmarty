<?php

/*
	日付をフォーマットして返す
	渡す値はstrtotimeでタイムスタンプに変換できる文字列か
	タイムスタンプを示す整数。
	
	フォーマットの指定は以下の二種類
	
	・設定ファイルで指定する
		config/default.ini
			date_format = "..."
	・引数で指定する
		{$var|date:"..."}
	
	フォーマットに%が含まれていればstrftime, 含まれてなければdateが使われる	
 */
function smarty_modifier_date($value, $format = null) {
	if (empty($format)) {
		$smarty = SmartyView::smarty();
		
		try {
			$format = $smarty->getConfigVars('date_format');
		} catch (SmartyException $e) {
			$format = 'Y.n.j';
		}
	}
	
	if (is_string($value)) {
		if (ctype_digit($value)) {
			$value = intval($value);
		} else {
			$value = strtotime($value);
		}
		
		if ($value === false) {
			return '#INVALID#';
		}
	}
	
	if (strpos($format, '%') !== false) {
		return strftime($format, $value);
	}
	
	return date($format, $value);
}

