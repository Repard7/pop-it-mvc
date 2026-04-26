<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>EduManager</h2>
            <p>Вход в систему управления</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="login-error">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <?php if (!app()->auth::check()): ?>
            <form method="post" class="login-form" novalidate>
                <div class="form-group">
                    <label>Логин</label>
                    <input type="text" name="login" placeholder="Введите ваш логин" value="<?= htmlspecialchars($old['login'] ?? '') ?>" required autofocus>
                </div>
                
                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" placeholder="Введите пароль" required>
                </div>
                
                <button type="submit" class="login-btn">Войти</button>
            </form>
        <?php else: ?>
            <div class="login-error" style="background: rgba(52, 168, 83, 0.1); color: var(--success); border-left-color: var(--success);">
                Вы уже авторизованы как <strong><?= htmlspecialchars(app()->auth::user()->login) ?></strong>
            </div>
            <div class="login-footer">
                <a href="<?= app()->route->getUrl('/') ?>">Перейти на главную →</a>
            </div>
        <?php endif; ?>
    </div>
</div>