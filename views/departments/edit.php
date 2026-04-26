<h2>Редактирование кафедры</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error" style="background: rgba(234, 67, 53, 0.1); color: #EA4335; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 3px solid #EA4335;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= app()->route->getUrl('/departments/edit?id=' . $department->department_id) ?>">
    <div class="form-group">
        <label>Название кафедры</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $department->department_name) ?>">
    </div>
    
    <div class="form-group">
        <label>Код кафедры</label>
        <input type="text" name="code" value="<?= htmlspecialchars($old['code'] ?? $department->code) ?>">
        <small>Например: ПИ, ИС, КБ</small>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>