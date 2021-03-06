<?php

// ========================================================================= //
// SINEVIA PUBLIC                                        http://sinevia.com  //
// ------------------------------------------------------------------------- //
// COPYRIGHT (c) 2008-2019 Sinevia Ltd                   All rights reserved //
// ------------------------------------------------------------------------- //
// LICENCE: All information contained herein is, and remains, property of    //
// Sinevia Ltd at all times.  Any intellectual and technical concepts        //
// are proprietary to Sinevia Ltd and may be covered by existing patents,    //
// patents in process, and are protected by trade secret or copyright law.   //
// Dissemination or reproduction of this information is strictly forbidden   //
// unless prior written permission is obtained from Sinevia Ltd per domain.  //
//===========================================================================//

namespace Sinevia;

class UidUtils {

    /**
     * A human friendly, numbers only UUID, which has the nano seconds precission
     * 32 digits - YYYYMMDD-HHMM-SSMM-MMMMRRRRRRRRRRRR
     * @return string
     */
    public static function humanUuid($options = []) {
        $useDashes = isset($options['useDashes']) ? $options['useDashes'] : false;
        $dash = $useDashes ? '-' : '';
        $uuid = date('YmdHis') . substr(explode(" ", microtime())[0], 2, 8) . rand(100000000000, 999999999999);
		return substr($uuid,0,8).$dash.substr($uuid,8,4).$dash.substr($uuid,12,4).$dash.substr($uuid,16,4).$dash.substr($uuid,20,12);
    }

    /**
     * Time based unique id with nano seconds precission. No dashes.
     * 23 digits - YYYYMMDD-HHMMSS-MMMMMM-NNN
     * @return string
     */
    public static function nanoUid($options = []) {
        $useDashes = isset($options['useDashes']) ? $options['useDashes'] : false;
        $dash = $useDashes ? '-' : '';
        $microsecs = substr(explode(" ", microtime())[0], 2, 6);
        $nanosecs = substr(exec('date +%s%N'), -3);
        return date('YmdHis') . $dash . $microsecs . $dash . $nanosecs;
    }

    /**
     * Time based unique id with micro seconds precission. No dashes.
     * 20 digits - YYYYMMDD-HHMMSS-MMMMMM
     * @return string
     */
    public static function microUid($options = []) {
        $useDashes = isset($options['useDashes']) ? $options['useDashes'] : false;
        $dash = $useDashes ? '-' : '';
        return date('YmdHis') . substr(explode(" ", microtime())[0], 2, 6);
    }

    /**
     * Time based unique id with seconds precission. No dashes.
     * 14 digits - YYYYMMDD-HHMMSS
     * @return string
     */
    public static function secUid() {
        $milliseconds = round(microtime(true) * 1000);
        return date('YmdHis');
    }

    public static function timestampUid() {
        return time();
    }

    public static function timestampUidWithRandomPostFix($postfix_length = 4) {
        /* Human Readable Only */
        $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'); //array("b", "c", "d", "f", "g", "h", "j", "k", "l", "m", "n", "p", "q", "r", "s", "t", "v", "w", "x", "y", "z", "1", "2", "3", "4", "5", "6", "7", "8", "9");
        shuffle($chars);
        shuffle($chars);
        $postfix = implode("", array_splice($chars, 0, $postfix_length));
        return self::timestampUid() . $postfix;
    }

    public static function isHumanUid($string) {
        $string = str_replace('-', '', $string);
        if (is_numeric($string) == true AND strlen($string) == 32) {
            return true;
        }
        return false;
    }
    
    public static function isNanoUid($string) {
        $string = str_replace('-', '', $string);
        if (is_numeric($string) == true AND strlen($string) == 23) {
            return true;
        }
        return false;
    }
    
    public static function isMicroUid($string) {
        $string = str_replace('-', '', $string);
        if (is_numeric($string) == true AND strlen($string) == 20) {
            return true;
        }
        return false;
    }
    
    public static function isSecUid($string) {
        $string = str_replace('-', '', $string);
        if (is_numeric($string) == true AND strlen($string) == 14) {
            return true;
        }
        return false;
    }

}
