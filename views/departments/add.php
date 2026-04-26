<h2>Добавление кафедры</h2>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error" style="background: rgba(234, 67, 53, 0.1); color: #EA4335; padding: 12px; border-radius: 8px; margin-bottom: 20px; border-left: 3px solid #EA4335;">
        <?php foreach ($errors as $field => $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
                <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post">
    <label>Название кафедры 
        <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" >
    </label>
    
    <label>Код кафедры 
        <input type="text" name="code" placeholder="Например: ПИ, ИС, КБ" value="<?= htmlspecialchars($old['code'] ?? '') ?>" >
    </label>

    <button>Добавить</button>
    <a href="<?= app()->route->getUrl('/departments') ?>">Отмена</a>
</form>