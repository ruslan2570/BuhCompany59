<?php
$config = include 'db_config.php';
header("Content-Type: text/html; charset=UTF-8");

// Забираем данные из формы

if (isset($_POST["login"])) {
    $login = $_POST["login"];
}
if (isset($_POST["pass"])) {
    $pass = $_POST["pass"];
}

// Подключение к БД
$db_host = $config["host"];
$db_user = $config["user"];
$db_password = $config["password"];
$db_name = $config["db"];

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}

// Запрос пароля пользователя
$sql = "SELECT password FROM `user` WHERE `login` LIKE '$login'";
if (!mysqli_query($link, $sql)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $result = mysqli_query($link, $sql);
}

$count = mysqli_num_rows($result);
$hashed_password = mysqli_fetch_assoc($result)["password"];

if ($count == 1 && md5($login.":".$pass) == $hashed_password) {
    setcookie("login", $login, time() + 604800);
    setcookie("password", $hashed_password, time() + 604800);
} else {
    echo '<script>';
    echo 'alert("Неправильный логин или пароль");';
    echo '</script>';
}

echo '<script>';
echo 'window.location.replace("index.php");';
echo '</script>';

?>