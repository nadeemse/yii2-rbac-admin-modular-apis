<?php
namespace api\core\components\web;

/**
 * Response formatter for represent data in tag <pre>
 *
 * It is used by [[Response]] to format response data.
 *
 */
class HtmlResponseFormatter extends \yii\web\HtmlResponseFormatter
{
    /**
     * Formats the specified response.
     *
     * @param \yii\web\Response $response the response to be formatted.
     */
    public function format($response)
    {
        parent::format($response);
        if (!is_string($response->content)) {
            $response->content =
                "<PRE>"
                . var_export($response->content, true)
                . "</PRE>";
        }
    }
}
