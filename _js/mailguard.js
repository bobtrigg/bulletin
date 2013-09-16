/*
This script allows email URLs to be coded in a script tag
to thwart spam bots. For any email link, use the following code:

<script>MailGuard('name','domain','subject','string','cc')</script>

Replace 'name' with the user's ID, 'domain' with the email domain,
'subject' with the email subject, 'string' with the string to be
displayed in the browser (defaults to the email URL), and the cc: address.

Only name and domain are required.
*/

function MailGuard(mailbox,domain,subject,string,cc){
	
	var qmark_used = false;
	
	str="<a href='mailto:"+mailbox+"@"+domain;
	
	if(subject) {
		if (!qmark_used) {
			str = str+"?";
			qmark_used = true;	
		} else {
			str = str+"&"	
		}
		str=str+"subject="+subject;
	}
	
	if(cc) {
		if (!qmark_used) {
			str = str+"?";
			qmark_used = true;	
		} else {
			str = str+"&"	
		}
		str=str+"cc="+cc;
	}
	
	if(string) {str=str+"'>"+string+"</a>"}
	else {str=str+"'>"+mailbox+"@"+domain+"</a>"};
	
	document.write(str);
}
