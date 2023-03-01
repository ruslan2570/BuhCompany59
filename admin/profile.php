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

$query = "SELECT * FROM `user` WHERE login LIKE '$login'";
if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $result = mysqli_query($link, $query);
}
$result_arr = mysqli_fetch_array($result);

?>

<?php

if (isset($_GET['act'])) {

    $action = $_GET['act'];

    switch ($action) {
        case 'chng-pass':

            if (isset($_GET['password']) && isset($_COOKIE['login'])) {

                $newpassword = $_GET['password'];
                $login = $_COOKIE['login'];

                $hashedpassword = md5($login. ":". $newpassword);

                $query = "UPDATE `user` SET `password` = '$hashedpassword' WHERE `login` LIKE '$login'";
                if (!mysqli_query($link, $query)) {
                    $error = mysqli_error($link);
                    echo "</br>$error";
                }

            }

            break;

        case 'chng-email':

            if (isset($_GET['email']) && isset($_COOKIE['login'])) {

                if(!empty($_GET['email'])){
                    $email = '"' . $_GET['email'] . '"';
                } else{
                    $email = 'NULL';
                }

                $login = $_COOKIE['login'];

                $query = "UPDATE `user` SET `email` = $email WHERE `login` LIKE '$login'";
                if (!mysqli_query($link, $query)) {
                    $error = mysqli_error($link);
                    echo "</br>$error";
                } 

            }

            break;

        case 'del':

            if (isset($_COOKIE['login'])) {

                $login = $_COOKIE['login'];

                $query = "SELECT COUNT(*) AS count FROM `user`";
                if (!mysqli_query($link, $query)) {
                    $error = mysqli_error($link);
                    echo "</br>$error";
                } else {
                    $result = mysqli_query($link, $query);
                }

                if(mysqli_fetch_array($result)['count'] == 1 ){
                    echo "<script>alert('Невозможно выполнить удаление, т.к. Вы - последний пользователь')</script>";
                    break;
                }

                $query = "DELETE FROM `user` WHERE `login` LIKE '$login'";
                if (!mysqli_query($link, $query)) {
                    $error = mysqli_error($link);
                    echo "</br>$error";
                }

            }

            break;

        case 'add':

            if (isset($_GET['login']) &&
             isset($_GET['password']) &&
              isset($_GET['email'])) {

                $login = $_GET['login'];
                $password = $_GET['password'];
                
                $hashedpassword = md5($login . ":" . $password);

                if(!empty($_GET['email'])){
                    $email = '"' . $_GET['email'] . '"';
                } else{
                    $email = 'NULL';
                }

                $query = "INSERT INTO `user` VALUES (null, '$login', '$hashedpassword', $email)";
                echo $query;
                if (!mysqli_query($link, $query)) {
                    $error = mysqli_error($link);
                    echo "</br>$error";
                }

            }
            
            break;


    }

    echo "<script>window.location='/admin/profile.php'</script>";

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
                            <a class="nav-link active" href="/admin/profile.php">Профиль</a>
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
        <h1 class="text-center">Мой профиль</h1>


        <div>

            <?php

            $login = $result_arr['login'];
            $email = $result_arr['email'];

            echo "<p>Логин:  $login</p><p>Электронная почта: $email</p>";

            ?>

            <div class="accordion" id="accordionProfile">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Сменить пароль
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#accordionProfile">
                        <div class="accordion-body">
                            <form action="#" class="container-sm">
                                <input name="act" value="chng-pass" style="display: none;">
                                <div class="mb3">
                                    <label for="name">Введите новый пароль *</label>
                                    <input type="password" name="password" id="password" required class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary m-3">Сменить пароль</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Сменить адрес электронной почты
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#accordionProfile">
                        <div class="accordion-body">
                            <form action="#" class="container-sm">
                                <input name="act" value="chng-email" style="display: none;">
                                <div class="mb3">
                                    <label for="name">Введите новый адрес</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                    <p>Оставте поле пустым, если не хотите получать уведомления на почту</p>
                                </div>

                                <button type="submit" class="btn btn-primary m-3">Сменить Email</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Удалить профиль
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionProfile">
                        <div class="accordion-body">
                            <form action="#" class="container-sm">
                                <input name="act" value="del" style="display: none;">
                                <div class="mb3">
                                    <p class="text-danger">ВНИМАНИЕ: Данная кнопка удалит Ваш профиль</p>
                                </div>

                                <button type="submit" class="btn btn-danger m-3">Удалить профиль</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Создать новый профиль
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#accordionProfile">
                        <div class="accordion-body">
                            <form action="#" class="container-sm">
                                <input name="act" value="add" style="display: none;">
                                <div class="mb3">
                                    <label for="name">Введите логин*</label>
                                    <input type="text" name="login" id="login" required class="form-control">
                                </div>
                                <div class="mb3">
                                    <label for="name">Введите пароль*</label>
                                    <input type="password" name="password" id="password" required class="form-control">
                                </div>
                                <div class="mb3">
                                    <label for="name">Введите адрес электронной почты</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary m-3">Создать профиль</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </main>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>