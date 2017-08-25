<?php
/**
 * YanPHP
 * User: weilongjiang(江炜隆)<willliam@jwlchina.cn>
 */

namespace Yan\Core;


class Config
{
    /**
     * the loaded config options
     * @var array
     */
    protected static $_configItems = array();

    protected static $_isLoaded = array();

    /**
     * init function ,load autoload config files
     */
    public static function initialize()
    {
        self::loadConfig('autoload');
        $autoload = self::get('autoload_config');
        if (is_array($autoload)) {
            foreach ($autoload as $k => $configFile) {
                self::loadConfig($configFile);
            }
        }
    }


    /**
     * @param string $key
     * @return array|bool|string
     */
    public static function get(string $key = '')
    {
        if (empty($key)) return self::$_configItems;
        return isset(self::$_configItems[$key]) ? self::$_configItems[$key] : false;
    }


    /**
     * Get all config items
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::$_configItems;
    }

    public static function set(string $key = '', string $value = ''): void
    {
        if (empty($key)) return;
        self::$_configItems[$key] = $value;
    }

    /**
     * to load config files, mark put in $isLoaded
     * @param string $file
     * @return bool
     */
    public static function loadConfig(string $file = ''): bool
    {
        $file = str_replace('.php', '', $file) . '.php';

        if (empty($file)) {
            throwError('Wrong file name', 503, true);
        }

        $filePath = APP_PATH . DIRECTORY_SEPARATOR . 'config/' . $file;

        if (!file_exists($filePath)) {
            throwError('File ' . $file . 'doesn\'t exists', 503, true);
            exit(1);
        } else {
            if (isset(self::$_isLoaded[$file])) {
                return true;
            }

            include $filePath;

            if (empty($config) || !is_array($config)) {
                return false;
            }

            self::$_isLoaded[$file] = true;
            self::$_configItems = array_merge(self::$_configItems, $config);
        }
        Log::debug('Load config file \'' . $file . '\'');
        return true;
    }

}