<?php

//Initializing Variables
$rawSize = $_POST["filesize"];
$unit = $_POST["unit"];
$trueSize;
$name = $_POST['filename'];
$ext = $_POST['ext'];
$filename = $name . $ext;
$path = $_SERVER['DOCUMENT_ROOT'];
$filepath = $path . "/fd/" . $filename;

//True size
switch ($unit) {
   case "b":
      $trueSize = $rawSize;
      break;
   case "kb":
      $trueSize = $rawSize * 1024;
      break;
   case "mb":
      $trueSize = $rawSize * pow(1024, 2);
      break;
   case "gb":
      $trueSize = $rawSize * pow(1024, 3);
      break;
}


//echo "$filepath Raw: $rawSize True: $trueSize";

createfile($filename, $trueSize);
downloadfile($filename, $filepath);


////////////
//Funtions//
////////////

//Create file function
function createfile($filename, $trueSize)
{
   $fh = fopen($filename, 'w');
   //$size = 1024 * 1024 * 10; // 10mb
   $chunk = 1024;
   while ($trueSize > 0) {
      fputs($fh, str_pad('', min($chunk, $trueSize)));
      $trueSize -= $chunk;
   }
   fclose($fh);
};


//Download file function
function downloadfile($filename, $filepath)
{
   header('Content-Description: File Transfer');
   header("Content-type: application/octet-stream");
   header("Content-Length: " . filesize($filepath));
   header("Content-Disposition: attachment; filename=$filename");
   header("Pragma: no-cache");
   header("Expires: 0");
   readfile($filepath);
   unlink($filename);
};