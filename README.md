bulletin
========

This package provides scripts and utilities which allow you to enter data and generate email bulletins. Bulletins can be generated in web format, email format, or plain text (which includes all hyperlink targets in brackets). Data entry includes the usual CRUD functions (Create, Read, Update, Delete) for item entries, which are stored in a MySQL database.

SET UP

There are three steps for setting up this package. First, you need to set up the items table in your database. An sql file (_sql/cr8_bulletin.sql) is provided to automate the process; you will have to use MySQL console or a program like PHPmyAdmin to run it.

Next, you'll need to create a file to allow the scripts to access your database. Edit the provided file _includes/db_info_sample.inc.php and put in the correct values for host, user, password, and database name for your installation. When the file is ready, save it as _includes/db_info.inc.php.

Finally, you may optionally edit the file _includes/runtime_parms.inc.php to tailor the output to your installation. There are a number of constants you may set up to individualize the output in all three formats, including file locations for your own stylesheets.

FEATURES

Item data includes the following fields:

-- Bulletin date
-- Position, a simple sequence number to order the items
-- Heading and sub-heading
-- Content, the main body of the item
-- Excerpt, a quick eye-catcher included in the email format
-- Three different image file URLs (inline for the web page, large for fancybox display, and thumbnail for the email format)
   NOTE: the large format image may be a URL for another web page or a PDF
-- Alt attribute for ADA and viewers not downloading images
-- Bookmark, a convenience to help you refer to the content from other sources.

The landing page, list_items.php, displays a list of all items for a specific date; you can specify the date in the address URL or enter it on the page to change it. Each item can be edited, duplicated, or deleted. A hyperlink allows you to create a new item for that date. From this page, you can generate a bulletin in any of three formats.

You can copy the source code of the web format, or refer to it directly using the bulletin.php script. Direct reference requires a date in the address URL, e.g. 'bulletin.php?date=20130925'. The email format will display in your browser; you should view and copy the source (all references in the email HTML are absolute). The text format should be copied directly out of the browser window; you shouldn't use the page source.

You can use the Dupe link to create an exact copy of any item; the new copy will open in the edit script in your browser. You should change some piece of the new item immediately to differentiate it from the original.

The edit program has several features to make it more user-friendly. For the three images, a link is provided to upload an image, which will open an upload script in a new tab or window. NOTE: the upload will go to your default image folder. Recommended sizes are 300 pixels for inline images, 100 pixels for thumbnails, and no more than 1200 pixels for large images. You may also specify a URL for the 'large image' which may be another web page or a PDF. The program provides a link for viewing each of the images in a fancybox when the input field contains a jpg, gif, or png.

Several input fields are equipped with tool tips to provide more information.

Included in the edit page are Next and Previous buttons when appropriate. These buttons do save the changes that have been entered. 

An approved checkbox allows an editor to mark items they've approved; the status also appears on the list page.

SUPPORT

This package is freeware and has no contractual support. If you have questions, need assistance, or wish to recommend enhancements, please contact me at bobtrigg94930@gmail.com. While support is not guaranteed, inquiries and suggestions are welcomed.

Thank you for using this package!

Bob Trigg
