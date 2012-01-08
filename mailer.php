<?php
class Mailer {
    function __construct($to="",$from="",$sub="",$msg="",$files=array()) {
        $this->to = $to;
        $this->from = $from;
        $this->sub = $sub;
        $this->msg = $msg;
        $this->files = $files;
    }
 
    function attachFile($file) {
        if(!empty($file)) {
            $this->files[] = $file;
        }
    }
 
 
    function setMessage($msg) {
        if(!empty($msg)) {
            $this->msg = $msg;
        }
    }
 
 
    function setTo($to) {
        if(!empty($to)) {
            $this->to = $to;
        }
    }
 
 
    function setFrom($from) {
        if(!empty($from)) {
            $this->from = $from;
        }
    }
 
 
    function setSubject($sub) {
        if(!empty($sub)) {
            $this->sub = $sub;
        }
    }
 
 
    function sendMail() {
 
        $files = $this->files;
 
// email fields: to, from, subject, and so on
        $to = $this->to;
        $from = $this->from;
        $subject = $this->sub;
        $message = $this->msg;
 
        $headers = "From: $from ";
 
// boundary
        $semi_rand = md5(time());
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
// headers for attachment
        $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
 
// multipart boundary
        $message = "This is a multi-part message in MIME format.\n\n" . "--{$mime_boundary}\n" . "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
        $message .= "--{$mime_boundary}\n";
 
// preparing attachments
        for($x=0;$x<count($files);$x++) {
            $file = fopen($files[$x],"rb");
            $data = fread($file,filesize($files[$x]));
            fclose($file);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: {\"application/octet-stream\"};\n" . " name=\"$files[$x]\"\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"".basename($files[$x])."\"\n" .
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
            $message .= "--{$mime_boundary}\n";
        }
 
// send
 
        $ok = @mail($to, $subject, $message, $headers);
        return $ok;
    }
}
?>