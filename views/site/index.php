<div style="text-align: center; padding: 60px 20px;">
    <h1>EduManager</h1>
    <p style="color: var(--gray-600); font-size: 18px; margin-top: 16px;">
        Система управления учебно-методическим процессом
    </p>
    <div style="display: flex; gap: 20px; justify-content: center; margin-top: 40px; flex-wrap: wrap;">
        <a href="<?= app()->route->getUrl('/employees') ?>" class="btn" style="background: var(--primary);">Сотрудники</a>
        <a href="<?= app()->route->getUrl('/departments') ?>" class="btn" style="background: var(--primary-light);">Кафедры</a>
        <a href="<?= app()->route->getUrl('/disciplines') ?>" class="btn" style="background: var(--primary-dark);">Дисциплины</a>
    </div>
</div>