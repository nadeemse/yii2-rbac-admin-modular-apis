<?php
namespace api\core\components\web;

use Ramsey\Uuid\Uuid;

class Request extends \yii\web\Request
{
    /**
     * Application headers
     */
    const X_REQUEST_ID   = 'x-request-id';
    const X_REQUEST_TIME = 'x-request-time';
    const X_API_VERSION  = 'x-api-version';
    const X_API_NS       = 'x-api-ns';
    const X_NS_VERSION   = 'x-ns-version';

    /**
     * Regex match url /v1/...
     */
    const URL_VERSION_PATTERN = '#^(\/v(\d)\/)(\w+)#i';
    /**
     * Regex match v1 header
     */
    const HEADER_VERSION_PATTERN = '#^v\d$#i';
    const XPATH_VERSION_PATTERN  = '#^v\d\/#i';

    // Client Headers
    const C_API_VERSION = 'app-version';
    const C_API_TZ = 'app-tz';
    const C_API_LOCALE = 'app-locale';

    /**
     * Required for application grouping ( iphone, andriod, web etc.. )
     */
    const X_APP_ID = 'app-id';

    public $versionInHeader = false;
    public $xPathInfo       = '';
    public $AppId           = null;

    /**
     * Set Unique request ID and request time
     * @param array $config configuration
     */
    public function __construct($config = [])
    {
        $now                                   = date('Y-m-d\TH:i:s') . substr(microtime(), 1, 9);
        $uuid4                                 = Uuid::uuid4();
        $this->headers[static::X_REQUEST_ID]   = $uuid4->toString();
        $this->headers[static::X_REQUEST_TIME] = $now;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    protected function resolveRequestUri()
    {
        $requestUri = parent::resolveRequestUri();
        return $requestUri;
    }

    /**
     * DESC
     *
     * @param $AppId
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function setAppId($AppId)
    {
        $this->AppId = $AppId;
    }

    /**
     * DESC
     *
     * @return null
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getAppId()
    {
        return $this->AppId;
    }

    /**
     * DESC
     *
     * @return array
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function parseApiVersionHeader()
    {
        $requestApiVersion = $this->getRequestApiVersion();

        preg_match(static::HEADER_VERSION_PATTERN, $requestApiVersion, $versionArr);

        // Module and version
        $apiVersion = !empty($versionArr[0]) ? $versionArr[0] : null;
        $version    = '';
        if ($apiVersion) {
            $version = '/' . $apiVersion . '/';
        }

        return [$version, $apiVersion];
    }

    /**
     * DESC
     *
     * @return array
     * @throws \yii\base\InvalidConfigException
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function parseApiVersionUrl()
    {
        $requestUri = parent::resolveRequestUri();

        // replace API Version
        preg_match(static::URL_VERSION_PATTERN, $requestUri, $versionArr);

        // Module and version
        $version    = !empty($versionArr[1]) ? $versionArr[1] : null;
        $apiVersion = trim($version, '/');

        // $module = !empty($versions[7]) ? $versions[7] : null;
        //$moduleSingular = !empty($versions[7]) ? BaseInflector::singularize($versions[7]) : null;

        return [$version, $apiVersion];
    }

    /**
     * DESC
     *
     * @param bool|false $asVersion as application version format v1
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getNameSpace($asVersion = false)
    {
        $ns = $this->headers[static::X_API_NS];

        if ($asVersion) {
            $ns = str_replace('_', '.', trim($ns, '\\'));
        }

        if(empty($ns)) {
            $ns = 'v1';
        }

        return $ns;
    }

    /**
     * DESC
     *
     * @param string $version version
     *
     * @return string
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function versionToNameSpace($version)
    {
        if ($version) {
            return '\\' . str_replace('.', '_', $version) . '\\';
        }

        return '';
    }

    /**
     * DESC
     *
     * @param string $ns namespace
     *
     * @return string
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function namespaceToVersion($ns)
    {
        if ($ns) {
            return trim(str_replace('_', '.', $ns), '\\');
        }

        return '';
    }

    /**
     * Backend Application API-Version
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getApiVersion()
    {
        return $this->headers[static::X_API_VERSION];
    }

    /**
     * Api-Version sent from the client to the backend
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getRequestApiVersion()
    {
        return $this->headers[static::C_API_VERSION];
    }


    /**
     * Api-Version sent from the client to the backend
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getRequestApiTz()
    {
        return $this->headers[static::C_API_TZ];
    }


    /**
     * Api-Version sent from the client to the backend
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getRequestApiLocale()
    {
        return $this->headers[static::C_API_LOCALE];
    }

    /**
     * Get request unique id
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getXRequestId()
    {
        return $this->headers[static::X_REQUEST_ID];
    }

    /**
     * Get request time
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getXRequestTime()
    {
        return $this->headers[static::X_REQUEST_TIME];
    }

    /**
     * Get App Id
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getXAppId()
    {
        return $this->headers[static::X_APP_ID];
    }

    /**
     * DESC
     *
     * @return string
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getPathInfo()
    {
        $pathInfo        = parent::getPathInfo();
        $this->xPathInfo = preg_replace(static::XPATH_VERSION_PATTERN, '', $pathInfo);
        if ($this->versionInHeader) {
            $pathInfo = $this->getApiVersion() . '/' . $pathInfo;
        }

        return $pathInfo;
    }

    /**
     * get query params from small letter parameters without upper cases
     *
     * @param string $name         query param name
     * @param null   $defaultValue default value
     *
     * @return mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getQueryParam($name, $defaultValue = null)
    {
        $value = parent::getQueryParam($name, $defaultValue);
        if ($value === null) {
            $value = parent::getQueryParam(strtolower($name), $defaultValue);
        }

        return $value;
    }

    public function setNsVersion($version = '')
    {
        $this->headers[static::X_NS_VERSION] = $version;
    }
}
