window.onload = function () {

	$("img").each(function() {
		(this).remove();
	});

	$("iframe").each(function() {
		(this).remove();
	});
	
	var link_array = document.getElementsByTagName('a');
	var link_text;
	
	for (var i = 0; i < link_array.length; i++) { 
		link_text = link_array[i].innerHTML + " [" + link_array[i].href + "] ";
		link_array[i].innerHTML = link_text;
	};	

	$("document").ready(function() {
		gen_toc(false);
	});
}

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