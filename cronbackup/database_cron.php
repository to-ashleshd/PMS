<?php
//Database Connections
//include_once('includes/includes.php');

// php /home/nathbiog/public_html/job/database_cron.php
///home/rkhenbga/database_cron.php


$db_host = 'localhost';
$db_user = 'rkhenbga_pms';
$db_pass = '*TwK&g}?yG__';
$db_name = 'rkhenbga_pms';

$db= mysql_connect($db_host, $db_user, $db_pass) or die('Error to connect server.');
mysql_select_db($db_name, $db) or die('Unable to connect database.');


$site_name = 'PMS Varrocgroup';
$toEmail = 'backup@enrich.in';
$toName = 'Enrich Support';
$fromEmail = 'admin@pms.varrocgroup.com';

/** Supporting Functions **/
function sendemail_attachment($sender, $sendername, $subject, $mailcontent, $receiver, $receivername, $file_attach="",$file_name="")
	//function send_comman_mail_attachment($to,$subject,$message,$fromname,$from,$files='')
	{
		
		$message = $mailcontent;
		$headers = "From:".$sendername."<".$sender.">";		
		// boundary
		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
		// headers for attachment
		$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed; \n" . " boundary=\"{$mime_boundary}\"";
		// multipart boundary
		$message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
		
		$message .= "--{$mime_boundary}\n";
		
		// preparing attachments
	
			$file = @fopen($file_attach,"rb");
			$data = @fread($file,filesize($file_attach));
			@fclose($file);
			$data = chunk_split(base64_encode($data));
			$message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$file_name\"\n" .
			"Content-Disposition: attachment;\n" . " filename=\"$file_attach\"\n" .
			"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
			$message .= "--{$mime_boundary}\n";
		

		//$suc = @mail($to, $subject, $message,$headers);
		$suc = mail($receiver, $subject, $message,$headers);
		if($suc==1)
		{ return true; }
		else
		{ return false; }
		
	}		



//calculate all database tables..
$tables = array();
$result = mysql_query('SHOW TABLES');
while($row = mysql_fetch_row($result))
{
  $tables[] = $row[0];
}
  
/*echo "<pre>";
print_r($tables);
echo "</pre>";
echo "hi";*/
$return='';
foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
   // $return.= 'DROP TABLE '.$table.';';
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {  //echo "i m here 33";

        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
}
  
//$file_folder = "uploads/backup/";
$file_folder = "";
$file_name = 'db-backup-'.date("Y-m-d-H-i-s").'.sql';
$handle =fopen($file_folder.$file_name,"w+");
fwrite($handle,$return);
fclose($handle);


/** Zip in not available 
if(file_exists($file_folder.$file_name)) {
	$zip = new ZipArchive(); // Load zip library
	//$zip_name = $file_folder.$file_name.".zip"; // Zip name
	$zip_name = $file_name.".zip"; // Zip name
	if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE) {
				 // Opening zip file to load files
		$error = "* Sorry ZIP creation failed at this time";
	}
	else {
		$zip->addFile($file_folder.$file_name); // Adding files into zip
		$zip->close();
		@unlink($file_folder.$file_name);
		
		$senderename= "Administrator";
		$subject = "Database backup of ".$site_name." (".date('Y-m-d').")";
		$mailcontents = "Hello Admin,<br><br><p>Please find database backup in attachment.</p>";
		//$toEmail = "shivaji.somvanshi@gmail.com";
		//$toName = "Admin";
		
		//$mailsuccess=$FunctionObj->sendemail_attachment(SITEMAIL,$senderename,$subject,$mailcontents, $toEmail,$toName,$zip_name,'Database Backup');
		$mailsuccess= sendemail_attachment($toEmail,$senderename,$subject,$mailcontents, "archanamapari@gmail.com","Archana",$zip_name,'Database Backup');
		if($mailsuccess>0)
		{
			//@unlink($files);
			echo "<span class='success'>Email send Successfully</span>"; 
			//@unlink($zip_name);
		}
		else {
		 echo "<span class='error'>Problem in sending email.</span>";
		}
		
		
	}
	
}

**/

//Send sql file to mail
if(file_exists($file_folder.$file_name)) {
	$zip_name = $file_name ;//.".zip"; // Zip name
	
		
	$senderename= "Administrator";
	$subject = "Database backup of ".$site_name." (".date('Y-m-d').")";
	$mailcontents = "Hello Admin,<br><br><p>Please find database backup in attachment.</p>";
	//$toEmail = "shivaji.somvanshi@gmail.com";
	//$toName = "Admin";
	
	//$mailsuccess=$FunctionObj->sendemail_attachment(SITEMAIL,$senderename,$subject,$mailcontents, $toEmail,$toName,$zip_name,'Database Backup');
	$mailsuccess= sendemail_attachment($fromEmail,$senderename,$subject,$mailcontents, $toEmail, $toName ,$zip_name,'Database Backup');
	if($mailsuccess>0)
	{
		//@unlink($files);
		echo "<span class='success'>Email send Successfully</span>"; 
		//@unlink($zip_name);
	}
	else {
	 echo "<span class='error'>Problem in sending email.</span>";
	}
		
		
}
	


/*else {
	echo "File is not present for zip";
}*/




exit;


?>
