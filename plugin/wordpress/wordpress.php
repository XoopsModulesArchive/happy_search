<?php
// $Id: wordpress.php,v 1.2 2007/11/02 12:54:09 ohwada Exp $

// 2007-10-10 K.OHWADA
// convert bb_code
// give up other text filter

//=========================================================
// Happy Search
// wordpress 0.50 <http://www.kowa.org/>
// porting from xoops_search.php
// 2007-10-10 K.OHWADA
//=========================================================

$mydirname = basename( dirname( __FILE__ ) ) ;

eval( '

function b_search_'. $mydirname .'($queryarray, $andor, $limit, $offset, $uid){
	return b_search_wordpress_base("'. $mydirname .'" ,$queryarray, $andor, $limit, $offset, $uid) ;
}

' ) ;

// === b_search_wordpress_base ===
if( ! function_exists( 'b_search_wordpress_base' ) ) 
{

function b_search_wordpress_base($mydirname, $queryarray, $andor, $limit, $offset, $userid)
{

// get $mydirnumber
	if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
	$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

	global $xoopsDB;
	$myts =& MyTextSanitizer::getInstance();

	$url_mod = XOOPS_URL."/modules/".$mydirname;

	$table_options    = $xoopsDB->prefix("wp".$mydirnumber."_options");
	$table_posts      = $xoopsDB->prefix("wp".$mydirnumber."_posts");

// option table
	$options = array();
	$sql0 = "SELECT * FROM ".$table_options;
	$res0 = $xoopsDB->query($sql0);
	while($row0 = $xoopsDB->fetchArray($res0))
	{
		$options[ $row0['option_name'] ] = $row0['option_value'];
	}
	$use_bbcode      = $options['use_bbcode'];
	$time_difference = $options['time_difference'];

	$now = date('Y-m-d H:i:s', (time() + ($time_difference * 3600)) );

// posts table
	$where = '(post_status = \'publish\') AND (post_date <= \''.$now.'\')';

	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$where .= " AND ((post_title LIKE '%$queryarray[0]%' OR post_content LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$where .= " $andor ";
			$where .= "(post_title LIKE '%$queryarray[$i]%' OR post_content LIKE '%$queryarray[$i]%')";
		}
		$where .= ') ';
	}
	if ($userid) {
		$userid = intval($userid);
		$where  .= ' AND (post_author='.$userid.')';
	}

	$sql1 = 'SELECT *, UNIX_TIMESTAMP(post_date) AS unix_post_date, UNIX_TIMESTAMP(post_modified) AS unix_post_modified ';
	$sql1 .= ' FROM '. $table_posts .' WHERE '.$where;
	$sql1 .= ' ORDER BY post_date DESC';
	$res1  = $xoopsDB->query($sql1, $limit, $offset);

	$ret = array();
	$i = 0;
	while( $myrow = $xoopsDB->fetchArray($res1) )
	{
		$id = $myrow['ID'];
		$ret[$i]['link']  = $url_mod."/index.php?p=".$id;
		$ret[$i]['title'] = htmlspecialchars($myrow['post_title'], ENT_QUOTES);
		$ret[$i]['image'] = 'wp-images/search.png';
		$ret[$i]['uid']   = $myrow['post_author'];
		$ret[$i]['page']  = $myrow['post_title'];

// time
		if ($myrow['unix_post_modified'] > $myrow['unix_post_date']) {
			$time = $myrow['unix_post_modified'];
		} else {
			$time = $myrow['unix_post_date'];
		}
		$ret[$i]['time'] = $time;

// context
		if ( $use_bbcode ) {
			$context = $myts->makeTareaData4Show( $myrow['post_content'], 1 );	// allow html
		} else {
			$context = $myrow['post_content'];
		}
		$context = preg_replace("/>/", '> ', $context);
		$context = strip_tags( $context );
		$ret[$i]['context'] = search_make_context( $context, $queryarray );

		$i++;
	}

	return $ret;
}

// === b_search_wordpress_base ===
}

?>