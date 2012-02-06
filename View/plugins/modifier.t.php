<?php
/**
 * Translate a text
 * 
 * @author Eiichi Shimotori
 * 
 * @param string $text
 * @return string
 */
function smarty_modifier_t($text)
{
	return __($text);    //__($text, true) for CakePHP 1.x
}
