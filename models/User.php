<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id_user;
    public $username;
    public $email;
    public $password;
    public $authKey;
    public $accessToken;
    public $verification_code;

    public function rules()
    {
        return [
            [['id_user'], 'integer'],
            [['username', 'password', 'email', 'authKey', 'accessToken', 'verification_code'], 'safe'],
        ];
    }

    /* busca la identidad del usuario a través de su $id */

    public static function findIdentity($id_user)
    {       
        $user = \app\models\Users::find()
                ->where("id_user=:id", ["id" => $id_user])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }
    
    /* Busca la identidad del usuario a través de su token de acceso */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        
        $users = \app\models\Users::find()
                ->where("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
        
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }
        return null;
    }
    
    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($username)
    {
        $users = \app\models\Users::find()
                ->where("username=:username", [":username" => $username])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->username, $username) === 0) {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->id_user;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    
    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if (crypt($password, $this->password) == $this->password)
        {
        return $password === $password;
        }
    }
}
