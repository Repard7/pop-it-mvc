<h2>Список сотрудников</h2>

<div style="margin-bottom: 24px;">
    <?php if (app()->auth::user()->canCreateEmployee()): ?>
        <a href="<?= app()->route->getUrl('/employees/add') ?>" class="btn">Добавить сотрудника</a>
    <?php endif; ?>
</div>

<?php if ($employees->count() > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Логин</th>
                    <th>Должность</th>
                    <th>Кафедра</th>
                    <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                        <th>Действия</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $emp): ?>
                    <?php $user = $emp->users->first(); ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($emp->last_name) ?></strong> <?= htmlspecialchars($emp->first_name) ?> <?= htmlspecialchars($emp->patronymic) ?></td>
                        <td><?= htmlspecialchars($user->login ?? '-') ?></td>
                        <td>
                            <?php if ($user->position->position_name === 'Администратор'): ?>
                                <span class="badge-admin">Администратор</span>
                            <?php elseif ($user->position->position_name === 'Сотрудник деканата'): ?>
                                <span class="badge-deanery">Сотрудник деканата</span>
                            <?php else: ?>
                                <span class="badge-teaching">Педагогический сотрудник</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($user->department->department_name ?? '-') ?></td>
                        <?php if (app()->auth::user()->isDeaneryStaff()): ?>
                            <td class="actions">
                                <a href="<?= app()->route->getUrl('/employees/edit?id=' . $emp->employee_id) ?>" class="action-link">Редактировать</a>
                                <a href="<?= app()->route->getUrl('/employees/delete?id=' . $emp->employee_id) ?>" class="action-link delete-link" onclick="return confirm('Удалить сотрудника?')">Удалить</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="empty-state">
        <p>Нет данных о сотрудниках</p>
        <a href="<?= app()->route->getUrl('/employees/add') ?>" class="btn">Добавить первого сотрудника</a>
    </div>
<?php endif; ?>