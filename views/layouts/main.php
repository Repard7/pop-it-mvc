<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>EduManager</title>
   <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav>
        <?php if (app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/employees') ?>">Сотрудники</a>
            <a href="<?= app()->route->getUrl('/departments') ?>">Кафедры</a>
            <a href="<?= app()->route->getUrl('/disciplines') ?>">Дисциплины</a>
            <?php if (app()->auth::user()->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/employees/add') ?>">Добавить сотрудника</a>
            <?php endif; ?>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->login ?>)</a>
        <?php endif; ?>
    </nav>
</header>
<main>
   <?= $content ?? '' ?>
</main>
</body>
</html>