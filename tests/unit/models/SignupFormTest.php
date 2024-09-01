<?php

namespace tests\unit\models;

use Yii;
use app\models\SignupForm;
use app\models\User;
use Codeception\Test\Unit;

/**
 * @group models
 */
class SignupFormTest extends Unit
{
    protected $tester;

    public function testSignupSuccess()
    {
        $signupForm = new SignupForm();
        $signupForm->username = 'newuser';
        $signupForm->password = 'newpassword';
        $signupForm->confirmPassword = 'newpassword';
        $signupForm->email = 'newuser@example.com';

        $user = $signupForm->signup();

        $this->assertNotNull($user, 'User should be created successfully.');
        $this->assertInstanceOf(User::class, $user, 'The created object should be an instance of User.');
        $this->assertTrue($user->validatePassword('newpassword'), 'The password should be valid.');
    }

    public function testSignupFailureDueToExistingUsername()
    {
        $existingUser = new User();
        $existingUser->username = 'existinguser';
        $existingUser->email = 'existinguser@example.com';
        $existingUser->setPassword('password');
        $existingUser->generateAuthKey();
        $existingUser->generateAccessToken();
        $existingUser->status = 1;
        $existingUser->created_at = date('Y-m-d H:i:s');
        $existingUser->updated_at = date('Y-m-d H:i:s');
        $existingUser->save();

        $signupForm = new SignupForm();
        $signupForm->username = 'existinguser';
        $signupForm->password = 'newpassword';
        $signupForm->confirmPassword = 'newpassword';
        $signupForm->email = 'newuser@example.com';

        $this->assertNull($signupForm->signup(), 'Signup should fail due to existing username.');
        $this->assertArrayHasKey('username', $signupForm->errors, 'Username error should be present.');
    }

    public function testSignupFailureDueToExistingEmail()
    {
        $existingUser = new User();
        $existingUser->username = 'anotheruser';
        $existingUser->email = 'existingemail@example.com';
        $existingUser->setPassword('password');
        $existingUser->generateAuthKey();
        $existingUser->generateAccessToken();
        $existingUser->status = 1;
        $existingUser->created_at = date('Y-m-d H:i:s');
        $existingUser->updated_at = date('Y-m-d H:i:s');
        $existingUser->save();

        $signupForm = new SignupForm();
        $signupForm->username = 'newuser';
        $signupForm->password = 'newpassword';
        $signupForm->confirmPassword = 'newpassword';
        $signupForm->email = 'existingemail@example.com';

        $this->assertNull($signupForm->signup(), 'Signup should fail due to existing email.');
        $this->assertArrayHasKey('email', $signupForm->errors, 'Email error should be present.');
    }

    public function testSignupFailureDueToMismatchedPasswords()
    {
        $signupForm = new SignupForm();
        $signupForm->username = 'newuser';
        $signupForm->password = 'password';
        $signupForm->confirmPassword = 'differentpassword';
        $signupForm->email = 'newuser@example.com';

        $this->assertNull($signupForm->signup(), 'Signup should fail due to mismatched passwords.');
        $this->assertArrayHasKey('confirmPassword', $signupForm->errors, 'Confirm Password error should be present.');
    }
}
