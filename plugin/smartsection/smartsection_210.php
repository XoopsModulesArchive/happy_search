<?php
// $Id: smartsection_210.php,v 1.1 2007/11/25 00:05:04 ohwada Exp $

//================================================================
// Search Module
// plugin for SmartSection 2.10 <www.smartfactory.ca>
// 2006-07-23 K.OHWADA <http://linux.ohwada.jp/>
//================================================================

/**
* Id: search.inc.php,v 1.9 2005/09/06 18:51:55 malanciault Exp
* Module: SmartSection
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) { 
 	die("XOOPS root path not defined");
}

function b_search_smartsection_210($queryarray, $andor, $limit, $offset, $userid)
{
	include_once XOOPS_ROOT_PATH.'/modules/smartsection/include/functions.php';
	
	$ret = array();
    
	if (!isset($smartsection_item_handler)) {
		$smartsection_item_handler = xoops_getmodulehandler('item', 'smartsection');
	}
	
	if ($queryarray == ''){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}		
	
	$itemsObj =& $smartsection_item_handler->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid);

	foreach ($itemsObj as $result) {
		$item['image'] = "images/item_icon.gif";
		$item['link'] = "item.php?itemid=" . $result['id'] . $hightlight_key;
		$item['title'] = "" . $result['title'];
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