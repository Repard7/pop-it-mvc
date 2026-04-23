<h2>➕ Добавление дисциплины</h2>

<form method="post">
    <label>Название дисциплины <input type="text" name="name" required></label>

    <label>Количество часов <input type="number" name="hours" required></label>

    <label>Семестр 
        <select name="semester" required>
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

    <label>Кафедра
        <select name="department_id">
            <option value="">— Без кафедры —</option>
            <?php foreach ($departments as $dep): ?>
                <option value="<?= $dep->department_id ?>"><?= $dep->department_name ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <button>Добавить</button>
    <a href="<?= app()->route->getUrl('/disciplines') ?>">Отмена</a>
</form>