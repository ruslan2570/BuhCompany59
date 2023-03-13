<?php

$config = include 'admin/db_config.php';
header("Content-Type: text/html; charset=UTF-8");

// Подключение к БД
$db_host = $config["host"];
$db_user = $config["user"];
$db_password = $config["password"];
$db_name = $config["db"];

$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if ($link === false) {
    die("Ошибка: " . mysqli_connect_error());
}

$query = "SELECT * FROM `vacancy` WHERE `isActive` = 1";
if (!mysqli_query($link, $query)) {
    $error = mysqli_error($link);
    echo "</br>$error";
} else {
    $result = mysqli_query($link, $query);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Бухгалтерские услуги - <БухСервис> &quot;59&quot;</title>
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<header class="header">
        <a href="/index.html">
            <img class="logo" src="/img/templogo.png">
        </a>
        <nav class="header-links">
            <a href="/index.html">Главная</a>
            <a href="/services.html">Услуги</a>
            <a href="/prices.html">Цены</a>
            <a href="/about.html" class="active-link">О нас</a>
            <a href="/vacancy.php">Вакансии</a>
            <a href="/contacts.html">Контакты</a>
        </nav>
        <div class="header-contacts">
            <h3 class="header-phone">+7 913 451 43 41</h3>
            <p class="header-hours">Пн&nbsp;&mdash; пт 9:00&nbsp;&mdash; 18:00</p>
        </div>
        <div>
            <button class="btn btn-call">Заказать звонок</button>
        </div>

        <div class="modal-form">

            <div class="modal-content">
                <span class="modal-close">&times;</span>

                <form action="request.php" class="form" method="post">

                    <div class="form-control">
                        <label for="name" id="label-name">
                            Ваше имя
                        </label>
                        <input type="text" id="name" name="name" placeholder="Иван" required />
                    </div>
                    <div class="form-control">
                        <label for="phone" id="label-phone">
                            Телефон
                        </label>
                        <input type="phone" id="phone" name="phone" placeholder="+7..." required />
                    </div>
                    <div class="form-control">
                        <label for="email" id="label-email">
                            Электронная почта
                        </label>
                        <input type="email" id="email" name="email" />
                    </div>
                    </li>
                    <button class="btn btn-form">Оставить заявку</button>
                </form>
            </div>
        </div>


        <div class="modal-vacancy">

            <div class="modal-content">
                <span class="modal-close">&times;</span>

                <div>

                    <div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);" onclick="clickHandler(event)">
                        <div>
                            <p class="drop_text">Поместите свое резюме в эту зону.</p>
                            <p class="drop_text">Или нажмите и выберите файл.</p>
                        </div>
                    </div>

                    </li>
                    <button id="btn-send-cv" class="btn">Отправить резюме</button>
                    </form>
                </div>
            </div>

    </header>

    <main class="service-description-container">
        <h1>Вакансии</h1>

        <?php

        if (mysqli_num_rows($result) == 0) {
            echo '<p class="no-vacancy-text">Уважаемые соискатели, на текущий момент в БК «Эталон» отсутствуют открытые вакансии. Вы можете прикрепить свое резюме ниже, и мы рассмотрим Вашу кандидатуру в первую очередь при расширении команды.</p>';
        } else {

        ?>

            <div class="vacancy-list">
                <?php foreach ($result as $row) { ?>
                    <div class="vacancy-card">
                        <h2 class="vacancy-header">
                            <?php echo $row["name"] ?>
                        </h2>
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
                                            <button vacancy-id=<?php echo $row['id']; ?> class="btn btn-vacancy">Откликнуться</button>
                    </div>
            <?php }
            } ?>
            </div>

            <?php if (mysqli_num_rows($result) == 0) { ?>
                <!-- <div class="form-container">
                <p class="form-label">Вы можете прикрепить своё резюме здесь</p>
                <form action="request.php" method="post" enctype="multipart/form-data">
                    <input type="file" name="cvFile" id="cvFile">
                    <button class="btn" type="submit">Отправить</button>
                </form>
            </div> -->
                <div>
                    <button class="btn vacancy-btn">Выберите файл</button>
                </div>
            <?php } ?>

    </main>

    <footer>
        <div class="footer-links">
            <div>
                <h2>Навигация</h2>
                <hr>
                <nav>
                    <a href="prices.html">Наши цены</a>
                    <a href="vacancy.html">Вакансии</a>
                    <a href="about.html">О нас</a>
                    <a href="contacts.html">Контакты</a>
                </nav>
            </div>
            <div>
                <h2>Услуги</h2>
                <hr>
                <nav>
                    <a href="/services/zeroreporting.html">Нулевая отчетность</a>
                    <a href="/services/personnel-accounting.html">Кадровый учет</a>
                    <a href="/services/accounting.html">Бухгалтерские услуги</a>
                    <a href="/services/other.html">Дополнительные услуги</a>
                </nav>
            </div>
            <div>
                <h2>Контакты</h2>
                <hr>
                <ul>
                    <li>Тел.: <a href="tel:89134514341">+7 913 451 43 41</a></li>
                    <li>E-mail:<a href="mailto:pochikovskaya.n@mail.ru">pochikovskaya.n@mail.ru</a></li>
                    <li>Адрес: <a href="https://yandex.ru/maps/-/CCUKqLArdA" target="_blank">РФ, г.Новосибирск,ул. Танковая, 72</a></li>
                    <ul>
            </div>
        </div>

        <div class="copyright">
            <h3>All Rights Reserved 2023</h3>
        </div>
    </footer>
    <script src="/js/modal.js"></script>
    <script src="/js/uploadCV.js"></script>
    <script src="/js/sticky.js"></script>
    <script src="https://yastatic.net/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>