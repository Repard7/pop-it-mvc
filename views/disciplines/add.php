<h2>Добавление дисциплины</h2>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

    <div class="form-group">
        <label>Название дисциплины</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
        <?php $field = 'name'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Количество часов</label>
        <input type="number" name="hours" value="<?= htmlspecialchars($old['hours'] ?? '') ?>">
        <?php $field = 'hours'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Семестр</label>
        <select name="semester">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i ?>" <?= (($old['semester'] ?? '') == $i) ? 'selected' : '' ?>><?= $i ?> семестр</option>
            <?php endfor; ?>
        </select>
        <?php $field = 'semester'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <fieldset>
        <legend>Кафедры (выберите хотя бы одну)</legend>
        <?php foreach ($departments as $dep): ?>
            <label style="display: block; margin: 5px 0;">
                <input type="checkbox" name="department_ids[]" value="<?= $dep->department_id ?>"
                    <?= in_array($dep->department_id, (array)($old['department_ids'] ?? [])) ? 'checked' : '' ?>>
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
        <?php $field = 'department_ids'; require __DIR__ . '/../parts/error.php'; ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Добавить</button>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>