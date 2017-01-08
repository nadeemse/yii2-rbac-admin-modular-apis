<?php
namespace api\core\components\web;

use yii\base\Arrayable;
use yii\helpers\ArrayHelper;
use yii\rest\Serializer;

class RestSerializer extends Serializer
{
    /**
     * Serializes a set of models
     *
     * @param array $models
     *
     * @return array
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    protected function serializeModels(array $models)
    {
        list ($fields, $expand) = $this->getRequestedFields();

        foreach ($models as $i => $model) {
            if ($model instanceof Arrayable) {
                $models[$i] = $model->toArray($fields, $expand);
            } elseif (is_array($model)) {
                $models[$i] = ArrayHelper::toArray($model, [], true, $expand);
            }

            /*if (!empty($model) && method_exists($model, 'transformData')) {
                $models[$i] = call_user_func(get_class($model) . '::transformData', $models[$i]);
            }*/
        }

        return $models;
    }

    /**
     * Adds HTTP headers about the pagination to the response.
     *
     * @param \yii\data\Pagination $pagination
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    protected function addPaginationHeaders($pagination)
    {
        $links = [];
        foreach ($pagination->getLinks(false) as $rel => $url) {
            $url     = preg_replace('#\/.*\/.*\/#iU', '/', $url);
            $links[] = "<$url>; rel=$rel";
        }

        $this->response->getHeaders()
                       ->set($this->totalCountHeader, $pagination->totalCount)
                       ->set($this->pageCountHeader, $pagination->getPageCount())
                       ->set($this->currentPageHeader, $pagination->getPage() + 1)
                       ->set($this->perPageHeader, $pagination->pageSize)
                       ->set('Link', implode(', ', $links));
    }
}
