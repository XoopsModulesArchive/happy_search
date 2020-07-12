<?php
// $Id: wfdownloads.php,v 1.1 2007/07/04 13:51:29 ohwada Exp $

//=========================================================
// Happy Search
// for WFdownloads 3.10 <http://www.smartfactory.ca/>
// porting from search.inc.php
// 2007-07-01 K.OHWADA
//=========================================================

function b_search_wfdownloads($queryarray, $andor, $limit, $offset, $userid)
{
	global $xoopsUser;

	include_once XOOPS_ROOT_PATH.'/modules/wfdownloads/include/functions.php';

	$myts =& MyTextSanitizer::getInstance();

	$module_handler = xoops_gethandler('module');
	$wfModule = $module_handler->getByDirname("wfdownloads");

	$groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;

	$gperm_handler = xoops_gethandler('groupperm');
	$allowed_cats = $gperm_handler->getItemIds("WFDownCatPerm", $groups, $wfModule->getVar('mid'));

	$criteria = new CriteriaCompo(new Criteria("cid", "(".implode(',', $allowed_cats).")", "IN"));
	if ($userid != 0)
	{
		$criteria->add(new Criteria("submitter", intval($userid)));
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if (is_array($queryarray) && $count = count($queryarray))
	{
		$subcrit = new CriteriaCompo(new Criteria("title", "%".$queryarray[0]."%", 'LIKE'), 'OR');
		$subcrit->add(new Criteria("description", "%".$queryarray[0]."%", 'LIKE'), 'OR');
		$criteria->add($subcrit);
		unset($subcrit);
		for($i = 1;$i < $count;$i++)
		{
			$subcrit = new CriteriaCompo(new Criteria("title", "%".$queryarray[$i]."%", 'LIKE'), 'OR');
			$subcrit->add(new Criteria("description", "%".$queryarray[$i]."%", 'LIKE'), 'OR');
			$criteria->add($subcrit, $andor);
		}
	}
	$criteria->setSort("published");
	$criteria->setOrder("DESC");
	$criteria->setLimit($limit);
	$criteria->setStart($offset);

	$download_handler = xoops_getmodulehandler('download', 'wfdownloads');
	$downloads = $download_handler->getActiveDownloads($criteria);
	$ret = array();
	$i = 0;

	foreach (array_keys($downloads) as $i)
	{
		$ret[$i]['image'] = "images/size2.gif";
		$ret[$i]['link']  = "singlefile.php?cid=" . $downloads[$i]->getVar('cid') . "&amp;lid=" . $downloads[$i]->getVar('lid') . "";
		$ret[$i]['title'] = $downloads[$i]->getVar('title');
		$ret[$i]['time']  = $downloads[$i]->getVar('published');
		$ret[$i]['uid']   = $downloads[$i]->getVar('submitter');

// context
		$context = $downloads[$i]->getVar('description');
		$context = preg_replace("/>/", '> ', $context);
		$context = strip_tags( $context );
		$ret[$i]['context'] = search_make_context($context, $queryarray);

		$i++;
	}

	return $ret;
}

?>