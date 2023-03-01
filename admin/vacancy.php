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

$query = "SELECT * FROM `vacancy`";
if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $list = mysqli_query($link, $query);
}



?>


<?php
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case ('add'):

            if (!empty($_GET['name'])) {
                $name = '"'. $_GET['name'] . '"'; 
            } else {
                $name = 'NULL';
            }

            if (!empty($_GET['salary'])) {
                $salary = '"' . $_GET['salary'] . '"';
            } else {
                $salary = 'NULL';
            }

            if (!empty($_GET['experience'])) {
                $experience = '"' . $_GET['experience'] . '"';
            } else {
                $experience = 'NULL';
            }

            if (!empty($_GET['employment'])) {
                $employment = '"' . $_GET['employment'] . '"';
            } else {
                $employment = 'NULL';
            }

            if (!empty($_GET['education'])) {
                $education = '"' . $_GET['education'] . '"'; 
            } else {
                $education = 'NULL';
            }

            if (!empty($_GET['skills'])) {
                $skills = '"' . $_GET['skills'] . '"';
            } else {
                $skills = 'NULL';
            }

            $query = "INSERT INTO `vacancy` VALUES(NULL, $name, $salary, $experience, $employment, $education, $skills, DEFAULT) ";
            if (!mysqli_query($link, $query)) {
                $error = mysqli_error($link);
                echo "</br>$error";
            }

            break;

        case ('del'):
            $id = $_GET["id"];
            $query = "DELETE FROM `vacancy` WHERE `id` = $id";
            if (!mysqli_query($link, $query)) {
                $error = mysqli_error($link);
                echo "</br>$error";
            }

            break;

        case ('turnon'):
            $id = $_GET["id"];
            $query = "UPDATE `vacancy` SET `isActive` = 1 WHERE `id` = '$id'";
            if (!mysqli_query($link, $query)) {
                $error = mysqli_error($link);
                echo "</br>$error";
            }
            break;

        case ('turnoff'):
            $id = $_GET["id"];
            $query = "UPDATE `vacancy` SET `isActive` = 0 WHERE `id` = '$id'";
            if (!mysqli_query($link, $query)) {
                $error = mysqli_error($link);
                echo "</br>$error";
            }
            break;

    }

    echo "<script>document.location = 'vacancy.php'</script>";
    exit;
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
                            <a class="nav-link active" href="/admin/vacancy.php">Вакансии</a>
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
        <h1 class="text-center">Вакансии</h1>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Добавить вакансию
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="#" class="container-sm">
                            <input name="act" value="add" style="display: none;">
                            <div class="mb3">
                                <label for="name">Введите название *</label>
                                <input type="text" name="name" id="name" required class="form-control">
                            </div>
                            <div class="mb3">
                                <label for="salary">Введите зарплату</label>
                                <input type="text" name="salary" class="form-control">
                            </div>
                            <div class="mb3">
                                <label for="experience">Введите необходимый опыт работы</label>
                                <input type="text" name="experience" class="form-control">
                            </div>
                            <div class="mb3">
                                <label for="employment">Введите тип занятости</label>
                                <input type="text" name="employment" class="form-control">
                            </div>
                            <div class="mb3">
                                <label for="education">Введите необходимый уровень образования</label>
                                <input type="text" name="education" class="form-control">
                            </div>
                            <div class="mb3">
                                <label for="skills">Введите необходимые навыки</label>
                                <input type="text" name="skills" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary m-3">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Активные вакансии</h2>
        <div class="container">
            <?php foreach ($list as $row) { ?>
                <div class="card m-5">
                    <h3 class="card-header">
                        <?php echo $row["name"]; ?>
                    </h3>
                    <div class="card-body">
                        <?php if (isset($row["salary"])) { ?>
                            <p>Зарплата:
                                <?php echo $row["salary"];
                        } ?>
                        </p>
                        <?php if (isset($row["experience"])) { ?>
                            <p>Опыт работы:
                                <?php echo $row["experience"];
                        } ?>
                        </p>
                        <?php if (isset($row["employment"])) { ?>
                            <p>Тип занятости:
                                <?php echo $row["employment"];
                        } ?>
                        </p>
                        <?php if (isset($row["education"])) { ?>
                            <p>Образование:
                                <?php echo $row["education"];
                        } ?>
                        </p>
                        <?php if (isset($row["skills"])) { ?>
                            <p>Ключевые навыки:
                                <?php echo $row["skills"];
                        } ?>
                        </p>
                        <div>
                            <?php
                            $ab = '<a class="btn btn-danger" href="vacancy.php?act=del&id=';
                            $ae = '">Удалить</a>';
                            echo $ab . $row["id"] . $ae;
                            ?>

                            <?php
                            if ($row["isActive"] == 1) {
                                echo '<a class="btn btn-secondary" href="vacancy.php?act=turnoff&id=' . $row["id"] . '">Отключить</a>';
                            } else {
                                echo '<a class="btn btn-success" href="vacancy.php?act=turnon&id=' . $row["id"] . '">Включить</a>';
                            }

                            ?>

                        </div>
                    </div>


                </div>
            <?php } ?>
        </div>


    </main>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>