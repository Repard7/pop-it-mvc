<h2>Редактирование сотрудника</h2>

<form method="post" action="<?= app()->route->getUrl('/employees/edit?id=' . $employee->employee_id) ?>">
    <div class="form-grid">
        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($employee->last_name) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($employee->first_name) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($employee->patronymic) ?>">
        </div>

        <div class="form-group">
            <label>Пол</label>
            <select name="gender" required>
                <option value="М" <?= $employee->gender === 'М' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= $employee->gender === 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($employee->birth_date) ?>" required>
        </div>
        
        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" value="<?= htmlspecialchars($employee->registration_address) ?>" required>
        </div>

        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="<?= htmlspecialchars($user->login ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label>Новый пароль <small>(оставьте пустым, чтобы не менять)</small></label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Кафедра</label>
            <select name="department_id">
                <option value="">— Без кафедры —</option>
                <?php foreach ($departments as $dep): ?>
                    <option value="<?= $dep->department_id ?>" <?= ($user->department_id ?? '') == $dep->department_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dep->department_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php if (isset($user->position)): ?>
        <div class="info-message">
            Должность: <strong><?= htmlspecialchars($user->position->position_name) ?></strong>
        </div>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Сохранить изменения</button>
        <a href="<?= app()->route->getUrl('/employees') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>