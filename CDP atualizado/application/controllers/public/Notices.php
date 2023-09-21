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

class Notices extends CI_Controller
{

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notices_Mdl', 'notices_mdl');
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
        $this->buffer(array('method' => $this->notices_mdl));
        $this->render(array('output' => 'public/notices'));
    }

    public function render()
    {
        if ((count(func_get_arg(0))) === (1)) {
            $this->load->view('public/notices', array(key(func_get_arg(0)) => $this->load->view(current(func_get_arg(0)), $this->data, true)), false);
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

    public function getEdital()
    {
        $this->code = preg_replace('/(\'|")/', NULL, filter_input(INPUT_GET, 'code'));
        $edital = $this->notices_mdl->select_edital($this->code);

        if(empty($edital) || empty($edital->edital)){
            echo ("<script>
                alert('Este ebook não possui edital cadastrado');
                window.location.replace('../ebook?tab=ebook&sec=view');
                </script>");
            return;
        }
        //desmembrando informacoes criadas pelo FileManager
        $arquivo = explode(';',$edital->edital);//separando type do blob
        $arquivo[] = explode(',',$arquivo[1])[1];//separando criptografia info do blob
        
        //identificando informacoes
        $type = $arquivo[0];
        $blobB64 = $arquivo[2];
        $name = "edital_{$this->code}.pdf";
        
        //download arquivo
        header('Content-type: ' . $type);
        header('Content-Disposition: attachment; filename=' . $name);
        ob_clean();
        flush();
        echo base64_decode($blobB64);
        exit;
    }


    // --------------------------------------------------------------------
}
