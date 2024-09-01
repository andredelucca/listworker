<?php

namespace tests\unit\models;

use Yii;
use app\models\LoginForm;
use app\models\User;
use Codeception\Test\Unit;

class LoginFormTest extends Unit
{
    private $tester;

    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginCorrect()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'testuser@example.com';
        $user->setPassword('testpassword');
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->status = 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        $loginForm = new LoginForm();
        $loginForm->username = 'testuser';
        $loginForm->password = 'testpassword';

        $this->assertTrue($loginForm->login(), 'Login failed for valid credentials.');
    }

    public function testLoginIncorrect()
    {
        $loginForm = new LoginForm();
        $loginForm->username = 'testuser';
        $loginForm->password = 'wrongpassword';

        $this->assertFalse($loginForm->login(), 'Login succeeded with invalid credentials.');
    }

}
