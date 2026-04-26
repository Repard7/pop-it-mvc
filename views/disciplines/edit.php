<h2>✏️ Редактирование дисциплины</h2>

<form method="post" action="<?= app()->route->getUrl('/disciplines/edit?id=' . $discipline->discipline_id) ?>">
    <label style="display: block; margin-bottom: 15px;">
        Название дисциплины<br>
        <input type="text" name="name" value="<?= htmlspecialchars($discipline->discipline_name) ?>" required style="width: 100%;">
    </label>

    <fieldset style="margin-bottom: 20px;">
        <legend>Кафедры:</legend>
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

    <button type="submit">Сохранить</button>
    <a href="<?= app()->route->getUrl('/disciplines') ?>">Отмена</a>
</form>