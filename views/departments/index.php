<h2>Кафедры</h2>

<div style="margin-bottom: 24px;">
    <?php if (app()->auth::user()->canCreateDepartment()): ?>
        <a href="<?= app()->route->getUrl('/departments/add') ?>" class="btn">Добавить кафедру</a>
    <?php endif; ?>
</div>

<?php if ($departments->count() > 0): ?>
    <div class="cards-grid">
        <?php foreach ($departments as $dep): ?>
            <div class="department-card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($dep->department_name) ?></h3>
                    <span class="card-code"><?= htmlspecialchars($dep->code) ?></span>
                </div>
                <div class="card-body">
                    <p>Дисциплин: <strong><?= $dep->disciplines->count() ?></strong></p>
                    <?php if ($dep->disciplines->count() > 0): ?>
                        <details>
                            <summary>Список дисциплин</summary>
                            <ul class="discipline-list">
                                <?php foreach ($dep->disciplines as $disc): ?>
                                    <li><?= htmlspecialchars($disc->discipline_name) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </details>
                    <?php endif; ?>
                </div>
                <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                    <div class="card-actions">
                        <a href="<?= app()->route->getUrl('/departments/edit?id=' . $dep->department_id) ?>" class="action-link">Редактировать</a>
                        <a href="<?= app()->route->getUrl('/departments/delete?id=' . $dep->department_id) ?>" class="action-link delete-link" onclick="return confirm('Удалить кафедру?')">Удалить</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-state">
        <p>Нет данных о кафедрах</p>
        <a href="<?= app()->route->getUrl('/departments/add') ?>" class="btn">Добавить первую кафедру</a>
    </div>
<?php endif; ?>