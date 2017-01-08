<?php

namespace api\core\components\web;

class Response extends \yii\web\Response
{
    /**
     * @param array $config configuration
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->headers[Request::X_REQUEST_ID]   = \Yii::$app->request->headers[Request::X_REQUEST_ID];
        $this->headers[Request::X_REQUEST_TIME] = \Yii::$app->request->headers[Request::X_REQUEST_TIME];
        $this->headers[Request::X_API_VERSION]  = \Yii::$app->request->headers[Request::X_API_VERSION];
    }

    /**
     * Content Negotiation
     *
     * @param \yii\base\Event $event yii event
     *
     * @return void
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function negotiateContentBeforeSend(\yii\base\Event $event)
    {
        /** @var \yii\web\Response $response */
        $response = $event->sender;

        $content_neg           = new \yii\filters\ContentNegotiator();
        $content_neg->response = $response;
        $content_neg->formats  = \Yii::$app->params['formats'];
        $content_neg->negotiate();
        //}
        if ($response->data !== null
            && \Yii::$app->request->get('suppress_response_code')
        ) {
            $response->data       = [
                'success' => $response->isSuccessful,
                'data'    => $response->data,
            ];
            $response->statusCode = 200;
        }
        if ($response->data && is_array($response->data) && isset($response->data['type'])) {
            $response->data['type'] = str_ireplace('yii\\', '', $response->data['type']);
        }
    }
}
