<?php

namespace common\helpers;

use yii;
use yii\helpers\ArrayHelper;

/**
 * Email Helper component is the class that will take care of all system emails
 * Like Order Confirmation, Reset Password, Forgot Password, Failed Order email ETC.
 *
 * Example by using emailHelper Component in common.php
 *
 * ~~~~
 * yii::$app->emailHelper->sendEmail($to, $cc, $subject, $template, $data)
 * ~~~~
 * @property string $to
 * @property array $cc
 * @property string $subject
 * @property string $template
 * @property mixed $data
 *
 * */
class EmailHelper
{

    public function sendEmail($to, $cc, $subject, $template, $data) {

        Yii::$app->mail->htmlLayout = "@common/mail/layouts/html";

        return Yii::$app->mail->compose(['html' => $template], ArrayHelper::merge( $data, ['title' => $subject] ) )
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setReplyTo( Yii::$app->params['adminEmail'] )
                ->setTo($to)
                ->setCc($cc)
                ->setSubject($subject)
                ->send();

    }

}