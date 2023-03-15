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

if (isset($_GET["exit"])) {
    setcookie("login", "", -1);
    setcookie("password", "", -1);
    echo "<script>window.location.replace('/index.html');</script>";
    exit;
}

?>

<?php

$count_task_query = "SELECT COUNT(*) AS count FROM `task` WHERE `isNew` = 1";
$count_vacancy_query = "SELECT COUNT(*) AS count FROM `vacancy`";
$count_cv_query = "SELECT COUNT(*) AS count FROM `cv`";

$count_task = mysqli_fetch_array(mysqli_query($link, $count_task_query))["count"];
$count_vacancy = mysqli_fetch_array(mysqli_query($link, $count_vacancy_query))["count"];
$count_cv = mysqli_fetch_array(mysqli_query($link, $count_cv_query))["count"];


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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="/admin/index.php">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/tasks.php">Заявки</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/vacancy.php">Вакансии</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/cv.php">Резюме</a>
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

    <main class="container flex">

        <div class="row">

            <div class="card m-3" style="width: 18rem;">
                <div class="card-header">
                    <h3>Новых заявок</h3>
                </div>
                <div class="card-body">
                    <h5><?php echo $count_task; ?></h5>
                </div>
            </div>

            <div class="card m-3" style="width: 18rem;">
                <div class="card-header">
                    <h3>Открытых вакансий</h3>
                </div>
                <div class="card-body">
                    <h5><?php echo $count_vacancy; ?></h5>
                </div>
            </div>

            <div class="card m-3" style="width: 18rem;">
                <div class="card-header">
                    <h3>Резюме</h3>
                </div>
                <div class="card-body">
                    <h5><?php echo $count_cv; ?></h5>
                </div>
            </div>

            <div class="card m-3" style="width: 18rem;">
                <div class="card-header">
                    <h3>Довольных клиентов😊</h3>
                </div>
                <div class="card-body">
                    <h5>→∞</h5>
                </div>
            </div>

        </div>

    </main>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>