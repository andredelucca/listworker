<?php

namespace tests\unit\models;

use Yii;
use app\models\User;
use Codeception\Test\Unit;
use yii\base\InvalidConfigException;

class UserTest extends Unit
{
    protected $tester;

    protected function _before()
    {
        
    }

    protected function _after()
    {
        
    }

    public function testRules()
    {
        $user = new User();

        $this->assertFalse($user->validate());
        $this->assertArrayHasKey('username', $user->errors);
        $this->assertArrayHasKey('email', $user->errors);

        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password_hash = 'password_hash';
        $user->auth_key = 'auth_key';
        $user->access_token = 'access_token';
        $user->status = 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        $this->assertTrue($user->validate());
    }

    public function testSetPassword()
    {
        $user = new User();
        $password = 'testpassword';
        $user->setPassword($password);
        $this->assertNotEmpty($user->password_hash);
        $this->assertTrue(Yii::$app->security->validatePassword($password, $user->password_hash));
    }

    public function testFindByUsername()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password_hash = 'password_hash';
        $user->auth_key = 'auth_key';
        $user->access_token = 'access_token';
        $user->status = 1;
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        $foundUser = User::findByUsername('testuser');
        $this->assertNotNull($foundUser);
        $this->assertEquals('testuser', $foundUser->username);
    }

    public function testGenerateAuthKey()
    {
        $user = new User();
        $user->generateAuthKey();
        $this->assertNotEmpty($user->auth_key);
    }

    public function testGenerateAccessToken()
    {
        $user = new User();
        $user->generateAccessToken();
        $this->assertNotEmpty($user->access_token);
    }
}
