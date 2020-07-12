/* ========================================================
 * $Id: happy_search.js,v 1.1 2007/11/26 03:34:21 ohwada Exp $
 * ========================================================
 */

function happy_search_on_off( id ) 
{
	doc = document.getElementById( id );
	switch ( doc.style.display ) 
	{
		case "none":
		doc.style.display = "block";
		break;

	case "block":
		doc.style.display = "none";
		break;
	}
}
