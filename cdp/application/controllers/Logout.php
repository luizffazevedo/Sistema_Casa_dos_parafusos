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

class Logout extends MY_Controller {

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Logout_Mdl', 'logout_mdl');
        session_destroy();
        unset($_SESSION);
        redirect(base_url('signin'), 'refresh');
    }

    // --------------------------------------------------------------------

    /**
     * Index method
     *
     * Maps to the following URL
     * 		https://www.atez.com.br/welcome
     * 
     * @return  void    No value is returned
     */
    public function index() {
        $this->buffer(array('method' => $this->logout_mdl));
        $this->render(array('output' => 'logout'));
    }

    // --------------------------------------------------------------------
}
