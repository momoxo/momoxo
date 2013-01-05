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
        $baseUri    = parse_url($xoopsUrl, PHP_URL_PATH).'/';
        $scriptPath = parse_url($_SERVER['SCRIPT_NAME'], PHP_URL_PATH).'/';
        $requestUri = substr($scriptPath, strlen($baseUri));
        $ret = preg_split('#/#', $requestUri, -1, PREG_SPLIT_NO_EMPTY);

        return $ret;
    }
}
