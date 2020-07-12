<?php
// $Id: smartsection_213.php,v 1.1 2007/11/25 00:05:05 ohwada Exp $

//================================================================
// Search Module
// plugin for SmartSection 2.13 <www.smartfactory.ca>
// 2007-11-18 souhalt
//================================================================

/**
* Id: search.inc.php,v 1.11 2007/01/22 21:05:28 malanciault Exp
* Module: SmartSection
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function b_search_smartsection_213($queryarray, $andor, $limit, $offset, $userid)
{
	include_once XOOPS_ROOT_PATH.'/modules/smartsection/include/functions.php';

	$ret = array();

	if (!isset($smartsection_item_handler)) {
		$smartsection_item_handler = xoops_getmodulehandler('item', 'smartsection');
	}

	if ($queryarray == '' || count($queryarray) == 0){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}

	$itemsObj =& $smartsection_item_handler->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid);

	$withCategoryPath = smartsection_getConfig('catpath_search');

	foreach ($itemsObj as $result) {
		$item['image'] = "images/item_icon.gif";
		$item['link'] = "item.php?itemid=" . $result['id'] . $hightlight_key;
		if ($withCategoryPath) {
			$item['title'] = $result['categoryPath'] . $result['title'];
		} else {
			$item['title'] = "" . $result['title'];
		}
		$item['time'] = $result['datesub'];
		$item['uid'] = $result['uid'];

	// description begin
		$item_obj = $smartsection_item_handler->get( $result['id'] );
		$context = $item_obj->body();
		$context = preg_replace("/>/", '> ', $context);
		$context = strip_tags( $context );
		$item['context'] = search_make_context($context, $queryarray);
	// description end

		$ret[] = $item;
		unset($item);
	}

	return $ret;
}

?>