<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty convert to unix
 *
 * Type:     modifier
 * Name:     convertunix
 * Purpose:  convert unix timestamp to date
 * @author   Frank Broersen
 * @param string
 * @return string
 */
function smarty_modifier_convertunix($sString,$sFormat)
{
    return gmdate($sFormat, $sString);
}
?>