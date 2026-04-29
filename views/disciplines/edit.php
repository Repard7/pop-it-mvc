<h2>Редактирование дисциплины</h2>

<form method="post" action="<?= app()->route->getUrl('/disciplines/edit?id=' . $discipline->discipline_id) ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

    <div class="form-group">
        <label>Название дисциплины</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $discipline->discipline_name) ?>">
        <?php $field = 'name'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Количество часов</label>
        <input type="number" name="hours" value="<?= htmlspecialchars($old['hours'] ?? $discipline->hours) ?>">
        <?php $field = 'hours'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <div class="form-group">
        <label>Семестр</label>
        <select name="semester">
            <?php $selectedSemester = $old['semester'] ?? $discipline->semester; ?>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i ?>" <?= $selectedSemester == $i ? 'selected' : '' ?>><?= $i ?> семестр</option>
            <?php endfor; ?>
        </select>
        <?php $field = 'semester'; require __DIR__ . '/../parts/error.php'; ?>
    </div>

    <fieldset>
        <legend>Кафедры</legend>
        <input type="hidden" name="department_ids" value="">
        <?php 
        $attachedIds = $discipline->departments->pluck('department_id')->toArray();
        $oldIds = (array)($old['department_ids'] ?? []);
        $selectedIds = !empty($oldIds) ? $oldIds : $attachedIds;
        foreach ($departments as $dep): 
        ?>
            <label style="display: block; margin: 5px 0;">
                <input type="checkbox" name="department_ids[]" value="<?= $dep->department_id ?>"
                    <?= in_array($dep->department_id, $selectedIds) ? 'checked' : '' ?>>
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
        <?php $field = 'department_ids'; require __DIR__ . '/../parts/error.php'; ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>