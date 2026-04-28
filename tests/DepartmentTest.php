<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Controller\DepartmentController;
use Model\Department;

class DepartmentTest extends TestCase
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

    public function testAddDepartmentWithEmptyData()
    {
        $_POST = ['name' => '', 'code' => ''];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $request = new Request();
        
        ob_start();
        try {
            (new DepartmentController())->add($request);
        } catch (Exception $e) {
        }
        $result = ob_get_clean();
        
        $this->assertIsString($result);
        $this->assertStringContainsString('Добавление кафедры', $result);
        $this->assertStringContainsString('обязательно', $result);
    }

    public function testAddDepartmentWithValidData()
    {
        $uniqueCode = 'TEST_' . time();
        
        $_POST = [
            'name' => 'Тестовая кафедра',
            'code' => $uniqueCode
        ];
        $_REQUEST = $_POST;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        
        $request = new Request();
        
        ob_start();
        try {
            (new DepartmentController())->add($request);
        } catch (Exception $e) {
        }
        ob_get_clean();
        
        $department = Department::where('code', $uniqueCode)->first();
        
        $this->assertNotNull($department, "Кафедра с кодом '$uniqueCode' не создалась");
        $this->assertEquals('Тестовая кафедра', $department->department_name);
        
        if ($department) {
            $department->delete();
        }
    }
}