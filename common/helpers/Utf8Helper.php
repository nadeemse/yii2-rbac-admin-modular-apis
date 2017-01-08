<?php

namespace common\helpers;

use Yii;

class Utf8Helper {

    public static function utf8_strlen($string) {
        return mb_strlen($string);
    }

    public static function utf8_strpos($string, $needle, $offset = 0) {
        return mb_strpos($string, $needle, $offset);
    }

    public static function utf8_strrpos($string, $needle, $offset = 0) {
        return mb_strrpos($string, $needle, $offset);
    }

    public static function utf8_substr($string, $offset, $length = null) {
        if ($length === null) {
            return mb_substr($string, $offset, self::utf8_strlen($string));
        } else {
            return mb_substr($string, $offset, $length);
        }
    }

    public static function utf8_strtoupper($string) {
        return mb_strtoupper($string);
    }

    public static function utf8_strtolower($string) {
        return mb_strtolower($string);
    }

    public static function utf8_to_unicode($string) {
        $unicode = array();

        for ($i = 0; $i < strlen($string); $i++) {
            $chr = ord($string[$i]);

            if ($chr >= 0 && $chr <= 127) {
                $unicode[] = (ord($string[$i]) * pow(64, 0));
            }

            if ($chr >= 192 && $chr <= 223) {
                $unicode[] = ((ord($string[$i]) - 192) * pow(64, 1) + (ord($string[$i + 1]) - 128) * pow(64, 0));
            }

            if ($chr >= 224 && $chr <= 239) {
                $unicode[] = ((ord($string[$i]) - 224) * pow(64, 2) + (ord($string[$i + 1]) - 128) * pow(64, 1) + (ord($string[$i + 2]) - 128) * pow(64, 0));
            }

            if ($chr >= 240 && $chr <= 247) {
                $unicode[] = ((ord($string[$i]) - 240) * pow(64, 3) + (ord($string[$i + 1]) - 128) * pow(64, 2) + (ord($string[$i + 2]) - 128) * pow(64, 1) + (ord($string[$i + 3]) - 128) * pow(64, 0));
            }

            if ($chr >= 248 && $chr <= 251) {
                $unicode[] = ((ord($string[$i]) - 248) * pow(64, 4) + (ord($string[$i + 1]) - 128) * pow(64, 3) + (ord($string[$i + 2]) - 128) * pow(64, 2) + (ord($string[$i + 3]) - 128) * pow(64, 1) + (ord($string[$i + 4]) - 128) * pow(64, 0));
            }

            if ($chr == 252 && $chr == 253) {
                $unicode[] = ((ord($string[$i]) - 252) * pow(64, 5) + (ord($string[$i + 1]) - 128) * pow(64, 4) + (ord($string[$i + 2]) - 128) * pow(64, 3) + (ord($string[$i + 3]) - 128) * pow(64, 2) + (ord($string[$i + 4]) - 128) * pow(64, 1) + (ord($string[$i + 5]) - 128) * pow(64, 0));
            }
        }

        return $unicode;
    }

    public static function unicode_to_utf8($unicode) {
        $string = '';

        for ($i = 0; $i < count($unicode); $i++) {
            if ($unicode[$i] < 128) {
                $string .= chr($unicode[$i]);
            }

            if ($unicode[$i] >= 128 && $unicode[$i] <= 2047) {
                $string .= chr(($unicode[$i] / 64) + 192) . chr(($unicode[$i] % 64) + 128);
            }

            if ($unicode[$i] >= 2048 && $unicode[$i] <= 65535) {
                $string .= chr(($unicode[$i] / 4096) + 224) . chr(128 + (($unicode[$i] / 64) % 64)) . chr(($unicode[$i] % 64) + 128);
            }

            if ($unicode[$i] >= 65536 && $unicode[$i] <= 2097151) {
                $string .= chr(($unicode[$i] / 262144) + 240) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
            }

            if ($unicode[$i] >= 2097152 && $unicode[$i] <= 67108863) {
                $string  .= chr(($unicode[$i] / 16777216) + 248) . chr((($unicode[$i] / 262144) % 64) + 128) . chr((($unicode[$i] / 4096) % 64) + 128) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
            }

            if ($unicode[$i] >= 67108864 && $unicode[$i] <= 2147483647) {
                $string .= chr(($unicode[$i] / 1073741824) + 252) . chr((($unicode[$i] / 16777216) % 64) + 128) . chr((($unicode[$i] / 262144) % 64) + 128) . chr(128 + (($unicode[$i] / 4096) % 64)) . chr((($unicode[$i] / 64) % 64) + 128) . chr(($unicode[$i] % 64) + 128);
            }
        }

        return $string;
    }
}