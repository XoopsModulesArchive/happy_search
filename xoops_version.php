<?php 
// $Id: xoops_version.php,v 1.4 2007/11/26 03:33:02 ohwada Exp $ 

// 2007-11-24 K.OHWADA
// onInstall, onUpdate

// 2007-07-01 K.OHWADA
// move xoopsModuleConfig to config_define
// module depulication

// 2007-05-20 K.OHWADA
// BUG: wrong table name

//=========================================================
// Happy Search
// 2006-11-11 K.OHWADA
//=========================================================

$HAPPY_SEARCH_DIRNAME   = basename( dirname( __FILE__ ) );
$HAPPY_SEARCH_ROOT_PATH = XOOPS_ROOT_PATH.'/modules/'.$HAPPY_SEARCH_DIRNAME;
$HAPPY_SEARCH_URL       = XOOPS_URL.'/modules/'.$HAPPY_SEARCH_DIRNAME;

if( ! preg_match( '/^(\D+)(\d*)$/' , $HAPPY_SEARCH_DIRNAME , $regs ) )
{	echo ( "invalid dirname: " . htmlspecialchars( $HAPPY_SEARCH_DIRNAME ) ) ;	}
$HAPPY_SEARCH_NUMBER = $regs[2] === '' ? '' : intval( $regs[2] ) ;

include_once $HAPPY_SEARCH_ROOT_PATH.'/include/happy_search_version.php';

if ( $regs[1] == 'happy_search' )
{
	$name_ext = ' '.$HAPPY_SEARCH_NUMBER;
}
else
{
	$name_ext = ':'.$HAPPY_SEARCH_DIRNAME;
}

$modversion['version']     = HAPPY_SEARCH_VERSION; 
$modversion['name']        = _MI_HAPPY_SEARCH_NAME . $name_ext; 
$modversion['description'] = _MI_HAPPY_SEARCH_DESC; 
$modversion['credits']  = ''; 
$modversion['author']   = 'Kenichi OHWADA<br />( http://linux2.ohwada.net/ )'; 
$modversion['help']     = ''; 
$modversion['license']  = 'see GPL and api.google.com'; 
$modversion['official'] = 0; 
$modversion['image']    = 'images/'.$HAPPY_SEARCH_DIRNAME.'_logo.png'; 
$modversion['dirname']  = $HAPPY_SEARCH_DIRNAME; 

// Admin 
$modversion['hasAdmin']   = 1; 
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu 
$modversion['hasMain'] = 1; 

// Search
$modversion['hasSearch'] = 0;

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
$modversion['sqlfile']['mysql'] = 'sql/'. $HAPPY_SEARCH_DIRNAME .'.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = $HAPPY_SEARCH_DIRNAME . '_config';
$modversion['tables'][1] = $HAPPY_SEARCH_DIRNAME . '_module';

// BUG: wrong table name
$modversion['tables'][2] = $HAPPY_SEARCH_DIRNAME . '_xoogle';

// Templates 
$modversion['templates'][1]['file'] = $HAPPY_SEARCH_DIRNAME . '_index.html'; 
$modversion['templates'][1]['description'] = _MI_HAPPY_SEARCH_TEMPLATE_INDEX; 
$modversion['templates'][2]['file'] = $HAPPY_SEARCH_DIRNAME . '_result_all.html';
$modversion['templates'][2]['description'] = _MI_HAPPY_SEARCH_TEMPLATE_ALL;

// Blocks
$modversion['blocks'][1]['file']        = 'block_search.php';
$modversion['blocks'][1]['name']        = _MI_HAPPY_SEARCH_BLOCK_FORM . $name_ext;
$modversion['blocks'][1]['description'] = _MI_HAPPY_SEARCH_BLOCK_FORM_DESC;
$modversion['blocks'][1]['show_func']   = 'b_happy_search_form';
$modversion['blocks'][1]['template']    = $HAPPY_SEARCH_DIRNAME . '_block_form.html';
$modversion['blocks'][1]['options']     = $HAPPY_SEARCH_DIRNAME;

$modversion['blocks'][2]['file']        = 'block_search.php';
$modversion['blocks'][2]['name']        = _MI_HAPPY_SEARCH_BLOCK_REDIRECT . $name_ext;
$modversion['blocks'][2]['description'] = _MI_HAPPY_SEARCH_BLOCK_REDIRECT_DESC;
$modversion['blocks'][2]['show_func']   = 'b_happy_search_redirect';
$modversion['blocks'][2]['template']    = '';
$modversion['blocks'][2]['options']     = $HAPPY_SEARCH_DIRNAME;

$modversion['blocks'][3]['file']        = 'block_search.php';
$modversion['blocks'][3]['name']        = _MI_HAPPY_SEARCH_BLOCK_RESULT . $name_ext;
$modversion['blocks'][3]['description'] = _MI_HAPPY_SEARCH_BLOCK_RESULT_DESC;
$modversion['blocks'][3]['show_func']   = 'b_happy_search_result';
$modversion['blocks'][3]['template']    = $HAPPY_SEARCH_DIRNAME . '_block_result.html';
$modversion['blocks'][3]['options']     = $HAPPY_SEARCH_DIRNAME;

// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'oninstall.php';
$modversion['onUpdate']  = 'oninstall.php';

?>