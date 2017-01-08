<?php
namespace backend\controllers;

use Yii;

use yii\web\Controller;
use common\helpers\Utf8Helper;
use app\models\MediaManager;
use yii\helpers\ArrayHelper;

/**
 * BannerController implements the CRUD actions for Banners model.
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class FileManagerController extends Controller  {

    /**
     * Init function that will init the parent
     * @return null
     * */
    public function init() {
        parent::init();
    }

    /**
     * Index function that will calculate all Directories & images and return back to view
     * @return array of object
     * */
    public function actionIndex() {

        if (Yii::$app->request->get('filter_name')) {
            $filter_name = Yii::$app->request->get('filter_name');
        } else {
            $filter_name = null;
        }


        // Make sure we have the correct directory
        if (Yii::$app->request->get('directory')) {
            $directory = Yii::$app->request->get('directory');
        } else {
            $directory = null;
        }


        if (Yii::$app->request->get('page')) {
            $page = Yii::$app->request->get('page');
        } else {
            $page = 1;
        }

        $data['images'] = [];

        if ($directory != null) {
            $currentDir = $this->getFolder(['name' => $directory]);
            $directories = (isset($currentDir->folders) ? $currentDir->folders : []);
            $files = (isset($currentDir->files) ? $currentDir->files : []);
        } else {
            $directories = $this->getRootFoldersFiles('folder');
            $files = $this->getRootFoldersFiles('file');
        }


        if ($directories == null) {
            $directories = [];
        }

        // Get files
        //$files = glob($directory . '/' . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);


        if ($files == null) {
            $files = [];
        }

        // Merge directories and files
        $images = array_merge(ArrayHelper::toArray($directories), ArrayHelper::toArray($files));


        foreach ($images as $image) {
            if ($image['type'] == 'folder') {
                $url = [];

                if (Yii::$app->request->get('target')) {
                    $url['target'] = Yii::$app->request->get('target');
                }

                if (Yii::$app->request->get('thumb')) {
                    $url['thumb']  = Yii::$app->request->get('thumb');
                }

                $url['directory'] =  $image['name'];

                $route = Yii::$app->controller->route;
                $arrayParams = $url;
                $params = array_merge([$route], $arrayParams);
                $folderUrl = Yii::$app->urlManager->createUrl($params);

                $data['images'][] = [
                    'thumb' => '',
                    'name'  => $image['name'],
                    'type'  => 'directory',
                    'path'  => $image['name'],
                    'id'  => $image['id'],
                    'href'  => $folderUrl,
                ];
            } elseif ($image['type'] == 'file') {
                // Find which protocol to use to pass the full image link back
                $data['images'][] = [
                    'id'  => $image['id'],
                    'thumb' => $image['href'],
                    'name'  => $image['name'],
                    'type'  => 'image',
                    'path'  => $image['href'],
                    'href'  => $image['href']
                ];
            }
        }

        $data['heading_title'] = Yii::$app->params['heading_title'];

        $data['text_no_results'] = Yii::$app->params['text_no_results'];
        $data['text_confirm'] = Yii::$app->params['text_confirm'];

        $data['entry_search'] = Yii::$app->params['entry_search'];
        $data['entry_folder'] = Yii::$app->params['entry_folder'];

        $data['button_parent'] = Yii::$app->params['button_parent'];
        $data['button_refresh'] = Yii::$app->params['button_refresh'];
        $data['button_upload'] = Yii::$app->params['button_upload'];
        $data['button_folder'] = Yii::$app->params['button_folder'];
        $data['button_delete'] = Yii::$app->params['button_delete'];
        $data['button_search'] = Yii::$app->params['button_search'];

        if (Yii::$app->request->get('directory')) {
            $data['directory'] = urlencode(Yii::$app->request->get('directory'));
        } else {
            $data['directory'] = null;
        }

        if (Yii::$app->request->get('filter_name')) {
            $data['filter_name'] = Yii::$app->request->get('directory');
        } else {
            $data['filter_name'] = '';
        }

        // Return the target ID for the file manager to set the value
        if (Yii::$app->request->get('target')) {
            $data['target'] = Yii::$app->request->get('target');
        } else {
            $data['target'] = '';
        }

        // Return the thumbnail for the file manager to show a thumbnail
        if (Yii::$app->request->get('thumb')) {
            $data['thumb'] = Yii::$app->request->get('thumb');
        } else {
            $data['thumb'] = '';
        }

        // Parent
        $url = [];

        if (Yii::$app->request->get('directory')) {
            $url['directory'] = Yii::$app->request->get('directory');
        } else {
            $url['directory'] = null;
        }

        if (Yii::$app->request->get('target')) {
            $url['target'] = Yii::$app->request->get('target');
        }

        if (Yii::$app->request->get('thumb')) {
            $url['thumb']= Yii::$app->request->get('thumb') ;
        }

        $route = Yii::$app->controller->route;
        $arrayParams = $url;
        $params = array_merge([$route], $arrayParams);
        $folderUrl = Yii::$app->urlManager->createUrl($params);

        $data['refresh'] = $folderUrl;

        // One step Back Button
        if (isset($currentDir) && isset($currentDir->parent)) {
            $url['directory'] = $currentDir->parent->name;
        } else {
            $url['directory'] = null;
        }

        $route = Yii::$app->controller->route;
        $arrayParams = $url;
        $params = array_merge([$route], $arrayParams);
        $folderUrl = Yii::$app->urlManager->createUrl($params);

        $data['parent'] = $folderUrl;

        $data['pagination'] = [];

        return $this->renderPartial('file-manger', $data);
    }

    /**
     * Upload files
     * @return success | error message
     * */
    public function actionUpload() {

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
            } else {
                $json['error'] = Yii::$app->params['error_upload'];
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $json;
    }

    /**
     * Create a new folder function
     * This will create a new folder
     * @return array of folder & files from index function
     * */
    public function actionFolder() {

        $json = [];

        // Make sure we have the correct directory
        if (Yii::$app->request->get('directory')) {
            $directory = Yii::$app->request->get('directory');
        } else {
            $directory = '';
        }


        if (!$json) {
            // Sanitize the folder name
            $folder = str_replace(['../', '..\\', '..'], '', basename(html_entity_decode(Yii::$app->request->post('folder'), ENT_QUOTES, 'UTF-8')));

            // Validate the filename length
            if ((Utf8Helper::utf8_strlen($folder) < 3) || (Utf8Helper::utf8_strlen($folder) > 128)) {
                $json['error'] = Yii::$app->params['error_folder'];
            }

            if ($directory) {
                $rootDir = $this->getFolder(['name' => $directory]);
                $currentFolder = $this->getFolder(['parent_id' => $rootDir->id, 'name' => $folder]);
                $parent_id = $rootDir->id;
                $path = $rootDir->path.'/'.$folder;
            } else {
                $currentFolder = $this->getFolder(['parent_id' => 0, 'name' => $folder]);
                $parent_id = 0;
                $path = $folder;
            }

            // Check if directory already exists or not
            if (!empty($currentFolder)) {
                $json['error'] = Yii::$app->params['error_exists'];
            }
        }

        if (!$json) {
            // Save Data into Database
            $data = ['name' => $folder, 'parent_id' => $parent_id, 'type' => 'folder', 'path' => $path];
            $this->saveObject($data);

            $json['success'] = Yii::$app->params['text_directory'];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $json;
    }

    /**
     * Delete file from folder
     * @return success | Error
     *
     * */
    public function actionDelete() {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $json = [];

        if (Yii::$app->request->post('path')) {
            $paths = Yii::$app->request->post('path');
        } else {
            $paths = [];
        }


        if (!$json) {
            // Loop through each path
            foreach ($paths as $path) {
                $mediaObject = MediaManager::findOne($path);

                /**
                 * If path is just a file delete it also delete it from AWS
                 * */
                if ($mediaObject->type == 'file') {
                    Yii::$app->get('s3bucket')->delete($mediaObject->path);
                    $fileObj = $mediaObject->delete();

                    if (!$fileObj) {
                        return $fileObj->getErrors();
                    }
                } elseif ($mediaObject->type == 'folder') {
                    Yii::$app->get('s3bucket')->delete($mediaObject->path);
                    $mediaObject->deleteRecursive(['files', 'folders']);
                }
            }

            $json['success'] = Yii::$app->params['text_delete'];
        }

        return $json;
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
     * Get All Folders
     * @param string $type this is string that will used to conditionlized
     * @return mixed of folder & files
     * */
    public function getRootFoldersFiles($type) {

        $folderInfo = null;

        if ($type == 'folder') {
            $folderInfo = MediaManager::find()->where(['type' => 'folder', 'parent_id' => '0'])->all();
        } elseif ($type == 'file') {
            $folderInfo = MediaManager::find()->where(['type' => 'file', 'parent_id' => '0'])->all();
        }

        return $folderInfo;
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
