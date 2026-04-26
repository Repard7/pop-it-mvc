<h2>Редактирование дисциплины</h2>

<form method="post" action="<?= app()->route->getUrl('/disciplines/edit?id=' . $discipline->discipline_id) ?>">
    <div class="form-group">
        <label>Название дисциплины</label>
        <input type="text" name="name" value="<?= htmlspecialchars($discipline->discipline_name) ?>" required>
    </div>

    <div class="form-group">
        <label>Количество часов</label>
        <input type="number" name="hours" value="<?= $discipline->hours ?>" required>
    </div>

    <div class="form-group">
        <label>Семестр</label>
        <select name="semester" required>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i ?>" <?= $discipline->semester == $i ? 'selected' : '' ?>>
                    <?= $i ?> семестр
                </option>
            <?php endfor; ?>
        </select>
    </div>

    <fieldset>
        <legend>Кафедры</legend>
        <input type="hidden" name="department_ids" value="">
        <?php 
        $attachedIds = $discipline->departments->pluck('department_id')->toArray();
        foreach ($departments as $dep): 
        ?>
            <label style="display: block; margin: 8px 0;">
                <input type="checkbox" 
                       name="department_ids[]" 
                       value="<?= $dep->department_id ?>"
                       <?= in_array($dep->department_id, $attachedIds) ? 'checked' : '' ?>>
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>