<h2>Добавление дисциплины</h2>

<form method="post">
    <label style="display: block; margin-bottom: 10px;">
        Название дисциплины<br>
        <input type="text" name="name" required style="width: 100%;">
    </label>

    <label style="display: block; margin-bottom: 10px;">
        Количество часов<br>
        <input type="number" name="hours" required style="width: 100%;">
    </label>

    <label style="display: block; margin-bottom: 15px;">
        Семестр<br>
        <select name="semester" required style="width: 100%;">
            <option value="1">1 семестр</option>
            <option value="2">2 семестр</option>
            <option value="3">3 семестр</option>
            <option value="4">4 семестр</option>
            <option value="5">5 семестр</option>
            <option value="6">6 семестр</option>
            <option value="7">7 семестр</option>
            <option value="8">8 семестр</option>
        </select>
    </label>

    <fieldset style="margin-bottom: 20px;">
        <legend>Кафедры:</legend>
        
        <input type="hidden" name="department_ids" value="">
        
        <?php foreach ($departments as $dep): ?>
            <label style="display: block; margin: 5px 0;">
                <input type="checkbox" 
                       name="department_ids[]" 
                       value="<?= $dep->department_id ?>">
                <?= htmlspecialchars($dep->department_name) ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <button type="submit">Добавить</button>
    <a href="<?= app()->route->getUrl('/disciplines') ?>">Отмена</a>
</form>