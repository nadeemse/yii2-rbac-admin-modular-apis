<?php
namespace common\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use OAuth2\Storage;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class OauthUser extends ActiveRecord implements IdentityInterface, \OAuth2\Storage\UserCredentialsInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    // Delete sub secure data from response
    public function fields()
    {
        $fields = parent::fields();

        return $fields;

        //return $fields;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%oauth_users}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */

    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var \filsh\yii2\oauth2server\Module $module */
        $module = Yii::$app->getModule('oauth2');
        $token  = $module->getServer()->getResourceController()->getToken();

        return !empty($token['user_id'])
            ? static::findIdentity($token['user_id'])
            : null;
    }

    /**
     * Finds user by username
     *
     * @param string $email email
     *
     * @return null|static
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function findByEmail($email)
    {
        return static::findOne(['username' => $email]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return null|static
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status'               => static::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * Override load function
     *
     * @param array $data     the data array. This is usually `$_POST` or `$_GET`, but can also be any valid array
     *                        supplied by the end user. supplied by the end user.
     * @param null  $formName the form name to be used for loading the data into the model.
     *                        If not set, [[formName()]] will be used.
     *
     *
     * @return boolean whether `$data` contained some data to populate the models attributes.
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function load($data, $formName = null)
    {
        parent::load($data, $formName);

        //password property will not be set in load(..) function
        if (is_array($data) && array_key_exists("password", $data)) {
            $passwordValue  = $data['password'];
            $this->password = $passwordValue;
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = yii::$app->security->generateRandomString();
    }


    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Grant access tokens for basic user credentials.
     *
     * Check the supplied username and password for validity.
     *
     * You can also use the $client_id param to do any checks required based
     * on a client, if you need that.
     *
     * Required for OAuth2::GRANT_TYPE_USER_CREDENTIALS.
     *
     * @param $username
     * Username to be check with.
     * @param $password
     * Password to be check with.
     *
     * @return
     * TRUE if the username and password are valid, and FALSE if it isn't.
     * Moreover, if the username and password are valid, and you want to
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.3
     *
     * @ingroup oauth2_section_4
     */

    public function checkUserCredentials($username, $password)
    {
        $user = static::findByEmail($username);
        if (empty($user)) {
            return false;
        }

        return $user->validatePassword($password);
    }

    /**
     * @return
     * ARRAY the associated "user_id" and optional "scope" values
     * This function MUST return FALSE if the requested user does not exist or is
     * invalid. "scope" is a space-separated list of restricted scopes.
     * @code
     * return array(
     *     "user_id"  => USER_ID,    // REQUIRED user_id to be stored with the authorization code or access token
     *     "scope"    => SCOPE       // OPTIONAL space-separated list of restricted scopes
     * );
     * @endcode
     */

    public function getUserDetails($username)
    {
        $user = static::findByEmail($username);

        return ['user_id' => $user->getId()];
    }
}
