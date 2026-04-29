<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2>EduManager</h2>
            <p>Вход в систему управления</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="login-error"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!app()->auth::check()): ?>
            <form method="post" class="login-form" novalidate>
                <input type="hidden" name="csrf_token" value="<?= app()->auth::generateCSRF() ?>">

                <div class="form-group">
                    <label>Логин</label>
                    <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '') ?>" required autofocus>
                    <?php if (isset($errors['login'])): ?>
                        <div class="error-text" style="color: #dc3545; font-size: 13px; margin-top: 5px;">
                            <?= implode('<br>', $errors['login']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label>Пароль</label>
                    <input type="password" name="password" required>
                    <?php if (isset($errors['password'])): ?>
                        <div class="error-text" style="color: #dc3545; font-size: 13px; margin-top: 5px;">
                            <?= implode('<br>', $errors['password']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="login-btn">Войти</button>
            </form>
        <?php else: ?>
            <div class="login-error" style="background: rgba(52,168,83,0.1); color: #28a745; border-left-color: #28a745;">
                Вы уже авторизованы как <strong><?= htmlspecialchars(app()->auth::user()->login) ?></strong>
            </div>
            <div class="login-footer">
                <a href="<?= app()->route->getUrl('/') ?>">Перейти на главную →</a>
            </div>
        <?php endif; ?>
    </div>
</div>