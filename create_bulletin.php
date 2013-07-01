<?php
require_once('_includes/db_functions.inc.php');
require_once('_includes/functions.inc.php');
require_once('classes/table.class.php');

// $where_clause = " WHERE bulletin_date = '" . number_format_date($wb_date) . "' ";
$where_clause = " WHERE bulletin_date = '2013-07-03' ";

$row_resource = Table::get_list($dbc, 'items', 0, 25, NULL, NULL, $where_clause);
?>

<html>
<head>

<title>MCBC Weekly Bulletin, <?php echo $_GET['date']?></title>

<style type="text/css">
<!--
body,html,img { margin: 0; padding: 0; }
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style>

</head>

<body style="margin:0;border:0;width:100%;background-color:white">

  <table  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  width="700" border="3" align="center" cellpadding="0" cellspacing="0" bordercolor="#543019">
    <tr  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
      <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
        <table style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  width="700"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#543019" bgcolor="#FFFFFF">
          <tr style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  width="145" height="100" rowspan="2" bordercolor="#FFFFFF" bgcolor="#543019">
              <p  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" align="center">
                <a href="http://www.marinbike.org/" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Images/MCBC_logo_WB.gif" alt="Marin County Bicycle Coalition" width="150" border="0" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"></a>
              </p>
            </td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  height="103" width="555" colspan="7" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"><img src="http://www.marinbike.org/Images/topbar4wb.gif" alt="MCBC bulletin banner" width="512" height="59"  style="margin-left:15px;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"></p>
            </td>
          </tr>
          <tr style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" width="57"valign="bottom" bgcolor="#543019">&nbsp;</td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" valign="bottom" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                <a href="http://www.marinbike.org/Index.shtml" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Nav/HomeBrnSq.gif" alt="MCBC Home" style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  width="96" height="25" border="0"></a>
              </p></td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" valign="bottom" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                <a href="http://www.marinbike.org/Membership/ChooseLevel.shtml" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Nav/MembershipBrnSq.gif" alt="Membership"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" width="96" height="25" border="0"></a>
              </p>
            </td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" valign="bottom" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                <a href="http://www.marinbike.org/Campaigns/Index.shtml" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Nav/CampaignsBrnSq.gif" alt="Campaigns"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" width="96" height="25" border="0"></a>
              </p>
            </td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" valign="bottom" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                <a href="http://www.marinbike.org/Volunteer/Index.shtml" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Nav/VolBrnSq.gif" alt="Volunteer"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" width="96" height="25" border="0"></a>
              </p>
            </td>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" valign="bottom" bgcolor="#543019">
              <p style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                <a href="http://www.marinbike.org/Resources/Index.shtml" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Nav/ResourcesBrnSq.gif" alt="Resources"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" width="96" height="25" border="0"></a>
              </p>
            </td>
          </tr>
          <tr>
            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;"  colspan="7">
            
                  <table width="100%"  border="0">
                    <tr>
                      <td>
                        <table width="100%" border="0" cellpadding="10">
                          <tr style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                            <td style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                              <p style="margin-top:10px;margin-bottom:10px;padding-top:0;padding-bottom:0;">
                                <font size="3"><b>MCBC Weekly Bulletin</b></font><br>
                            <font size="2"> <?php echo $_GET['date']?></font>                            </p></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
					
					
					
<!-- Start logic here -->

<?php
//  Read each row from events table and display data, with edit and delete links
while ($item = mysqli_fetch_array($row_resource)) {
?>					
                    <tr>
                      <td style="background-color:#D5EF98;">
                        <p style="margin-top:5px;margin-bottom:5px;margin-left:5px;font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:bold;color:#543019;"><?php echo $item['title']; ?>
						</p>
                      </td>
                    </tr>
                    <tr style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                      <td style="font-size:12px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;">
                        <table width="100%"  border="0">
                          <tr>
                            <td width="110" valign="top">
                              <p align="center"  style="margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;" ><a href="http://www.marinbike.org/News/Bulletin/20130612.shtml#IMBA" target="_blank"><img src="http://www.marinbike.org/News/Bulletin/Images/2013/MoSuperD100.jpg"  style="margin-top:5px;margin-bottom:5px;padding-top:0;padding-bottom:0;" alt="Maureen Gaffney" width="100" height="80" border="0"></a><a href="http://www.marinbike.org/News/Bulletin/20130612.shtml#Party" target="_blank"></a>
                                <a href="http://www.marinbike.org/News/Bulletin/20130612.shtml#BTF" target="_blank"></a>
                              </p>
                            </td>
                            <td valign="top">
                                <p style="font-size:12px;font-family:Arial,Helvetica,sans-serif;margin-top:10px;margin-left:10px;margin-bottom:0;padding-top:0;padding-bottom:0;">Award will be presented at Ales and Trails on June 29</p>
                                <p style="font-size:12px;font-family:Arial,Helvetica,sans-serif;margin-top:10px;margin-left:10px;margin-bottom:0;padding-top:0;padding-bottom:0;">
                                  <a href="http://www.marinbike.org/News/Bulletin/20130612.shtml#IMBA" target="_blank">
                                    <b>Read more &gt;&gt;</b>
                                  </a>
                                </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
<?php
}
?>
<!-- Stop logic here -->

 <tr>
                        <td>
                            <hr style="margin-top:10px;margin-bottom:0;padding-top:0;padding-bottom:0;" >
                            </td>
                    </tr>
                    <tr>
                      <td>
                        <p style="font-size:11px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:10px;margin-right:10px;margin-bottom:10px;margin-left:10px;padding-top:0;padding-bottom:0;">
                          The Marin County Bicycle Coalition is a 501(c)(3) non-profit organization. You donations are tax-deductible to the fullest extent of the law.
                        </p>
                        <p style="font-size:11px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:10px;margin-right:10px;margin-bottom:10px;margin-left:10px;padding-top:0;padding-bottom:0;"> 
                          We are a membership-supported group. If you are not already a paying member, <a href="http://www.marinbike.org/Membership/ChooseLevel.shtml" target="_blank">please join today</a>. 
                        </p>
                        <p style="font-size:11px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:10px;margin-right:10px;margin-bottom:10px;margin-left:10px;padding-top:0;padding-bottom:0;"> 
                          To contact the MCBC Staff <a href="http://www.marinbike.org/Contacts/Index.shtml" target="_blank">click here</a>. 
                        </p>
                        <p style="font-size:11px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:10px;margin-right:10px;margin-bottom:10px;margin-left:10px;padding-top:0;padding-bottom:0;"> 
                          TO UNSUBSCRIBE from the MCBC Bulletin, reply to this email and type &quot;unsubscribe&quot; in the subject. 
                        </p>
                        <p style="font-size:11px;font-family:Verdana,Arial,Helvetica,sans-serif;margin-top:10px;margin-right:10px;margin-bottom:10px;margin-left:10px;padding-top:0;padding-bottom:0;">
                          If you are also subscribing to Topica, you may get this bulletin twice. To unsubscribe from the Topica list, follow the EASY UNSUBSCRIBE link in the footer of your message from Topica, or send an email to: <a href="mailto:mcbc-unsubscribe@topica.com" target="_blank">mcbc-unsubscribe@topica.com</a>. NOTE: if you unsubscribe from Topica you will not receive any postings to the MCBC listserve, but you will still receive our bulletin if you remain on our office list. 
                        </p>
                      </td>
                    </tr>
                  </table>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>