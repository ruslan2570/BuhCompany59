<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
    <title>Авторизация</title>
</head>

<body class="text-center container pt-5">
    <main class="form-signin w-50 mx-auto">
        <form action="authorize.php" method="post">
            <h3 class="h3 mb-3 fw-normal">Авторизация</h3>

            <div class="form-floating mb-3">
                <input class="form-control" name="login" id="floatingLogin" placeholder="Логин">
                <label for="floatingLogin">Логин</label>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Пароль">
                <label for="floatingPassword">Пароль</label>
            </div>

            <button class="w-100 btn btn-lg btn-success mb-2 btn-login" type="submit">Войти</button>
            <a href="/index.html" class="text-decoration-none text-reset">Вернуться назад</a>
        </form>
    </main>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>