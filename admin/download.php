
<?php
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file");
header("Content-Type: application/zip");
header("Content-Transfer-Encoding: binary");

if (isset($_GET["file"])) {
    $file = basename($_GET['file']);
    $file = '../cv/' . $file;

    if (!file_exists($file)) {
        die('file not found');
    } else {

        readfile($file);
    }
}
?>