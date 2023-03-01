<?php
$db_config = include 'db_config.php';
header("Content-Type: text/html; charset=UTF-8");

// Подключение к БД
$db_host = $db_config["host"];
$db_user = $db_config["user"];
$db_password = $db_config["password"];
$db_name = $db_config["db"];

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}

if (isset($_COOKIE["login"]) && isset($_COOKIE["password"])) {
    $login = $_COOKIE["login"];
    $password = $_COOKIE["password"];
}

$query = "SELECT password FROM `user` WHERE login LIKE '$login'";
if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $result = mysqli_query($link, $query);
}

if (mysqli_num_rows($result) == 0 || $password != mysqli_fetch_assoc($result)["password"]) {
    echo "<script>window.location.replace('login.php');</script>";
    exit;
}

?>

<?php
if (isset($_GET["file"])) {
    $file = basename($_GET['file']);
    $file = '../cv/' . $file;

    if (!file_exists($file)) {
        die('file not found');
    } else {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        readfile($file);
    }
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
    <title>Администрирование</title>
</head>

<body>
    <header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Админка</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/index.php">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/tasks.php">Заявки</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/vacancy.php">Вакансии</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="/admin/cv.php">Резюме</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/profile.php">Профиль</a>
                        </li>
                        
                    </ul>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav mе-auto mb-2 top-menu">
                        </ul>
                        <div class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                            <a href="index.php?exit=1" class="btn btn-outline-danger dropdown-item">Выйти</a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        <h1 class="text-center">Резюме</h1>
        <p class="text-danger">Будьте бдительны при скачивании файлов из интернета</p>

        <div class="container cv-list">
            <?php
            $handle = opendir('../cv/');
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    echo "<a class='link' href='cv.php?file=" . $entry . "'>" . $entry . "</a>\n";
                }
            }
            ?>
        </div>
    </main>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>