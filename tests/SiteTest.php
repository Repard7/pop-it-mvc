<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\Site;
use Model\User;

class SiteTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../..');
        
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
    public function testLogin($httpMethod, $userData, $message, $isRedirect = false)
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->any())
            ->method('all')
            ->willReturn($userData);
        $request->method = $httpMethod;
        
        $controller = new Site();
        $controller->login($request);
        
        if ($isRedirect) {
            $headers = headers_list();
            $found = false;
            foreach ($headers as $header) {
                if (strpos($header, 'Location:') === 0) {
                    $found = true;
                    $this->assertStringContainsString($message, $header);
                    break;
                }
            }
            $this->assertTrue($found, 'Location header not found');
        } else {
            $this->expectOutputRegex('/' . preg_quote($message, '/') . '/');
        }
    }

    public function additionProvider(): array
    {
        return [
            ['GET', ['login' => '', 'password' => ''], 'EduManager'],
            ['POST', ['login' => '', 'password' => ''], 'Логин обязателен'],   // исправлено
            ['POST', ['login' => 'wrong', 'password' => 'wrong'], 'Неправильные логин или пароль'],
        ];
    }
}