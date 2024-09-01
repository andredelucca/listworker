<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property int $status
 * @property int $created_at
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $confirmPassword;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'confirmPassword', 'email'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords must match'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
            'confirmPassword' => 'Confirm Password',
            'email' => 'Email',
        ];
    }

    /**
     * Validates the username.
     *
     * @param string $attribute the attribute being validated
     */
    public function validateUsername($attribute)
    {
        if (User::findByUsername($this->$attribute)) {
            $this->addError($attribute, 'This username is already taken.');
        }
    }

    /**
     * Validates the email.
     *
     * @param string $attribute the attribute being validated
     */
    public function validateEmail($attribute)
    {
        if (User::findOne(['email' => $this->$attribute])) {
            $this->addError($attribute, 'This email address is already taken.');
        }
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->created_at = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->status = 1;

        return $user->save() ? $user : null;
    }
}
