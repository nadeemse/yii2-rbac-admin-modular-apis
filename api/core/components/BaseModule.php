<?php

namespace api\core\components;

use api\core\components\web\Request;
use yii\base\InvalidCallException;

class BaseModule extends \yii\base\Module
{
    /**
     * @var string
     */
    public $defaultRoute = 'index';

    /**
     * @inheritdoc
     *
     * @return void
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function init()
    {
        /** @var Request $request */
        $request = \Yii::$app->getRequest();


        $versionNamespace = $this->getLastControllerVersion();
        $request->setNsVersion($request->namespaceToVersion($versionNamespace));

        $this->controllerNamespace = 'api\\modules\\'.$this->id  . $versionNamespace . 'controllers';

        /*if (!$this->excludeAppId()) {
            $this->AppId();
        }*/
        parent::init();
    }

    /**
     * Checks whether an IP address exists in a given array of IP addresses
     *
     * @param string $ip ip
     *
     * @return bool
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function isAllowedIp($ip)
    {
        $allowedIps = [
            '127.0.0.1',
            '192.168.1.*',
            '52.77.206.75',
            '::1',
        ];

        foreach ($allowedIps as $allowedIp) {
            if (strpos($allowedIp, '*')) {
                $range = [
                    str_replace('*', '0', $allowedIp),
                    str_replace('*', '255', $allowedIp),
                ];
                if ($this->ipExistInRange($range, $ip)) {
                    return true;
                }
            } else if (strpos($allowedIp, '-')) {
                $range = explode('-', str_replace(' ', '', $allowedIp));
                if ($this->ipExistInRange($range, $ip)) {
                    return true;
                }
            } else {
                if (ip2long($allowedIp) === ip2long($ip)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Checks whether an IP address exists within a range of IP addresses
     *
     * @param array  $range range
     * @param string $ip    ip
     *
     * @return bool
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function ipExistInRange(array $range, $ip)
    {
        if (ip2long($ip) >= ip2long($range[0]) && ip2long($ip) <= ip2long($range[1])) {
            return true;
        }

        return false;
    }

    /**
     * DESC
     *
     * @return bool
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function excludeAppId()
    {
        $ipAllowed = $this->isAllowedIp(\Yii::$app->getRequest()->getUserIP());
        return $ipAllowed;
    }

    /**
     * DESC
     *
     * @return null
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function AppId()
    {
        /** @var Request $request */
        $request = \Yii::$app->getRequest();
        $request->setAppId($request->headers[Request::X_APP_ID]);

        if (!$request->getAppId()) {
            throw new InvalidCallException('You are not allowed to perform this action');
        }

        return $request->getAppId();
    }

    public function getLastControllerVersion()
    {
        $app           = \Yii::$app;
        $routesVersion = $app->components['urlManager']['routesVersion'];

        /** @var Request $request */
        $request  = $app->getRequest();
        $namSpace = $request->getNameSpace(true);

        $match    = '';
        // no match return
        if (!$namSpace) {
            return $match;
        }

        //$restRoutesVersion['user/scope'][0]

        $xPathInfo     = $request->xPathInfo;
        $pathInfoArray = explode('/', $xPathInfo);

        list($module, $controller,) = $pathInfoArray;
        // method from custom route or REST method from the request
        $method = isset($pathInfoArray[2]) ? $pathInfoArray[2] : $request->getMethod();


        $route = join('/', [$module, $controller]);

        // get version of the router if it match otherwise return last version known
        if (!empty($routesVersion[$route])) {

            $match = array_intersect($routesVersion[$route], [$namSpace]);

            if (!isset($match[0])) {
                $match = end($routesVersion[$route]);
            } else {
                $match = $match[0];
            }

            $match = $request->versionToNameSpace($match);

        }

        return $match;
    }
}
