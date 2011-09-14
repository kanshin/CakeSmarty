<?php

/**
 * Escape HTML entities. 
 *  a) if parameter 1 is integer,
 *     i.e: $text|h:30  => truncate the string by that count.
 *     parameter 2 is ellipsis symbol (optional).
 *  b) if other parameter passed, 
 *     it converts "\n" to <br>.
 *  c) if 
 * @param $<#arg#> <#description#>
 * @return <#type#> <#description#> 
 */
function smarty_modifier_h($str, $param=null, $param2=null) {
	if (is_string($str)) {
		$str = htmlspecialchars($str);
		
		if (is_int($param)) {
			// truncate
			
			$length = $param;
			$ellipsis = ($param2 ? $param2 : '…');
			
			if ($length > 0 and mb_strlen($str) > $length) {
				$str = mb_substr($str, 0, $length). $ellipsis;
			}
		} else if ($param) {
			// 改行を<br>に
			$str = nl2br($str);
		}
	}
	
	return $str;
}

