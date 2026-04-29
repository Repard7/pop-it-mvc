<?php if (isset($errors[$field])): ?>
    <div class="error-text" style="color: #dc3545; font-size: 13px; margin-top: 5px;">
        <?= implode('<br>', $errors[$field]) ?>
    </div>
<?php endif; ?>