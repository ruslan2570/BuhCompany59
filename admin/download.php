<?php

if (isset($_GET["file"])) {
    $file = basename($_GET['file']);
    $file = '../' . $file;
    
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$file");

    if (!file_exists($file)) {
        die('file not found');
    } else {

        readfile($file);
    }
}
?>