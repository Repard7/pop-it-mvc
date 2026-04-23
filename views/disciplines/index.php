<h2>📖 Список дисциплин</h2>

<?php if (app()->auth::user()->canCreateDiscipline()): ?>
    <a href="<?= app()->route->getUrl('/disciplines/add') ?>">Добавить дисциплину</a>
<?php endif; ?>

<?php if ($disciplines->count() > 0): ?>
    <table cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Кафедры</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disciplines as $disc): ?>
                <tr>
                    <td><?= $disc->discipline_id ?></td>
                    <td><?= $disc->discipline_name ?></td>
                    <td>
                        <?php foreach ($disc->departments as $dept): ?>
                            <?= $dept->department_name ?><br>
                        <?php endforeach; ?>
                    </td>
                    <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                        <td>
                            <a href="<?= app()->route->getUrl('/disciplines/edit?id=' . $disc->discipline_id) ?>">✏️</a>
                            <a href="<?= app()->route->getUrl('/disciplines/delete?id=' . $disc->discipline_id) ?>" onclick="return confirm('Удалить?')">❌</a>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет данных</p>
<?php endif; ?>