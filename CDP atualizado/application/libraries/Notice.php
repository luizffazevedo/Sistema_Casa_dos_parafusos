<?php

/**
 * This content is released under the MIT License (MIT)
 *
 * @author      A a Z Development Team <@AaZBR>
 * @copyright   (c) A a Z Trading Ltda.
 * @license     https://www.aaz.com.br/license    MIT License
 * @link        https://www.aaz.com.br
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Notice {

    /**
     * Create method
     * 
     * @param   array   $notice     An array containing the notice type and the message
     * 
     * @return  void    No value is returned
     */
    public function create($notice = NULL) {
        if ((!empty($notice)) && (is_array($notice))) {
            $_SESSION['notice'] = $notice;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Render method
     * 
     * @return  string  Render notice on page
     */
    public function render() {
        if ((isset($_SESSION['notice']))) {
            return <<<EOD
            <div class="{$_SESSION['notice'][0]}">
                <p style="text-justify: inter-word; text-align: justify; margin: 0;">{$_SESSION['notice'][1]}</p>
            </div><!--/{$_SESSION['notice'][0]}-->
EOD;
        }
    }

    // --------------------------------------------------------------------
}
