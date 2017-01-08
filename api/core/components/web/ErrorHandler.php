<?php

namespace api\core\components\web;

class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * Support format in response
     *
     * @inheritdoc
     *
     * @param \Exception $exception
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    protected function renderException($exception)
    {
        if (\Yii::$app->has('response')) {
            $response         = \Yii::$app->getResponse();
            $response->isSent = false;
        } else {
            $response = new Response();
        }

        $content_neg           = new \yii\filters\ContentNegotiator();
        $content_neg->response = $response;
        $content_neg->formats  = \Yii::$app->params['formats'];
        $content_neg->negotiate();

        parent::renderException($exception);
    }
}
