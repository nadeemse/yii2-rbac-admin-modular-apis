<?php
namespace api\core\components\web;

class JsonResponseFormatter extends \yii\web\JsonResponseFormatter
{
    /**
     * Formats response data in JSON format
     *
     * @param \yii\web\Response $response
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    protected function formatJson($response)
    {
        $response->getHeaders()->set('Content-Type', 'application/json; charset=UTF-8');
        if ($response->data !== null) {
            // Prevent escaping slashed or converting to unicode
            $response->content = json_encode($response->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
    }
}
