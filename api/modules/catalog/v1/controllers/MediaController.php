<?php

namespace api\modules\catalog\v1\controllers;

use Yii;
use api\core\components\exception\RestException;
use api\core\controllers\BaseRestController;
use api\modules\catalog\v1\models\MediaManager;
use common\helpers\Utf8Helper;
use yii\web\NotFoundHttpException;
use api\modules\catalog\v1\models\Items;

/**
 * Media controller that will use BaseRestController and default yii2 Rest APIS
 *  This is used to manage AWS files upload and delete files from local and from live as well.
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class MediaController extends BaseRestController
{
    public $modelClass = 'api\modules\catalog\v1\models\MediaManager';

    /**
     * Access Control function is used to handle application scope,
     * Either an application allowed to access a resources or not.
     * For example you have two different applicaiton one can access some resources and one can't so -
     * you can achieve that by simply defining
     * into access control.
     *
     * @return array
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     */
    public function accessControls()
    {
        return [
            //Assigning scopes and permissions regarding yii\rest\ActiveController core methods
            [
                'allow'   => true,
                'actions' => ['view', 'create'],
                'roles'   => ['@'],
                'scopes'  => ['catalog', 'root'],
            ],

            [
                'allow'   => true,
                'actions' => ['options'],
                'roles'   => ['?'],
            ],
        ];
    }

    /**
     * Actions
     * */
    public function actions() {
        $actions = parent::actions();
        unset($actions['view'], $actions['create']);
        return $actions;
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /**
     * Upload files
     * @return boolean
     * */
    public function actionCreate() {

        $json = [];
        // Make sure we have the correct directory
        if (Yii::$app->request->get('directory')) {
            $directory = Yii::$app->request->get('directory');
            $currentDir = $this->getFolder(['name' => $directory]);
            $parent_id = $currentDir->id;
            $path = $currentDir->path;
        } else {
            $directory = null;
            $parent_id = 0;
            $path = '';
        }


        if (!$json) {
            $file = \yii\web\UploadedFile::getInstanceByName('file');

            if (!empty($file->name)) {
                // Sanitize the filename
                $filename = basename(html_entity_decode($file->name, ENT_QUOTES, 'UTF-8'));
                $extension = $file->extension;
                $name = $file->baseName;

                // Validate the filename length
                if ((Utf8Helper::utf8_strlen($filename) < 3) || (Utf8Helper::utf8_strlen($filename) > 255)) {
                    $json['error'] = Yii::$app->params['error_filename'];
                }

                // Allowed file extension types
                $allowed = [
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                ];

                if (!in_array(Utf8Helper::utf8_strtolower(Utf8Helper::utf8_substr(strrchr($filename, '.'), 1)), $allowed)) {
                    $json['error'] = Yii::$app->params['error_filetype'];
                }

                // Allowed file mime types
                $allowed = [
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif'
                ];

                if (!in_array($file->type, $allowed)) {
                    $json['error'] = Yii::$app->params['error_filetype'];
                }

                // Return any upload error
                if ($file->error != UPLOAD_ERR_OK) {
                    $json['error'] = Yii::$app->params['error_upload' . $file->error];
                }
            } else {
                $json['error'] = Yii::$app->params['error_upload'];
            }
        }

        if (!$json) {
            $uniqueName = trim(( str_replace(' ', '', $name).uniqid() ));

            $randomName = $string = preg_replace('/\s+/', '', $uniqueName).'.'.$extension;

            $uploadObject = Yii::$app->get('s3bucket')->upload($path.'/'.$randomName, $file->tempName);

            if ($uploadObject) {
                $url = Yii::$app->get('s3bucket')->getUrl($path.'/'.$randomName);

                // Save Data into Database
                $data = ['name' => $file->name, 'parent_id' => $parent_id, 'type' => 'file', 'href' => $url, 'path' => ($path.'/'.$randomName) ];
                $this->saveObject($data);

                $json['success'] = Yii::$app->params['text_uploaded'];
                $json = $data;

            } else {
                return RestException::dataValidationFailed(422, Yii::$app->params['error_upload'], 422);
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $json;
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Items::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Get All Folders
     * @param mixed $condition this is the array with attributes & value
     * @return mixed of folder & files
     * */
    public function getFolder($condition) {

        if (!empty($condition)) {
            $folderInfo = MediaManager::find()->with('files', 'folders')->where($condition)->one();

            if ($folderInfo !== null) {
                return $folderInfo;
            }
        }

        return [];
    }

    /**
     * Save Object Onformaiton
     * @param array $data of object
     * @return boolean tru or false
     * */
    public function saveObject($data) {

        $folderObj = new MediaManager();
        $folderObj->attributes = $data;
        $folderObj->created_at = Yii::$app->dateTime->getTime();

        return $folderObj->save();
    }
}
