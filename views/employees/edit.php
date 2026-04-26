<h2>✏️ Редактирование сотрудника</h2>

<form method="post" action="<?= app()->route->getUrl('/employees/edit?id=' . $employee->employee_id) ?>">
    <label>Фамилия 
        <input type="text" name="lastname" value="<?= htmlspecialchars($employee->last_name) ?>" required>
    </label>
    
    <label>Имя 
        <input type="text" name="firstname" value="<?= htmlspecialchars($employee->first_name) ?>" required>
    </label>
    
    <label>Отчество 
        <input type="text" name="middlename" value="<?= htmlspecialchars($employee->patronymic) ?>">
    </label>

    <label>Пол
        <select name="gender" required>
            <option value="male" <?= $employee->gender === 'М' ? 'selected' : '' ?>>Мужской</option>
            <option value="female" <?= $employee->gender === 'Ж' ? 'selected' : '' ?>>Женский</option>
        </select>
    </label>

    <label>Дата рождения 
        <input type="date" name="birthdate" value="<?= htmlspecialchars($employee->birth_date) ?>" required>
    </label>
    
    <label>Адрес 
        <input type="text" name="address" value="<?= htmlspecialchars($employee->registration_address) ?>" required>
    </label>

    <label>Логин 
        <input type="text" name="login" value="<?= htmlspecialchars($user->login ?? '') ?>" required>
    </label>
    
    <label>Новый пароль (оставьте пустым, чтобы не менять)
        <input type="password" name="password">
    </label>

    <label>Кафедра
        <select name="department_id">
            <option value="">— Без кафедры —</option>
            <?php foreach ($departments as $dep): ?>
                <option value="<?= $dep->department_id ?>" <?= ($user->department_id ?? '') == $dep->department_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dep->department_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button>Сохранить</button>
    <a href="<?= app()->route->getUrl('/employees') ?>">Отмена</a>
</form>