	MBstrings Hack Note		03May2004
					Tom_G3X	( GEH01523@nifty.com ) Tom Hayakawa
					Malaika System	http://malaika.s31.xrea.com/

* mbstrings Hack

- add function 'array_convert_encoding()'  (include/xoogle.php line 398)

- index.php

	line19
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $Xoogle->soap_defencoding = 'UTF-8';

	line27
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $_GET['query'] = array_convert_encoding(trim($_GET['query']), 'utf-8', _CHARSET );

	line55
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $xoogle_results = array_convert_encoding($xoogle_results);
	
	line65
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $_GET['query'] = array_convert_encoding ($_GET['query']); 

- include/xoogle.php

	line90
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $queryarray = array_convert_encoding($queryarray, 'utf-8', _CHARSET );

	line142
	// for mbstrings by Tom_G3X
	if( XOOPS_USE_MULTIBYTES ) $ret[$i]['title'] = array_convert_encoding($ret[$i]['title']);

	
* BugFix

- include/xoogle.php line17

	// bug fix by Tom_G3X
	//if ( $post['page'] < 1 )
	if ( $post['page'] <= 1 )



* Smarty Memo

** Search Result

Search time :
	<{$xoogle_results.searchTime}>


** Result Item

View Summary :
	<{$result.summary}>

Page cache size :
	<{$result.cachedSize}>

Link pages :
	<a href="<{$xoops_url}>/modules/xoogle/index.php?query=link:<{$result.URL}>">Link pages</a>

Similar pages :
	<{$result.relatedInformationPresent}>
	<a href="<{$xoops_url}>/modules/xoogle/index.php?query=related:<{$result.URL}>">Similar pages</a>

Google Category :
	<{$result.directoryTitle}>
	<{$result.directoryCategory.fullViewableName}>
	<{$result.directoryCategory.specialEncoding}>


** ex: template/xoogle.html

<{foreach item=result from=$xoogle_results.results.resultElements}>
<p class="<{cycle values='odd,even'}>"><b><a href="<{$result.URL}>" target="_blank"><{$result.title}></a></b> <br />
<{$result.snippet}> <br />

<{if $result.summary}>
  <font color=#6f6f6f>Summary:</font><{$result.Summary}><br />
<{/if}>

<{if $result.directoryCategory.fullViewableName}>
  <font color=#6f6f6f>Category : </font>
  <a href="http://directory.google.com/<{$result.directoryCategory.fullViewableName}>/?il=1" target="_blank"><{$result.directoryCategory.fullViewableName}></a><br />
<{/if}>

<font color=#008000><{$result.URL}> - <{$result.cachedSize}> - </font>
<a href="<{$xoops_url}>/modules/xoogle/index.php?query=link:<{$result.URL}>">Link pages</a>

<{if $result.relatedInformationPresent = "1"}>
 - <a href="<{$xoops_url}>/modules/xoogle/index.php?query=related:<{$result.URL}>">Similar pages</a>
<{/if}>

</p>
<{/foreach}>
