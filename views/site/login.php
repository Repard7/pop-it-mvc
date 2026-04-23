<h2>Авторизация</h2>

<?php if (!empty($message)): ?>
    <h3 style="color: red;"><?= $message ?></h3>
<?php endif; ?>

<?php
if (!app()->auth::check()):
   ?>
   <form method="post">
       <label>Логин <input type="text" name="login"></label>
       <label>Пароль <input type="password" name="password"></label>
       <button>Войти</button>
   </form>
<?php endif;
