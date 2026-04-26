<!doctype html>
<html lang="ru">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>EduManager | Учебно-методическое управление</title>
   <link rel="stylesheet" href="<?= app()->route->getUrl('/css/styles.css') ?>">
</head>
<body>

<?php if (app()->auth::check()): ?>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/') ?>">EduManager</a>
        <a href="<?= app()->route->getUrl('/employees') ?>">Сотрудники</a>
        <a href="<?= app()->route->getUrl('/departments') ?>">Кафедры</a>
        <a href="<?= app()->route->getUrl('/disciplines') ?>">Дисциплины</a>
        <?php if (app()->auth::user()->isAdmin()): ?>
            <a href="<?= app()->route->getUrl('/employees/add') ?>">Добавить сотрудника</a>
        <?php endif; ?>
        <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= htmlspecialchars(app()->auth::user()->login) ?>)</a>
    </nav>
</header>
<?php endif; ?>

<main>
   <?= $content ?? '' ?>
</main>

</body>
</html>