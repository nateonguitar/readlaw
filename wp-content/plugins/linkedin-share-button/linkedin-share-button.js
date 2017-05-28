
var winLinkedInShare = null;

function popupLinkedInShare( strURL, strType, strHeight, strWidth ) {

	var strOptions = '';

	if ( winLinkedInShare != null && !winLinkedInShare.closed )
		winLinkedInShare.close();
	if ( strType == 'console' )
		strOptions = 'resizable,height=' + strHeight + ',width=' + strWidth;
	else if ( strType == 'fixed' )
		strOptions = 'status,height=' + strHeight + ',width=' + strWidth;
	else if ( strType == 'elastic' )
		strOptions = 'toolbar,menubar,scrollbars,resizable,location,height=' + strHeight + ',width=' + strWidth;

	winLinkedInShare = window.open( strURL, 'winLinkedInShare', strOptions );
	winLinkedInShare.focus();

	return false;

}
