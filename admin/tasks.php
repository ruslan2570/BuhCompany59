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

if(isset($_GET["all"])){
    if($_GET["all"] == "1"){
        $query = "SELECT * FROM `task` ORDER BY id DESC";        
    }
} else{
    $query = "SELECT * FROM `task` WHERE `isNew` = 1 ORDER BY id DESC";        
}

if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $list = mysqli_query($link, $query);
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
                            <a class="nav-link active" href="/admin/tasks.php">Заявки</a>
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

    <main class="container">

    <h1 class="text-center">Заявки</h1>
        <div>
            <?php 

            if(isset($_GET["all"])){
                if($_GET["all"] == "1"){?>
                    <a class="link" href="/admin/tasks.php">новые</a>
                <a class="link link-dark" href="/admin/tasks.php?all=1">Все</a>        
                <?php } 

            } else{ ?>
                <a class="link link-dark" href="/admin/tasks.php">новые</a>
                <a class="link" href="/admin/tasks.php?all=1">Все</a>        
            <?php } ?>

        </div>

        <div class="row mt-5">
                <div class="col">
                    <div class="datatable">
                        <table class="table table-hover table-sm " style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="th-sm" scope="col">№</th>
                                    <th class="th-sm" scope="col">Имя</th>
                                    <th class="th-sm" style="width: 15%;" scope="col">Телефон</th>
                                    <th class="th-sm" scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($list as $row) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $row["id"]; ?></th>
                                        <td><?php echo $row["name"]; ?></td>
                                        <td><?php echo $row["phone"]; ?></td>
                                        <td><?php echo $row["email"]; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
</div>

    </main>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>



<?php 

$query = "UPDATE `task` SET `isNew` = 0";        
if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
}

?>