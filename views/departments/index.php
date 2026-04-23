<h2>Список кафедр</h2>

<?php if (app()->auth::user()->canCreateDepartment()): ?>
    <a href="<?= app()->route->getUrl('/departments/add') ?>">Добавить кафедру</a>
<?php endif; ?>

<?php if ($departments->count() > 0): ?>
    <ul>
        <?php foreach ($departments as $dep): ?>
            <li>
                <?= $dep->department_name ?>
                (<?= $dep->disciplines->count() ?> дисциплин)
                <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                    <a href="<?= app()->route->getUrl('/departments/edit?id=' . $dep->department_id) ?>">✏️</a>
                    <a href="<?= app()->route->getUrl('/departments/delete?id=' . $dep->department_id) ?>" onclick="return confirm('Удалить?')">❌</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Нет данных</p>
<?php endif; ?>