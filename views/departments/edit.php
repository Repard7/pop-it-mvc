<h2>✏️ Редактирование кафедры</h2>

<form method="post" action="<?= app()->route->getUrl('/departments/edit?id=' . $department->department_id) ?>">
    <label>Название кафедры 
        <input type="text" name="name" value="<?= htmlspecialchars($department->department_name) ?>" required>
    </label>

    <button>Сохранить</button>
    <a href="<?= app()->route->getUrl('/departments') ?>">Отмена</a>
</form>