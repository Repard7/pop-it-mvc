<?php
return [
   'auth' => \Src\Auth\Auth::class,
   'identity'=>\Model\User::class,
   'routeMiddleware' => [
       'auth' => \Middlewares\AuthMiddleware::class,
   ],
   'routeAppMiddleware' => [
        'trim' =>  \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'csrf' => \Middlewares\CSRFMiddleware::class,
   ],
];
