<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Language;

/**
 * Class Lang
 *
 * @author Dmitry Gladyshev <deel@email.ru>
 * @since 1.0
 */
class Language
{
    /* Available translations */
    const RU = 'ru_RU';

    /**
     * @var array
     */
    protected static $translations = [];

    /**
     * @param string $message
     * @param string $lang
     * @return string
     */
    public static function translate($message, $lang)
    {
        if (self::loadTranslation($lang)
            && isset(self::$translations[$lang][$message])
        ) {
            return self::$translations[$lang][$message];
        }
        return $message;
    }


    /**
     * @param $lang
     * @return bool|mixed
     */
    public static function loadTranslation($lang)
    {
        if (empty(self::$translations[$lang])) {
            $langFile = __DIR__ . DIRECTORY_SEPARATOR . $lang . '.php';
            if (is_readable($langFile)) {
                self::$translations[$lang] = require $langFile;
            } else {
                return false;
            }
        }

        return true;
    }
}
