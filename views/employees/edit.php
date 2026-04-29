<h2>Редактирование сотрудника</h2>

<?php if (!empty($errors)): ?>
    <div style="background: rgba(234, 67, 53, 0.1); color: #EA4335; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 3px solid #EA4335;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="<?= app()->route->getUrl('/employees/edit?id=' . $employee->employee_id) ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <div class="form-grid">
        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? $employee->last_name) ?>">
        </div>
        
        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? $employee->first_name) ?>">
        </div>
        
        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($old['middlename'] ?? $employee->patronymic) ?>">
        </div>

        <div class="form-group">
            <label>Пол</label>
            <select name="gender">
                <option value="М" <?= ($old['gender'] ?? $employee->gender) == 'М' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= ($old['gender'] ?? $employee->gender) == 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($old['birthdate'] ?? $employee->birth_date) ?>">
        </div>
        
        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" value="<?= htmlspecialchars($old['address'] ?? $employee->registration_address) ?>">
        </div>

        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? $user->login ?? '') ?>">
        </div>

        <div class="form-group">
            <label>Кафедра</label>
            <select name="department_id">
                <option value="">— Без кафедры —</option>
                <?php foreach ($departments as $dep): ?>
                    <option value="<?= $dep->department_id ?>" <?= ($old['department_id'] ?? $user->department_id ?? '') == $dep->department_id ? 'selected' : '' ?>>
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