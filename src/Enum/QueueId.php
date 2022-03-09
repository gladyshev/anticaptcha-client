<?php
/**
 * @project Anticaptcha library
 */

namespace Anticaptcha\Enum;

/**
 * Class QueueId
 */
class QueueId
{
    public const IMAGE_TO_TEXT_EN = 1;                // ImageToText, English
    public const IMAGE_TO_TEXT_RL = 2;                // ImageToText, Russian
    public const RECAPTCHA_V2 = 5;                    // Recaptcha v2 с прокси
    public const RECAPTCHA_V2_PROXYLESS = 6;          // Recaptcha v2 без прокси
    public const FUNCAPTCHA = 7;                      // Funcaptcha с прокси
    public const FUNCAPTCHA_PROXYLESS = 10;           // Funcaptcha без прокси
    public const GEE_TEST = 12;                       // GeeTest с прокси
    public const GEE_TEST_PROXYLESS = 13;             // GeeTest без прокси
    public const RECAPTCHA_V3_S03 = 18;               // Recaptcha V3 s0.3
    public const RECAPTCHA_V3_S07 = 19;               // Recaptcha V3 s0.7
    public const RECAPTCHA_V3_S09 = 20;               // Recaptcha V3 s0.9
    public const H_CAPTCHA = 21;                      // hCaptcha с прокси
    public const H_CAPTCHA_PROXYLESS = 22;            // hCaptcha без прокси
    public const RECAPTCHA_ENTERPRISE = 23;           // Recaptcha Enterprise V2 с прокси
    public const RECAPTCHA_ENTERPRISE_PROXYLESS = 24; // Recaptcha Enterprise V2 без прокси
}
