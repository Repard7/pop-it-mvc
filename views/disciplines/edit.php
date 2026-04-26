<h2>Редактирование дисциплины</h2>

<?php if (!empty($errors)): ?>
    <div style="background: rgba(234, 67, 53, 0.1); color: #EA4335; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 3px solid #EA4335;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= app()->route->getUrl('/disciplines/edit?id=' . $discipline->discipline_id) ?>">
    <div class="form-group">
        <label>Название дисциплины</label>
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? $discipline->discipline_name) ?>">
    </div>

    <div class="form-group">
        <label>Количество часов</label>
        <input type="number" name="hours" value="<?= htmlspecialchars($old['hours'] ?? $discipline->hours) ?>">
    </div>

    <div class="form-group">
        <label>Семестр</label>
        <select name="semester">
            <?php $selectedSemester = $old['semester'] ?? $discipline->semester; ?>
            <option value="1" <?= $selectedSemester == 1 ? 'selected' : '' ?>>1 семестр</option>
            <option value="2" <?= $selectedSemester == 2 ? 'selected' : '' ?>>2 семестр</option>
            <option value="3" <?= $selectedSemester == 3 ? 'selected' : '' ?>>3 семестр</option>
            <option value="4" <?= $selectedSemester == 4 ? 'selected' : '' ?>>4 семестр</option>
            <option value="5" <?= $selectedSemester == 5 ? 'selected' : '' ?>>5 семестр</option>
            <option value="6" <?= $selectedSemester == 6 ? 'selected' : '' ?>>6 семестр</option>
            <option value="7" <?= $selectedSemester == 7 ? 'selected' : '' ?>>7 семестр</option>
            <option value="8" <?= $selectedSemester == 8 ? 'selected' : '' ?>>8 семестр</option>
        </select>
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
                <input type="checkbox" 
                       name="department_ids[]" 
                       value="<?= $dep->department_id ?>"
                       <?= in_array($dep->department_id, $selectedIds) ? 'checked' : '' ?>>
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>