<?php include_once('_includes/runtime_parms.inc.php'); ?>
<!DOCTYPE HTML>
<html>
<!-- header.html - include file containing contents for <head> section and page header -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo $page_title; ?></title>

<link href="_css/style.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<?php include('_includes/fancybox.inc.php'); ?>
<script type="text/javascript" src="_js/script.js"></script>
<script type="text/javascript" src="_js/tooltip.js"></script>

<script type="text/javascript" src="_js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: "link,preview,table,spellchecker,searchreplace,paste,code,charmap,anchor,fullscreen",
    tools: "inserttable",
    toolbar1: "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent " ,
	toolbar2: "link,anchor | styleselect,searchreplace,fullscreen,preview"
 });
</script>

<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" type="text/css" href="_css/tooltip_ie.css" />
<![endif]-->

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
