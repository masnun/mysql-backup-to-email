<?php
require_once('mailer.php');


# Database Settings
$tmpDir = "/home/<username>/tmp/"; // The /temp directory
$user = "<username>_******"; // MySQL Username for the database
$password = "*******";  // MySQL Password
$dbName = "<username>_******"; // Database name, usually in the pattern: <username>_<dbname>


# Email Settings
$to = "masnun@ymail.com"; // Send to this email address with attachment
$from = "Cron Bot<masnun@gmail.com>"; // Use a known email address in the from field so Yahoo! doesn't throw the emails to Spam box
$subject = "MySQL Database Backup: ".date('Y_m_d'); // The Subject Line with Date

$sqlFile = $tmpDir.$dbName.date('Y_m_d').".sql"; // The dumped SQL File
$attachment = $tmpDir.$dbName."_".date('Y_m_d').".tgz"; // TGZed file

$creatBackup = "mysqldump -u '".$user."' --password='".$password."' '".$dbName."' > '".$sqlFile."'"; // Full command
$createZip = "tar cvzf $attachment $sqlFile"; // Full Command

// Execute 'em
system($creatBackup);
system($createZip);


# Email the archive file
$m = new Mailer();
$m->setTo($to);
$m->setFrom($from);
$m->setSubject($subject);
$m->setMessage("Database Backup: ".date('Y_m_d'));
$m->attachFile($attachment);
 
if($m->sendMail()) { echo "Sent \n"; } else { echo "Failed \n"; }

// Remove the junk
unlink($sqlFile);
unlink($attachment);

?>

