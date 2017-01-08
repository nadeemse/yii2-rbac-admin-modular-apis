<?php

namespace api\config;

/**
 * API rest routes
 * This class will read all _routes from api/modules folder and make yii routes configuration
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
if (!class_exists('api\config\RestRoutes')) {

    class RestRoutes
    {
        const INHERIT = 'inherit-from';

        // Generate all Routes
        public function generateAllRestRoutes()
        {
            $filesGlob = glob(__DIR__ . '/../*/*/config/_routes.php');

            $restUrls        = [];
            $restUrlsVersion = [];
            $restVersionUrls = [];
            $restFileData    = [];

            foreach ($filesGlob as $routeFile) {
                $restFileData += require($routeFile);
            }


            // inhertied from with no child make them like parents
            foreach ($restFileData as $aGroup => $aVersion) {
                foreach ($aVersion as $aVersionKey => $aRoute) {

                    if (!empty($aRoute[static::INHERIT]) && count($aRoute) == 1) {
                        $inheritFromVersion                  = $aRoute[static::INHERIT];
                        $data                                = $restFileData[$aGroup][$inheritFromVersion];
                        $restFileData[$aGroup][$aVersionKey] = $data;
                    }
                }
            }


            $restData = $restFileData;
            // Rest Router Generator
            foreach ($restData as $group => $prefixUrl) {
                // sort to merge the address
                ksort($prefixUrl);
                // prefix based on version
                foreach ($prefixUrl as $prefixRoute => $url) {
                    foreach ($url as $urlRoute) {
                        if (!isset($urlRoute['controller'])) {
                            continue;
                        }
                        $prefix = $prefixRoute;
                        // we need key as controller for inheritance
                        $restVersionUrls[$group][$prefix][$urlRoute['controller']] = $urlRoute;
                    }
                }
            }


            // inheritance
            foreach ($restVersionUrls as $group => $moduleVersion) {
                foreach ($moduleVersion as $version => $routes) {
                    // inherit
                    if (!empty($restData[$group][$version][static::INHERIT])) {
                        $inheritFrom      = $restData[$group][$version][static::INHERIT];
                        $inheritFromArray = $restVersionUrls[$group][$inheritFrom];
                        $groupRoutes      = \api\core\helpers\ArrayHelper::arrayMergeRecursiveDistinct($inheritFromArray, $routes);
                    } else {
                        // non inherited routes
                        $groupRoutes = $routes;
                    }
                    // all routes
                    $restVersionUrls[$group][$version] = $groupRoutes;
                    // get last version of every route to determine namespace of the controller
                    foreach ($routes as $routeRow) {

                        // if class exist add it as version
                        $controller = $routeRow['controller'];
                        $class      = $group . '\\' . str_replace('.', '_', $version) . '\\controllers\\' . ucwords($controller) . 'Controller';

                        $classExist = class_exists($class);
                        $restUrlsVersion[$group . '/' . $controller][] = $version;

                        /*if ($classExist) {
                            echo $class.' - Exist - <br/>';
                            $restUrlsVersion[$group . '/' . $controller][] = $version;
                        } else {
                            echo $class.' - Not Exist - <br/>';
                        }*/

                    }

                }
            }


            // generate route from all route array
            foreach ($restVersionUrls as $group => $versionGroup) {
                foreach ($versionGroup as $version => $restUrlArr) {
                    foreach ($restUrlArr as $urlData) {
                        // with versions
                        list($routeKey, $routeData) = $this->getRouteArray($version, $group, $urlData);
                        $restUrls[] = $routeData;
                    }
                }
            }

            return [$restUrls, $restUrlsVersion];
        }

       /**
        * Get Rest Routes Array
        * */
        public function getRouteArray($prefix, $group, $urlRoute)
        {
            $route = [
                'class'      => 'api\core\components\rest\RestUrlRule',
                'prefix'     => $prefix,
                'controller' => $group . '/' . $urlRoute['controller'],
            ];
            if (!empty($urlRoute['extraPatterns'])) {
                $route['extraPatterns'] = $urlRoute['extraPatterns'];
            }
            $routeKey = join('-', [$prefix, $route['controller']]);

            return [$routeKey, $route];
        }
    }
}

$configRoute = new RestRoutes();

list($restUrls, $restUrlsVersion) = $configRoute->generateAllRestRoutes();

return [$restUrls, $restUrlsVersion];
