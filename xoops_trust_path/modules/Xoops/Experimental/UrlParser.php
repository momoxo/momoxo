<?php

namespace Xoops\Experimental;

class UrlParser
{
    /**
     * @param string $xoopsUrl
     * @return string
     */
    public static function parse($xoopsUrl)
    {
        $baseUri = parse_url($xoopsUrl, PHP_URL_PATH).'/';
        $scriptPath = parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH).'/';
        $requestUri = substr($scriptPath, strlen($baseUri));
        $ret = preg_split('#/#', $requestUri, -1, PREG_SPLIT_NO_EMPTY);

        return $ret;
    }

    public static function isAdminPage(array $urlInfo)
    {
        $adminStateFlag = false;
        if (count($urlInfo) >= 3) {
            if (strtolower($urlInfo[0]) == 'modules') {
                if (strtolower($urlInfo[2]) == 'admin') {
                    $adminStateFlag = true;
                } elseif ($urlInfo[1] == 'xcore' && $urlInfo[2] == 'include') {
                    $adminStateFlag = true;
                } elseif ($urlInfo[1] == 'system' && substr($urlInfo[2], 0, 9) == 'admin.php') {
                    $adminStateFlag = true;
                }
            }
        } elseif (count($urlInfo) >= 1) {
            if (substr($urlInfo[0], 0, 9) == 'admin.php') {
                $adminStateFlag = true;
            }
        }

        return $adminStateFlag;
    }

    public static function getModuleDirname(array $urlInfo)
    {
        $dirname = null;

        if (count($urlInfo) >= 2) {
            if (strtolower($urlInfo[0]) == 'modules') {
                $dirname = $urlInfo[1];
            }
        }
        if (substr($urlInfo[0], 0, 9) == 'admin.php') {
            $dirname = 'xcore';
        }

        return $dirname;
    }
}
