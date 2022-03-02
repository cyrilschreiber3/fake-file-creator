<?php
    $size = $_GET["size"];
    $name = $_GET['name'];
    $ext = $_GET['ext'];
    $filename = $name . $ext;

    $path = $_SERVER['DOCUMENT_ROOT'];
    $filepath = $path . "/fd/" . $filename;
    $path_parts = pathinfo($filepath);
    //echo $filepath;

    $fh = fopen($filename, 'w');
    //$size = 1024 * 1024 * 10; // 10mb
    $chunk = 1024;
    while ($size > 0) {
        fputs($fh, str_pad('', min($chunk, $size)));
        $size -= $chunk;
    }
    fclose($fh);


    header('Content-Description: File Transfer');
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$filename");
    header("Pragma: no-cache");
    header("Expires: 0");
    //print "$filename";
    readfile($filepath);
?>