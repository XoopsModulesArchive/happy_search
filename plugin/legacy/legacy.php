<?php
// $Id: legacy.php,v 1.1 2007/05/20 17:17:43 ohwada Exp $

// 2007-05-20 K.OHWADA
// XC 2.‚P

// 2007-03-01 K.OHWADA
// change link with dirname

//=========================================================
// Happy Search
// This file is same as system.php
//=========================================================

// $Id: legacy.php,v 1.0 2005/02/02 06:05:00 suin 
// FILE		::	system.php
// AUTHOR	::	suin <sim@suin.jp>
// WEB		::	AmethystBlue <http://www.suin.jp>

function b_search_legacy($queryarray, $andor, $limit, $offset, $userid)
{
	global $xoopsDB;
	$showcontext = isset( $_GET['showcontext'] ) ? $_GET['showcontext'] : 0 ;

	if( $showcontext == 1){
		$sql = "SELECT c.*, m.* FROM ".$xoopsDB->prefix("xoopscomments")." c,".$xoopsDB->prefix("modules")." m  WHERE com_status=2 AND c.com_modid=m.mid ";
	}else{
		$sql = "SELECT c.*, m.* FROM ".$xoopsDB->prefix("xoopscomments")." c,".$xoopsDB->prefix("modules")." m  WHERE com_status=2 AND c.com_modid=m.mid ";
	}

	if ( $userid != 0 ) {
		$sql .= " AND c.com_uid=".$userid." ";
	}

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((com_title LIKE '%$queryarray[0]%' OR com_text LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(com_title LIKE '%$queryarray[$i]%' OR com_text LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}

	$sql .= "ORDER BY com_modified DESC";

	$result = $xoopsDB->query($sql, 2*$limit, $offset);

	$ret = array();
	$i = 0;

	$myts =& MyTextSanitizer::getInstance();

	$module_handler =& xoops_gethandler('module');
	$modules =& $module_handler->getObjects(new Criteria('hascomments', 1), true);

	$moduleperm_handler =& xoops_gethandler('groupperm');

	$comment_config = array();

// registerd user
	global $xoopsUser;
	if ( is_object($xoopsUser) )
	{
		$groups = $xoopsUser->getGroups();
	}
// guest
	else
	{
		$groups = array( XOOPS_GROUP_ANONYMOUS );
	}

 	while($myrow = $xoopsDB->fetchArray($result)){

		$mid      = $myrow['mid'];
		$dirname  = $myrow['dirname'];
		$itemid   = $myrow['com_itemid'];
		$rootid   = $myrow['com_rootid'];
		$exparams = $myrow['com_exparams'];
		$rootid   = $myrow['com_rootid'];
		$com_id   = $myrow['com_id'];

// check user permission
		if ( !$moduleperm_handler->checkRight('module_read', $mid, $groups) )
		{	continue;	}

		if (!isset($comment_config[$mid])) 
		{
			$comment_config[$mid] = $modules[$mid]->getInfo('comments');
		}

		$pageName = $comment_config[$mid]['pageName'];
		$itemName = $comment_config[$mid]['itemName'];

//		$ret[$i]['link'] = "index.php?com_id=".$myrow['com_id'];
		$ret[$i]['link'] = '../'.$dirname.'/'.$pageName.'?'.$itemName.'='.$itemid.'&amp;com_id='.$com_id.'&amp;com_rootid='.$rootid.'&amp;'.$exparams.'#comment'.$com_id;

		$ret[$i]['title'] = "[".$myrow['name']."] ".$myrow['com_title'];
		$ret[$i]['time'] = $myrow['com_modified'];
		$ret[$i]['uid'] = $myrow['com_uid'];

		if( !empty( $myrow['com_text'] ) ){
			$context = $myrow['com_text'];
			$context = strip_tags($myts->displayTarea(strip_tags($context)));
			$ret[$i]['context'] = search_make_context($context,$queryarray);
		}

		$i++;
		if (($limit > 0) && ($i >= $limit))  break;

	}

	return $ret;
}
?>