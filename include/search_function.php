<?php
// $Id: search_function.php,v 1.2 2007/04/15 16:57:22 ohwada Exp $ 

// 2007-04-15 K.OHWADA
// BUG 4394: Fatal error: Call to undefined function: strcut() 
// use happy_linux_strcut()

//=========================================================
// Happy Search
// same as suin's search function.php
// 2006-11-11 K.OHWADA
//=========================================================

// --- function begin ---
if( !function_exists( 'search_make_context' ) ) 
{

// nao-ponさんの本文表示ハック
// BUG 4339: Fatal error: Call to undefined function: strcut() 
function search_make_context($text,$words,$l=255)
{
	if (!is_array($words)) $words = array();

	$ret = "";
	$q_word = str_replace(" ","|",preg_quote(join(' ',$words),"/"));

	if (preg_match("/$q_word/i",$text,$match))
	{
		$ret = ltrim(preg_replace('/\s+/', ' ', $text));
		list($pre, $aft)=preg_split("/$q_word/i", $ret, 2);
		$m = intval($l/2);
		$ret = (strlen($pre) > $m)? "... " : "";
		$ret .= happy_linux_strcut($pre, max(strlen($pre)-$m+1,0),$m).$match[0];
		$m = $l-strlen($ret);
		$ret .= happy_linux_strcut($aft, 0, min(strlen($aft),$m));
		if (strlen($aft) > $m) $ret .= " ...";
	}

	if (!$ret)
		$ret = happy_linux_strcut($text, 0, $l);

	return $ret;
}

function sort_by_date($p1, $p2) {
    return ($p2['time'] - $p1['time']);
}

function &context_search( $funcname, $queryarray, $andor = 'AND', $limit = 0, $offset = 0, $userid = 0){

	if( $funcname=="" ){
		return false;
	}
	return $funcname($queryarray, $andor, $limit, $offset, $userid);

}

// --- function end ---
}

?>