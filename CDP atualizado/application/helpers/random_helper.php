<?php

/**
 * This content is released under the MIT License (MIT)
 *
 * @author      AteZ Development Team <@AteZBR>
 * @copyright   (c) AteZ Trading Ltda.
 * @license     https://www.atez.com.br/license    MIT License
 * @link        https://www.atez.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('random')) {

    /**
     * Random string
     *
     * @param   int     $length     The length of the string
     *
     * @return  string  The shuffled string, or NULL if length is omitted
     */
    function random($length = null) {
        if ((!empty($length)) && (is_int($length))) {
            return substr(str_shuffle(implode(null, preg_grep('/[09]/', range('!', '~'))) . date('YmdHis')), 0, $length);
        }
    }

}