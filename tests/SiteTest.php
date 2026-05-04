<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\Site;
use Model\User;

class SiteTest extends TestCase
{
    protected function setUp(): void
    {
        $projectRoot = realpath(__DIR__ . '/..');

        $_SERVER['DOCUMENT_ROOT'] = $projectRoot;

        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app'  => include $projectRoot . '/config/app.php',
            'db'   => include $projectRoot . '/config/db.php',
            'path' => include $projectRoot . '/config/path.php',
        ]));

        if (!function_exists('app')) {
            function app() {
                return $GLOBALS['app'];
            }
        }
    }

    public function testLoginGet()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_POST = [];
        $_REQUEST = [];

        $request = new Request();
        ob_start();
        (new Site())->login($request);
        $result = ob_get_clean();

        $this->assertStringContainsString('EduManager', $result);
        $this->assertStringContainsString('Вход в систему управления', $result);
    }

    public function testLoginPostEmpty()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['login' => '', 'password' => ''];
        $_REQUEST = $_POST;

        $request = new Request();
        ob_start();
        (new Site())->login($request);
        $result = ob_get_clean();

        $this->assertStringContainsString('Логин обязателен', $result);
        $this->assertStringContainsString('Пароль обязателен', $result);
    }

    public function testLoginPostWrongCredentials()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['login' => 'wrong', 'password' => 'wrong'];
        $_REQUEST = $_POST;

        $request = new Request();
        ob_start();
        (new Site())->login($request);
        $result = ob_get_clean();

        $this->assertStringContainsString('Неправильные логин или пароль', $result);
    }

}