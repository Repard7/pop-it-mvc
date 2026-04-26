<h2>Добавление сотрудника</h2>

<?php 
$currentUser = app()->auth::user();
$isAdmin = $currentUser->isAdmin();
$isDeaneryStaff = $currentUser->isDeaneryStaff();
?>

<form method="post">
    <div class="form-grid">
        <div class="form-group">
            <label>Фамилия</label>
            <input type="text" name="lastname" required>
        </div>
        
        <div class="form-group">
            <label>Имя</label>
            <input type="text" name="firstname" required>
        </div>
        
        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="middlename">
        </div>

        <div class="form-group">
            <label>Пол</label>
            <select name="gender" required>
                <option value="М">Мужской</option>
                <option value="Ж">Женский</option>
            </select>
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birthdate" required>
        </div>
        
        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" required>
        </div>

        <?php if ($isAdmin): ?>
            <input type="hidden" name="position_id" value="5">
            <div class="info-message">
                <strong>Должность:</strong> Сотрудник деканата (назначается автоматически)
            </div>
            
        <?php elseif ($isDeaneryStaff): ?>
            <input type="hidden" name="position_id" value="6">
            <div class="info-message">
                <strong>Должность:</strong> Педагогический сотрудник (назначается автоматически)
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Кафедра</label>
            <select name="department_id">
                <option value="">— Без кафедры —</option>
                <?php foreach ($departments as $dep): ?>
                    <option value="<?= $dep->department_id ?>"><?= htmlspecialchars($dep->department_name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Логин</label>
            <input type="text" name="login" required>
        </div>
        
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" required>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">Добавить сотрудника</button>
        <a href="<?= app()->route->getUrl('/employees') ?>" class="btn-secondary">Отмена</a>
    </div>
</form>