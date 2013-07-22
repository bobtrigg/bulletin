<!DOCTYPE HTML>
<html>
<!-- header.html - include file containing contents for <head> section and page header -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $page_title; ?></title>
<link href="_css/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="_js/TinyMCE/jscripts/tiny_mce/tiny_mce.js" ></script >
<script type="text/javascript" src="_js/tinyMCEinit.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
<!-- <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
        tinymce.init({selector:'textarea'});
</script> -->
</head>

<body>
<div id="wrapper">
	<div id="header">
		<h1><?php echo $header_title; ?></h1>
		<h2><?php echo $header_subtitle; ?></h2>
	</div>
	
	<div id="page_content">
	
<?php   //  Show system messages; useful for info or for debugging
	if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
		echo "<p>" . $_SESSION['message'] . "</p>";
		unset ($_SESSION['message']);
	// } else {
		// echo "<p>No session messages</p>";
	}
?>
<!-- End of header.html -->
