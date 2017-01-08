<?php
namespace common\models;

use common\helpers\EmailHelper;
use yii\base\Model;

/**
 * Signup form
 * @property string $email
 * @property integer $amazing_offers
 * @property integer $occasional_updates
 * @property string $account_type
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property integer $gender
 * @property integer $country
 * @property string $socialType
 * @property string $socialID
 * @property string $picture;
 * @property string $phone_number;
 * @property string $company_name;
 * @property string $company_logo;
 * @property string $company_location;
 * @property string $company_contact;
 */

class SignupForm extends Model
{
    public $email;
    public $first_name;
    public $last_name;
    public $dob;
    public $account_type;
    public $country;
    public $gender;
    public $amazing_offers;
    public $occasional_updates;
    public $password;
    public $socialType;
    public $picture;
    public $phone_number;
    public $socialID;
    public $company_name;
    public $company_logo;
    public $company_location;
    public $company_contact;


    /**
     * SCENARIO
     * */
    const SCENARIO_SELF = 'self';
    const SCENARIO_FACEBOOK = 'facebook';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['email', 'first_name', 'phone_number'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],

            [['password', 'email'], 'required', 'on' => self::SCENARIO_SELF],

            [['socialType', 'socialID'], 'required', 'on' => self::SCENARIO_FACEBOOK],

            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Accounts', 'message' => 'This email address has already been taken.'],

            [['picture', 'phone_number', 'dob', 'country', 'gender', 'last_name', 'company_name', 'company_logo', 'company_location', 'company_contact'], 'safe'],

            [['amazing_offers', 'occasional_updates'], 'default', 'value' => 0],

            [['account_type'], 'default', 'value' => 'customer'],

            ['password', 'string', 'min' => 6],
        ];
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

        $user = new Accounts();

        $user->attributes = $this->attributes;
        $user->amazing_offers = ($this->amazing_offers ? 1 : 0);
        $user->occasional_updates = ($this->occasional_updates ? 1 : 0);
        $user->gender = ($this->gender == 'male' ? 1 : 0);
        $user->verification_code = \Yii::$app->security->generateRandomString() . '_' . time();

        if($this->scenario == self::SCENARIO_FACEBOOK) {
            $this->password = $this->socialID;
        }

        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if($user->save()) {

            // Send email to customer
            $this->sendEmail($user);

            return $user;
        } else {
            return null;
        }
    }

    /**
     * Send an email to user
     * */
    public function sendEmail($user) {

        (new EmailHelper() )->sendEmail($user->email, [], 'Welcome to Brrat!', 'account/signup', [ 'user' => $user]);
    }
}
