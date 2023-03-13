<?php

$config = include 'admin/db_config.php';
header("Content-Type: text/html; charset=UTF-8");

if (isset($_POST["name"])) {
    $name = $_POST["name"];
}

if (isset($_POST["phone"])) {
    $phone = $_POST["phone"];
}

if (isset($_POST["email"])) {
    $email = $_POST["email"];
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/admin/mail.php");

$db_host = $config["host"];
$db_user = $config["user"];
$db_password = $config["password"];
$db_name = $config["db"];

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}

if (isset($name)) {
    if ($email != null || $email != "") {
        $sql = "INSERT INTO `task` (`id`, `name`, `phone`, `email`) VALUES (NULL, '$name', '$phone', '$email'); ";
    } else {
        $sql = "INSERT INTO `task` (`id`, `name`, `phone`, `email`) VALUES (NULL, '$name', '$phone', NULL); ";
    }

    if (!mysqli_query($link, $sql)) {
        $error = mysqli_error($link);
        echo "</br>$error";
    }

    $body = "Имя: $name \r\nНомер телефона: $phone\r\nАдрес электронной почты: $email";
    $query = "SELECT `email`, `login` AS 'name' FROM `user` WHERE `email` IS NOT NULL";
    $recipients = mysqli_query($link, $query);

    if (mysqli_num_rows($recipients) > 0) {

        sendMail($recipients, "Новая заявка", $body);
    }

    echo "<script>window.location.replace('/index.html');</script>";
}


if (isset($_FILES["file"])) {

    // Получение расширения файла
    $nameArr = explode(".", basename($_FILES["file"]["name"]));
    $extension = $nameArr[count($nameArr) - 1];

    $error = false;

    if ($extension != "doc" && $extension != "docx" && $extension != "pdf" && $extension != "jpg" && $extension != "jpeg" && $extension != "png") {
        http_response_code(400);
        echo "Неверный формат файла";

        $error = true;
    }

    if ($_FILES["file"]["size"] > 1000000) {
        http_response_code(400);
        echo "Слишком большой файл";

        $error = true;
    }

    if (!$error) {

        $target_dir = "cv/";
        $target_file = $target_dir .  uniqid() . "." . $extension;


        

        if(isset($_POST['vacancy_id']) && $_POST['vacancy_id'] != "undefined"){
            $vacancy_id = $_POST['vacancy_id'];
        } else{
            $vacancy_id = "NULL";
        }

        $original_name = $_FILES['file']['name'];
        
        $sql = "INSERT INTO `cv` VALUE(NULL, $vacancy_id, '$target_file', '$original_name', DEFAULT)";

        if (!mysqli_query($link, $sql)) {
            $error = mysqli_error($link);
            echo "</br>$error";
        }



        move_uploaded_file($_FILES['file']['tmp_name'], $target_file);
    }
}
