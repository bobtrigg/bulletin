<?php
// Constants used for website bulletin HTML

//  Use WEB_HEADER for full pathname of file containing company header
DEFINE('WEB_HEADER', '../../_includes/Header.htm');

//  Use WEB_FOOTER for full pathname of file containing company footer
DEFINE('WEB_FOOTER', '../../_includes/footer.htm');

//  Use LEFT_SIDEBAR for full pathname of file containing 
//    code which will appear in a sidebar on the left of the page
DEFINE('LEFT_SIDEBAR', '../../_includes/LeftCol.htm');

//  Use RIGHT_SIDEBAR for full pathname of file containing 
//    code which will appear in a sidebar on the right of the page
DEFINE('RIGHT_SIDEBAR', '../../_includes/RightCol.htm');

//  Use CUSTOM_SHARE for full pathname of file containing 
//    code which will appear at the top of the page (below the header)
//  This is designed to site links to your social media sites
DEFINE('CUSTOM_SHARE', '../../_includes/share.htm');

//  Use ORG_NAME for the name of your organization.
//  It will appear in the email header, and in the HTML title.
DEFINE('ORG_NAME', 'MARIN COUNTY BICYCLE COALITION (MCBC)');

//  Use CUSTOM_CSS for full pathname of file containing CSS for this bundle's files
//  Typically this should be for inner-facing files.
DEFINE('CUSTOM_CSS', 'bulletin.css');		  // Use this for 

//  Use GLOBAL_CSS for full pathname of file containing site-wide CSS
//  Typically this should be used for outward-facing pages, i.e. the bulletin itself.
DEFINE('GLOBAL_CSS', '../../_css/global.css');  

//  Use GLOBAL_JS for full pathname of file containing site-wide JavaScript
DEFINE('GLOBAL_JS', '../../_js/global.js');  

//  Use FANCY_BOX for directory in which your fancybox code is stored
//  This package contains the fancybox code; you can delete it if you already
//    have fancybox installed somewhere else. If you do, you'll need to
//    change this constant.
DEFINE('FANCY_BOX', '/fancybox/');  

//  Constants used for email bulletin HTML

//  Use FILE_NAME to indicate the name of the website bulletin file.
//  It changes the target URLs in links to the web file within the email.
//  This variable can use both text and standard date format codes;
//  combining date string formats with plain text requires a delimiter to 
//  indicate a format character, however, so 
//  we adopt the '%' indicator in deference to the fprintf function format.
//  Default is to use bulletin.php, with the date as a $_GET value in the URL,
//  e.g. "bulletin.php?date=19700101".
//  Since emails don't reside in your domain, you will need to specify this
//  in order for your email to successfully target your online web page.
// DEFINE('FILE_NAME', 'bulletin.php?date=%Y%m%d');
DEFINE('FILE_NAME', '%Y%m%d.shtml');

//  Use IMAGE_FOLDER to indicate a default image file.
//  If not assigned, default is the current working directory.
//  Like FILE_NAME, the name is parsed according to standard date format codes.
DEFINE('IMAGE_FOLDER', 'Images/%Y');

//  Use EMAIL_HEADER for full pathname of file containing email HTML header
DEFINE('EMAIL_HEADER', '_includes/email_header.inc.php');

//  Use EMAIL_FOOTER for full pathname of file containing email HTML footer
DEFINE('EMAIL_FOOTER', '_includes/email_footer.inc.php');

//  Use CUSTOM_BAR_BGCOLOR for the bg color on the item title bars
DEFINE('CUSTOM_BAR_BGCOLOR', '#D5EF98');

//  Use CUSTOM_BAR_TEXT_COLOR for text color on the item title bars
DEFINE('CUSTOM_BAR_TEXT_COLOR', '#543019');
?>