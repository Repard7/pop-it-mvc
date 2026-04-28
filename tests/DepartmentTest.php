<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\DepartmentController;
use Model\Department;

class DepartmentTest extends TestCase
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

    public function testAddDepartmentWithEmptyData()
    {
        $_POST = ['name' => '', 'code' => ''];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $request = new Request();
        
        ob_start();
        (new DepartmentController())->add($request);
        $result = ob_get_clean();
        
        $this->assertStringContainsString('Добавление кафедры', $result);
        $this->assertStringContainsString('обязательно', $result);
    }

    public function testAddDepartmentWithValidData()
    {
        $code = 'TEST_CODE';
        
        Department::where('code', $code)->delete();
        
        $_POST = [
            'name' => 'Тестовая кафедра',
            'code' => $code
        ];
        $_REQUEST = $_POST;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $request = new Request();
        
        ob_start();
        (new DepartmentController())->add($request);
        ob_get_clean();
        
        $department = Department::where('code', $code)->first();
        
        $this->assertNotNull($department, "Кафедра с кодом '$code' не создалась");
        $this->assertEquals('Тестовая кафедра', $department->department_name);
        
        $department->delete();
    }
}