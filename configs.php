<?php
# Database Settings
$tmpDir = "/home/<username>/tmp/"; // Temp location the user has access to
$user = "<username>_******"; // MySQL Username for the database
$password = "*******"; // MySQL Password
$dbName = "<username>_******"; // Database name, usually in the pattern: <username>_<dbname>
$dbHost = "localhost"; // Mysql server hostname, usually localhost

# Email Settings
$to = "masnun@ymail.com"; // Send to this email address with attachment
$from = "Cron Bot<masnun@gmail.com>"; // Use a known email address in the from field so Yahoo! doesn't throw the emails to Spam box
$subject = "MySQL Database Backup: " . date('Y_m_d'); // The Subject Line with Date
