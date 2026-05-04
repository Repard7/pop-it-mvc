<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\DepartmentController;
use Model\Department;

class DepartmentTest extends TestCase
{
    protected function setUp(): void
    {
        $projectRoot = realpath(__DIR__ . '/..');;

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

    public function testAddDepartmentWithEmptyData()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = ['name' => '', 'code' => ''];
        $_REQUEST = $_POST;

        $request = new Request();

        ob_start();
        (new DepartmentController())->add($request);
        $result = ob_get_clean();

        $this->assertStringContainsString('Название кафедры обязательно для заполнения', $result);
        $this->assertStringContainsString('Код кафедры обязательно для заполнения', $result);
    }

    public function testAddDepartmentWithValidData()
    {
        $code = 'TEST';

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'Тестовая кафедра',
            'code' => $code
        ];
        $_REQUEST = $_POST;

        $request = new Request();

        ob_start();
        @(new DepartmentController())->add($request);
        ob_get_clean();

        $department = Department::where('code', $code)->first();
        $this->assertNotNull($department, "Кафедра с кодом '$code' не создалась");
        $this->assertEquals('Тестовая кафедра', $department->department_name);

        $department->delete();
    }
}