<h2>Добавление дисциплины</h2>

<?php if (!empty($errors)): ?>
    <div style="background: rgba(234, 67, 53, 0.1); color: #EA4335; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 3px solid #EA4335;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post">
    <div class="form-group">
        <label>Название дисциплины</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Количество часов</label>
        <input type="number" name="hours" value="<?= htmlspecialchars($old['hours'] ?? '') ?>">
    </div>

    <div class="form-group">
        <label>Семестр</label>
        <select name="semester" required>
            <option value="1" <?= ($old['semester'] ?? '') == 1 ? 'selected' : '' ?>>1 семестр</option>
            <option value="2" <?= ($old['semester'] ?? '') == 2 ? 'selected' : '' ?>>2 семестр</option>
            <option value="3" <?= ($old['semester'] ?? '') == 3 ? 'selected' : '' ?>>3 семестр</option>
            <option value="4" <?= ($old['semester'] ?? '') == 4 ? 'selected' : '' ?>>4 семестр</option>
            <option value="5" <?= ($old['semester'] ?? '') == 5 ? 'selected' : '' ?>>5 семестр</option>
            <option value="6" <?= ($old['semester'] ?? '') == 6 ? 'selected' : '' ?>>6 семестр</option>
            <option value="7" <?= ($old['semester'] ?? '') == 7 ? 'selected' : '' ?>>7 семестр</option>
            <option value="8" <?= ($old['semester'] ?? '') == 8 ? 'selected' : '' ?>>8 семестр</option>
        </select>
    </div>

    <fieldset>
        <legend>Кафедры</legend>
        <input type="hidden" name="department_ids" value="">
        <?php foreach ($departments as $dep): ?>
            <label style="display: block; margin: 5px 0;">
                <input type="checkbox" 
                       name="department_ids[]" 
                       value="<?= $dep->department_id ?>"
                       <?= (in_array($dep->department_id, (array)($old['department_ids'] ?? []))) ? 'checked' : '' ?>>
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Добавить</button>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>