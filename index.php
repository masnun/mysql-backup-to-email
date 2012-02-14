<?php
require_once 'configs.php';
require_once 'mailer.php';


$sqlFile = $tmpDir . $dbName . date('Y_m_d') . ".sql"; // The dumped SQL File
$attachment = $tmpDir . $dbName . "_" . date('Y_m_d') . ".tgz"; // TGZed file

$creatBackup = "mysqldump -h '" . $dbHost .  "' -u '" . $user . "' --password='" . $password . "' '" . $dbName . "' > '" . $sqlFile . "'"; // Full command
$createZip = "tar cvzf $attachment $sqlFile"; // Full Command

// Execute 'em
system($creatBackup);
system($createZip);


# Email the archive file
$m = new Mailer();
$m->setTo($to);
$m->setFrom($from);
$m->setSubject($subject);
$m->setMessage("Database Backup: " . date('Y_m_d'));
$m->attachFile($attachment);

if ($m->sendMail())
{
    echo "Sent \n";
}
else
{
    echo "Failed \n";
}

// Remove the junk
unlink($sqlFile);
unlink($attachment);

?>

