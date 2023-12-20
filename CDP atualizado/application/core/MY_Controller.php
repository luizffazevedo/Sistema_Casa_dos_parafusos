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

class MY_Controller extends CI_Controller {

    /**
     * @access  private
     * @var     array   List the loaded values
     */
    private $data;

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
        if (($this->session->has_userdata('token')) === (FALSE)) {
            $this->session->set_userdata(array(
                'token' => random(32),
            ));
        }
    }

    // --------------------------------------------------------------------

    /**
     * Buffer dynamic data to the view
     *
     * @return  void    No value is returned
     */
    public function buffer() {
        if ((count(func_get_arg(0))) === (1)) {
            $this->data = array(key(func_get_arg(0)) => current(func_get_arg(0)));
        } else {
            throw new RuntimeException('Invalid parameter');
        }
    }

    // --------------------------------------------------------------------

    /**
     * Render view
     *
     * @return  void    No value is returned
     */
    public function render() {
        if ((count(func_get_arg(0))) === (1)) {
            $this->load->view('template', array(key(func_get_arg(0)) => $this->load->view(current(func_get_arg(0)), $this->data, true)), false);
        } else {
            throw new RuntimeException('Invalid parameter');
        }
    }

    // --------------------------------------------------------------------
}
