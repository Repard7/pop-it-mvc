<h2>Редактирование кафедры</h2>

<form method="post" action="<?= app()->route->getUrl('/departments/edit?id=' . $department->department_id) ?>">
    <div class="form-group">
        <label>Название кафедры</label>
        <input type="text" name="name" value="<?= htmlspecialchars($department->department_name) ?>" required>
    </div>
    
    <div class="form-group">
        <label>Код кафедры</label>
        <input type="text" name="code" value="<?= htmlspecialchars($department->code) ?>" required>
        <small>Например: ПИ, ИС, КБ</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>