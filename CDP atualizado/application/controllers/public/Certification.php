<?php

/**
 * This content is released under the MIT License (MIT)
 *
 * @author      AteZ Development Team <@AteZBR>
 * @copyright   (c) AteZ Trading Ltda.
 * @license     https://www.atez.com.br/license    MIT License
 * @link        https://www.atez.com.br
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Certification extends CI_Controller
{

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Certification_Mdl', 'certification_mdl');
    }

    // --------------------------------------------------------------------

    /**
     * Index method
     *
     * Maps to the following URL
     * 		https://www.atez.com.br/license
     * 
     * @return  void    No value is returned
     */
    public function index()
    {
        $this->buffer(array('method' => $this->certification_mdl));
        $this->render(array('output' => 'public/certification'));
    }

    public function render()
    {
        if ((count(func_get_arg(0))) === (1)) {
            $this->load->view('public/certification', array(key(func_get_arg(0)) => $this->load->view(current(func_get_arg(0)), $this->data, true)), false);
        } else {
            throw new RuntimeException('Invalid parameter');
        }
    }

    public function buffer()
    {
        if ((count(func_get_arg(0))) === (1)) {
            $this->data = array(key(func_get_arg(0)) => current(func_get_arg(0)));
        } else {
            throw new RuntimeException('Invalid parameter');
        }
    }

    public function autenticate()
    {
        $type = preg_replace('/(\'|")/', NULL, filter_input(INPUT_GET, 'type'));
        $codigo = preg_replace('/(\'|")/', NULL, filter_input(INPUT_GET, 'code'));
        
        if ($type == 'doi') {
            $this->certification_mdl->autenticate($codigo, NULL, $type);
        }else{
            $date = filter_input(INPUT_GET, 'date');
            if (!empty($codigo && !empty($date))) {
                $this->certification_mdl->autenticate($codigo, $date, $type);
            } else {
                echo "Código ou data não recebidos";
            }
        }

        
    }


    // --------------------------------------------------------------------
}
