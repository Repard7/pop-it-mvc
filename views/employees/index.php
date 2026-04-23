<h2>Список сотрудников</h2>

<?php if (app()->auth::user()->canCreateEmployee()): ?>
    <a href="<?= app()->route->getUrl('/employees/add') ?>">➕ Добавить сотрудника</a>
<?php endif; ?>

<?php if ($employees->count() > 0): ?>
    <table cellpadding="8">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Логин</th>
                <th>Должность</th>
                <th>Кафедра</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $emp): ?>
                <?php $user = $emp->users->first(); ?>
                <tr>
                    <td><?= $emp->last_name ?> <?= $emp->first_name ?> <?= $emp->patronymic ?></td>
                    <td><?= $user->login ?? '-' ?></td>
                    <td><?= $user->position->position_name ?? '-' ?></td>
                    <td><?= $user->department->department_name ?? '-' ?></td>
                    <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                        <td>
                            <a href="<?= app()->route->getUrl('/employees/edit?id=' . $emp->employee_id) ?>">✏️</a>
                            <a href="<?= app()->route->getUrl('/employees/delete?id=' . $emp->employee_id) ?>" onclick="return confirm('Удалить?')">❌</a>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет данных</p>
<?php endif; ?>