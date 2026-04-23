<h2>➕ Добавление сотрудника</h2>

<?php 
$currentUser = app()->auth::user();
$isAdmin = $currentUser->isAdmin();
$isDeaneryStaff = $currentUser->isDeaneryStaff();
?>

<form method="post">
    <label>Фамилия <input type="text" name="lastname" required></label>
    <label>Имя <input type="text" name="firstname" required></label>
    <label>Отчество <input type="text" name="middlename"></label>

    <label>Пол
        <select name="gender" required>
            <option value="М">Мужской</option>
            <option value="Ж">Женский</option>
        </select>
    </label>

    <label>Дата рождения <input type="date" name="birthdate" required></label>
    <label>Адрес <input type="text" name="address" required></label>
    
    <?php if ($isAdmin): ?>
        <!-- Админ создает сотрудника → должность "Сотрудник деканата" -->
        <input type="hidden" name="position_id" value="5">
        <div style="background: #e8f4f8; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #2196F3;">
            <strong>📌 Должность:</strong> Сотрудник деканата (назначается автоматически)
        </div>
        
    <?php elseif ($isDeaneryStaff): ?>
        <!-- Сотрудник деканата создает → должность "Педагогический сотрудник" -->
        <input type="hidden" name="position_id" value="6">
        <div style="background: #e8f4e8; padding: 10px; border-radius: 5px; margin: 10px 0; border-left: 4px solid #4CAF50;">
            <strong>📌 Должность:</strong> Педагогический сотрудник (назначается автоматически)
        </div>
        
    <?php else: ?>
        <!-- Для других ролей (если есть) - выбор из списка -->
        <label>Должность
            <select name="position_id" required>
                <option value="">— Выберите должность —</option>
                <?php foreach ($positions as $pos): ?>
                    <option value="<?= $pos->position_id ?>"><?= $pos->position_name ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    <?php endif; ?>

    <label>Кафедра
        <select name="department_id">
            <option value="">— Без кафедры —</option>
            <?php foreach ($departments as $dep): ?>
                <option value="<?= $dep->department_id ?>"><?= $dep->department_name ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <label>Логин <input type="text" name="login" required></label>
    <label>Пароль <input type="password" name="password" required></label>

    <button>Добавить</button>
    <a href="<?= app()->route->getUrl('/employees') ?>">Отмена</a>
</form>