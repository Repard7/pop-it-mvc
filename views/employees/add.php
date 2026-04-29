<h2>Добавление сотрудника</h2>

<?php 
$currentUser = app()->auth::user();
$isAdmin = $currentUser->isAdmin();
$isDeaneryStaff = $currentUser->isDeaneryStaff();
?>

<form method="post">
    <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">
    <div class="form-grid">

        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
            <?php $field = 'lastname'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
            <?php $field = 'firstname'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middlename" value="<?= htmlspecialchars($old['middlename'] ?? '') ?>">
            <?php $field = 'middlename'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Пол</label>
            <select name="gender">
                <option value="М" <?= ($old['gender'] ?? '') == 'М' ? 'selected' : '' ?>>Мужской</option>
                <option value="Ж" <?= ($old['gender'] ?? '') == 'Ж' ? 'selected' : '' ?>>Женский</option>
            </select>
            <?php $field = 'gender'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birthdate" value="<?= htmlspecialchars($old['birthdate'] ?? '') ?>">
            <?php $field = 'birthdate'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" value="<?= htmlspecialchars($old['address'] ?? '') ?>">
            <?php $field = 'address'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <?php if ($isAdmin): ?>
            <input type="hidden" name="position_id" value="5">
            <div class="info-message"><strong>Должность:</strong> Сотрудник деканата (автоматически)</div>
        <?php elseif ($isDeaneryStaff): ?>
            <input type="hidden" name="position_id" value="6">
            <div class="info-message"><strong>Должность:</strong> Педагогический сотрудник (автоматически)</div>
        <?php endif; ?>

        <div class="form-group">
            <label>Кафедра</label>
            <select name="department_id">
                <option value="">— Без кафедры —</option>
                <?php foreach ($departments as $dep): ?>
                    <option value="<?= $dep->department_id ?>" <?= ($old['department_id'] ?? '') == $dep->department_id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dep->department_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php $field = 'department_id'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '') ?>">
            <?php $field = 'login'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password">
            <?php $field = 'password'; require __DIR__ . '/../parts/error.php'; ?>
        </div>

    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Добавить сотрудника</button>
        <a href="<?= app()->route->getUrl('/employees') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>