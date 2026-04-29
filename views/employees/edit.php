<h2>Редактирование сотрудника</h2>

<form method="post" action="<?= app()->route->getUrl('/employees/edit?id=' . $employee->employee_id) ?>">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <div class="form-grid">

        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? $employee->last_name) ?>">
            <?php $field = 'lastname'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? $employee->first_name) ?>">
            <?php $field = 'firstname'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($old['middlename'] ?? $employee->patronymic) ?>">
            <?php $field = 'middlename'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Пол</label>
            <select name="gender">
                <option value="М" <?= ($old['gender'] ?? $employee->gender) == 'М' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= ($old['gender'] ?? $employee->gender) == 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
            <?php $field = 'gender'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($old['birthdate'] ?? $employee->birth_date) ?>">
            <?php $field = 'birthdate'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" value="<?= htmlspecialchars($old['address'] ?? $employee->registration_address) ?>">
            <?php $field = 'address'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? $user->login ?? '') ?>">
            <?php $field = 'login'; require __DIR__ . '/../parts/error.php'; ?>
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
            <?php $field = 'department_id'; require __DIR__ . '/../parts/error.php'; ?>
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