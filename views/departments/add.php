<h2>Добавление кафедры</h2>

<form method="post" class="form">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

    <div class="form-group">
        <label>Название кафедры</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
        <?php $field = 'name'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Код кафедры</label>
        <input type="text" name="code" placeholder="Например: ПИ, ИС, КБ" value="<?= htmlspecialchars($old['code'] ?? '') ?>">
        <?php $field = 'code'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Добавить</button>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>