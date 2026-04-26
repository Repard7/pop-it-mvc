<h2>Дисциплины</h2>

<div style="margin-bottom: 24px;">
    <?php if (app()->auth::user()->canCreateDiscipline()): ?>
        <a href="<?= app()->route->getUrl('/disciplines/add') ?>" class="btn">Добавить дисциплину</a>
    <?php endif; ?>
</div>

<?php if ($disciplines->count() > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Часы</th>
                    <th>Семестр</th>
                    <th>Кафедры</th>
                    <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                        <th>Действия</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($disciplines as $disc): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($disc->discipline_name) ?></strong></td>
                        <td><?= $disc->hours ?> ч.</td>
                        <td><?= $disc->semester ?> семестр</td>
                        <td>
                            <?php if ($disc->departments->count() > 0): ?>
                                <?php foreach ($disc->departments as $dept): ?>
                                    <span class="badge-department"><?= htmlspecialchars($dept->department_name) ?></span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                            <td class="actions">
                                <a href="<?= app()->route->getUrl('/disciplines/edit?id=' . $disc->discipline_id) ?>" class="action-link">Редактировать</a>
                                <a href="<?= app()->route->getUrl('/disciplines/delete?id=' . $disc->discipline_id) ?>" class="action-link delete-link" onclick="return confirm('Удалить дисциплину?')">Удалить</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <p>Нет данных о дисциплинах</p>
        <a href="<?= app()->route->getUrl('/disciplines/add') ?>" class="btn">Добавить первую дисциплину</a>
    </div>
<?php endif; ?>