<?php
// $Id: newbb_308.php,v 1.1 2007/07/04 11:44:21 ohwada Exp $

// 2007-07-01 K.OHWADA
// small change for v3.08
// Undefined index: allow_moderator_html

// 2006-11-11 K.OHWADA
// porting from newbb 2.02 's search.inc.php

//=========================================================
// Search Module Plugin
// for NewBB 3.08 <http://dev.xoops.org/modules/xfmod/project/?newbb>
// 2006-11-11 K.OHWADA
//=========================================================

include_once XOOPS_ROOT_PATH.'/modules/newbb/include/functions.php';

function b_search_newbb_308($queryarray, $andor, $limit, $offset, $userid, $forums = 0, $sortby = 0, $searchin = "both", $subquery = "")
{
	global $xoopsDB, $xoopsConfig, $myts, $xoopsUser;
	static $allowedForums, $newbbConfig;

	$myts =& MyTextSanitizer::getInstance();

	$showcontext = isset( $_GET['showcontext'] ) ? $_GET['showcontext'] : 0 ;

	$uid = (is_object($xoopsUser)&&$xoopsUser->isactive())?$xoopsUser->getVar('uid'):0;

	if(!isset($allowedForums[$uid])){
		$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		if (is_array($forums) && count($forums) > 0) {
			$forums = array_map('intval', $forums);
			foreach($forums as $forumid){
				$_forum = $forum_handler->get($forumid);
				if($forum_handler->getPermission($_forum)) {
					$allowedForums[$uid][$forumid] = $_forum;
				}
				unset($_forum);
			}
		}
		elseif (is_numeric($forums) && $forums > 0) {
			$forumid = $forums;
			$_forum = $forum_handler->get($forumid);
			if($forum_handler->getPermission($_forum)) {
				$allowedForums[$uid][$forumid] = $_forum;
			}
			unset($_forum);
		}
		else {
			$forums = $forum_handler->getForums();
			foreach($forums as $forumid => $_forum){
				if($forum_handler->getPermission($_forum)) {
					$allowedForums[$uid][$forumid] = $_forum;
				}
				unset($_forum);
			}
			unset($forums);
		}
	}
	$forum = implode(',',array_keys($allowedForums[$uid]));

	$sql = 'SELECT p.uid,f.forum_id, p.topic_id, p.poster_name, p.post_time,';

	$sql .= ' p.dohtml, p.dosmiley, p.doxcode, p.dobr, p.doimage, pt.post_text,';

    $sql .= ' f.forum_name, p.post_id, p.subject
              FROM '.$xoopsDB->prefix('bb_posts').' p,
            '.$xoopsDB->prefix('bb_posts_text').' pt,
    		'.$xoopsDB->prefix('bb_forums').' f';
    $sql .= ' WHERE p.post_id = pt.post_id';
    $sql .= ' AND p.approved = 1';
    $sql .= ' AND p.forum_id = f.forum_id';
//                AND p.uid = u.uid'; // In case exists a userid with which the associated user is removed, this line will block search results.  Can do nothing unless xoops changes its way dealing with user removal
    if (!empty($forum)) {
        $sql .= ' AND f.forum_id IN ('.$forum.')';
    }

    if (is_array($userid) && count($userid) > 0) {
		$userid = array_map('intval', $userid);
        $sql .= " AND p.uid IN (".implode(',', $userid).") ";
    }
	elseif ( is_numeric($userid) && $userid != 0 ) {
		$sql .= " AND p.uid=".$userid." ";
	}

	$count = count($queryarray);
	if ( is_array($queryarray) && $count > 0) {
	    switch ($searchin) {
	       case 'title':
	           $sql .= " AND ((p.subject LIKE '%$queryarray[0]%')";
	           for($i=1;$i<$count;$i++){
	               $sql .= " $andor ";
	               $sql .= "(p.subject LIKE '%$queryarray[$i]%')";
	           }
	           $sql .= ") ";
	           break;

	       case 'text':
	           $sql .= " AND ((pt.post_text LIKE '%$queryarray[0]%')";
	           for($i=1;$i<$count;$i++){
	               $sql .= " $andor ";
	               $sql .= "(pt.post_text LIKE '%$queryarray[$i]%')";
	           }
	           $sql .= ") ";
	           break;
	        case 'both' :
	        default:
	           $sql .= " AND ((p.subject LIKE '%$queryarray[0]%' OR pt.post_text LIKE '%$queryarray[0]%')";
	           for($i=1;$i<$count;$i++){
	               $sql .= " $andor ";
	               $sql .= "(p.subject LIKE '%$queryarray[$i]%' OR pt.post_text LIKE '%$queryarray[$i]%')";
	           }
	           $sql .= ") ";
	           break;
		}
	}

	if (!$sortby) {
	    $sortby = "p.post_time DESC";
	}
	$sql .= $subquery." ORDER BY ".$sortby;
	$result = $xoopsDB->query($sql,$limit,$offset);
	$ret = array();
	$users = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
        $ret[$i]['link'] = "viewtopic.php?topic_id=".$myrow['topic_id']."&amp;forum=".$myrow['forum_id']."&amp;post_id=".$myrow['post_id']."#forumpost".$myrow['post_id'];
		$ret[$i]['title'] = $myrow['subject'];
		$ret[$i]['time'] = $myrow['post_time'];
		$ret[$i]['uid'] = $myrow['uid'];
		$ret[$i]['forum_name'] = $myts->htmlSpecialChars($myrow['forum_name']);
		$ret[$i]['forum_link'] = "viewforum.php?forum=".$myrow['forum_id'];
		$users[$myrow['uid']] = 1;
		$ret[$i]['poster_name'] = $myrow['poster_name'];

// context
		if ($showcontext)
		{
			$html   = 0;
			$smiley = 0;
			$xcode  = 0;
			$br     = 0;
			$image  = 0;

			if ( $myrow['dohtml'] )   $html   = 1;
			if ( $myrow['dosmiley'] ) $smiley = 1;
			if ( $myrow['doxcode'] )  $xcode  = 1;
			if ( $myrow['dobr'] )     $br     = 1;
			if ( $myrow['doimage'] )  $image  = 1;

			$context = $myts->displayTarea($myrow['post_text'], $html, $smiley, $xcode, $image, $br);
			$context = preg_replace("/>/", '> ', $context);
	 		$context = strip_tags($context);
			$context = search_make_context($context, $queryarray);
			$ret[$i]['context'] = $context;
		}

		$i++;
	}

	if(count($users)>0){
		$member_handler =& xoops_gethandler('member');
		$userid_array = array_keys($users);
		$user_criteria = "(".implode(",",$userid_array).")";
		$users = $member_handler->getUsers( new Criteria('uid', $user_criteria, 'IN'), true);
	}else{
		$users = null;
	}

	$module_handler = &xoops_gethandler('module');
	$newbb = &$module_handler->getByDirname('newbb');

	if(!isset($newbbConfig)){
		$config_handler =& xoops_gethandler('config');
		$newbbConfig =& $config_handler->getConfigsByCat(0, $newbb->getVar('mid'));
	}

	$count = count($ret);
	for($i =0; $i < $count; $i ++ ){
		if($ret[$i]['uid'] >0){
			if ( isset($users[$ret[$i]['uid']]) && (is_object($users[$ret[$i]['uid']])) && ($users[$ret[$i]['uid']]->isActive()) ){
				$poster = ($newbbConfig['show_realname']&&$users[$ret[$i]['uid']]->getVar('name'))?$users[$ret[$i]['uid']]->getVar('name'):$users[$ret[$i]['uid']]->getVar('uname');
				$poster = $myts->htmlSpecialChars($poster);
				$ret[$i]['poster'] = '<a href="'.XOOPS_URL.'/userinfo.php?uid='.$ret[$i]['uid'].'">'.$poster.'</a>';
				$title = $myts->htmlSpecialChars($ret[$i]['title']);
			}else{
				$ret[$i]['poster'] = $xoopsConfig['anonymous'];
				$ret[$i]['uid'] = 0; // Have to force this to fit xoops search.php
			}
		}else{
            $ret[$i]['poster'] = (empty($ret[$i]['poster_name']))?$xoopsConfig['anonymous']:$myts->htmlSpecialChars($ret[$i]['poster_name']);
			$ret[$i]['uid'] = 0;
		}
	}
	unset($users);

	return $ret;
}
?>