/* ========================================================
 * $Id: whatsnew.js,v 1.1 2007/11/26 03:22:14 ohwada Exp $
 * ========================================================
 */

function whatsnew_on_off( id ) 
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
