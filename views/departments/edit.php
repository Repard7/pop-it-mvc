<h2>Редактирование кафедры</h2>

<form method="post" action="<?= app()->route->getUrl('/departments/edit?id=' . $department->department_id) ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

    <div class="form-group">
        <label>Название кафедры</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $department->department_name) ?>">
        <?php $field = 'name'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Код кафедры</label>
        <input type="text" name="code" value="<?= htmlspecialchars($old['code'] ?? $department->code) ?>">
        <small>Например: ПИ, ИС, КБ</small>
        <?php $field = 'code'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>