<?php

namespace Controller;

use Model\Post;
use Model\User;

use Src\View;
use Src\Auth\Auth;
use Src\Request;

use Validation\Validator;
use Validation\Validators\RequireValidator;

class Site
{
    /*
    public function index(Request $request): string
    {
        $id = $request->get('id');
        $posts = Post::where('id', $id)->get();
        return (new View())->render('site.post', ['posts' => $posts]);
    }
   
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'hello working']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/go');
        }
        return new View('site.signup');
    }
    */

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        
        $validator = new Validator($request->all(), [
            'login' => ['required'],
            'password' => ['required']
        ], [
            'required' => 'Поле :field обязательно для заполнения'
        ], [
            'required' => RequireValidator::class
        ]);
        
        if ($validator->fails()) {
            $errorMessages = [];
            foreach ($validator->errors() as $field => $messages) {
                $fieldName = ($field === 'login') ? 'Логин' : 'Пароль';
                $errorMessages[] = $fieldName . ': ' . implode(', ', $messages);
            }
            
            return new View('site.login', [
                'message' => implode('<br>', $errorMessages)
            ]);
        }
        
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }
        
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    public function index(): string
    {
        return new View('site.index');
    }


}
