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
