<?php
// $Id: myalbum.php,v 1.1 2008/07/09 07:51:54 ohwada Exp $

//=========================================================
// Happy Search Module
// for myAlbum-P 2.88  <http://www.peak.ne.jp/xoops/>
// 2008-07-01 K.OHWADA
//=========================================================

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

$mydirname = basename( dirname( __FILE__ ) ) ;

if( ! preg_match( '/^(\D+)(\d*)$/' , $mydirname , $regs ) ) {
	echo ( "invalid dirname: " . htmlspecialchars( $mydirname ) ) ;
}
$mydirnumber = $regs[2] === '' ? '' : intval( $regs[2] ) ;

// --- eval begin ---
eval( '
function b_search_'.$mydirname.'( $keywords , $andor , $limit , $offset , $userid )
{
	return b_search_myalbum_base( "'.$mydirname.'" , $keywords , $andor , $limit , $offset , $userid ) ;
}
' ) ;
// --- eval end ---

// === function begin ===
if( ! function_exists( 'b_search_myalbum_base' ) ) {

function b_search_myalbum_base( $mydirname , $keywords , $andor , $limit , $offset , $userid )
{
	$SHOW_SUBSTITUTE = false;

	global $xoopsDB ;

	$MOD_PATH = XOOPS_ROOT_PATH .'/modules/'. $mydirname;
	$MOD_URL  = XOOPS_URL       .'/modules/'. $mydirname;

	include $MOD_PATH ."/include/read_configs.php" ;

	// XOOPS Search module
	$showcontext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$select4con = $showcontext ? "t.description" : "'' AS description" ;

//	$sql = "SELECT l.lid,l.cid,l.title,l.submitter,l.date,$select4con FROM $table_photos l LEFT JOIN $table_text t ON t.lid=l.lid LEFT JOIN ".$xoopsDB->prefix("users")." u ON l.submitter=u.uid WHERE status>0" ;
	$sql = "SELECT l.lid,l.ext,l.cid,l.title,l.submitter,l.date,$select4con FROM $table_photos l LEFT JOIN $table_text t ON t.lid=l.lid LEFT JOIN ".$xoopsDB->prefix("users")." u ON l.submitter=u.uid WHERE status>0" ;

	if( $userid > 0 ) {
		$sql .= " AND l.submitter=".$userid." ";
	}

	$whr = "" ;
	if( is_array( $keywords ) && count( $keywords ) > 0 ) {
		$whr = "AND (" ;
		switch( strtolower( $andor ) ) {
			case "and" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',t.description,' ',u.uname) LIKE '%$keyword%' AND " ;
				}
				$whr = substr( $whr , 0 , -5 ) ;
				break ;
			case "or" :
				foreach( $keywords as $keyword ) {
					$whr .= "CONCAT(l.title,' ',t.description,' ',u.uname) LIKE '%$keyword%' OR " ;
				}
				$whr = substr( $whr , 0 , -4 ) ;
				break ;
			default :
				$whr .= "CONCAT(l.title,'  ',t.description,' ',u.uname) LIKE '%{$keywords[0]}%'" ;
				break ;
		}
		$whr .= ")" ;
	}

	$sql = "$sql $whr ORDER BY l.date DESC";
	$result = $xoopsDB->query( $sql , $limit , $offset ) ;
	$ret = array() ;
	$context = '' ;
	include_once XOOPS_ROOT_PATH."/modules/$mydirname/class/myalbum.textsanitizer.php" ;
	$myts =& MyAlbumTextSanitizer::getInstance();
	while( $myrow = $xoopsDB->fetchArray($result) ) {

		// get context for module "search"
		if( function_exists( 'search_make_context' ) && $showcontext ) {
			$full_context = strip_tags( $myts->displayTarea( $myrow['description'] , 1 , 1 , 1 , 1 , 1 ) ) ;
			if( function_exists( 'easiestml' ) ) $full_context = easiestml( $full_context ) ;
			$context = search_make_context( $full_context , $keywords ) ;
		}

// thumbnail image
		$img_url = '';
		$img_width  = '';
		$img_height = '';

		$lid  = $myrow['lid'];
		$ext  = $myrow['ext'];
		$file = $lid.'.'.$ext;

		$photo_path      = $photos_dir.'/'.$file;
		$photo_url       = $photos_url.'/'.$file;
		$thumb_path      = $thumbs_dir.'/'.$file;
		$thumb_url       = $thumbs_url.'/'.$file;
		$substitute_url  = $MOD_URL  .'/icons/'. $ext .'.gif';
		$substitute_path = $MOD_PATH .'/icons/'. $ext .'.gif';

		if ( file_exists( $thumb_path ) ) {
			$img_url = $thumb_url;
			$size  = getimagesize( $thumb_path ) ;
			if ($size) {
				$img_width  = intval( $size[0] );
				$img_height = intval( $size[1] );
			}

// show substitute icon
		} elseif ( $SHOW_SUBSTITUTE && file_exists( $substitute_path ) ) {
			$img_url = $substitute_url;
			$size  = getimagesize( $substitute_path ) ;
			if ($size) {
				$img_width  = intval( $size[0] );
				$img_height = intval( $size[1] );
			}
		}

		$ret[] = array(
			"image" => "images/pict.gif" ,
			"link" => "photo.php?lid=".$myrow["lid"] ,
			"title" => $myrow["title"] ,
			"time" => $myrow["date"] ,
			"uid" => $myrow["submitter"] ,
			"context" => $context ,

// thumbnail image
			"img_url"    => $img_url ,
			"img_width"  => $img_width ,
			"img_height" => $img_height ,
		) ;

	}
	return $ret;
}

}
// === function end ===

?>