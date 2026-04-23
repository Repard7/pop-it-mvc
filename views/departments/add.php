<h2>Добавление кафедры</h2>

<form method="post">
    <label>Название кафедры <input type="text" name="name" required></label>
    
    <label>Код кафедры <input type="text" name="code" placeholder="Например: ПИ, ИС, КБ" required></label>

    <button>Добавить</button>
    <a href="<?= app()->route->getUrl('/departments') ?>">Отмена</a>
</form>