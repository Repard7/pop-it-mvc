<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\Site;
use Model\User;

class SiteTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = 'C:/xampp/htdocs';
        
        $GLOBALS['app'] = new Src\Application(new Src\Settings([
            'app' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/app.php',
            'db' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/db.php',
            'path' => include $_SERVER['DOCUMENT_ROOT'] . '/pop-it-mvc/config/path.php',
        ]));
        
        if (!function_exists('app')) {
            function app() {
                return $GLOBALS['app'];
            }
        }
    }

    /**
     * @dataProvider additionProvider
     * @runInSeparateProcess
     */
    public function testLogin($httpMethod, $userData, $message)
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;
        
        $result = (new Site())->login($request);
        
        if (!empty($result)) {
            $message = '/' . preg_quote($message, '/') . '/';
            $this->expectOutputRegex($message);
            return;
        }
        
        $this->assertContains($message, xdebug_get_headers());
    }

    public function additionProvider(): array
    {
        return [
            ['GET', [
                'login' => '',
                'password' => ''
            ], 'EduManager'],
            
            ['POST', [
                'login' => '',
                'password' => ''
            ], 'Поле login обязательно'],
            
            ['POST', [
                'login' => 'wrong',
                'password' => 'wrong'
            ], 'Неправильные логин или пароль'],
        ];
    }
}