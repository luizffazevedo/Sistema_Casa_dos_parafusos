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

class Signin extends MY_Controller {

    /**
     * @access  private
     * @var     string  The user e-mail
     */
    private $e_mail;

    /**
     * @access  private
     * @var     string  The user password
     */
    private $passwd;

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
            if($_SESSION['access_level'] == 1){
                redirect(base_url('balcony?tab=box_control'), 'refresh');
            }
            if($_SESSION['access_level'] == 2){
                redirect(base_url('setting?tab=payments&sec=view&income=0'), 'refresh');
            }
            if($_SESSION['access_level'] == 3){
                redirect(base_url('setting?tab=demonstrative'), 'refresh');
            }
            if($_SESSION['access_level'] == 4){
                redirect(base_url('balcony?tab=box_control'), 'refresh');
            }
        }
        $this->load->model('Signin_Mdl', 'signin_mdl');
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
        $this->e_mail = preg_replace('/(\'|")/', null, strtolower(filter_input(INPUT_POST, 'e_mail', FILTER_VALIDATE_EMAIL)));
        $this->passwd = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'passwd'));
        if ((filter_input(INPUT_POST, 'secret')) !== (TRUE)) {
            if ((!empty($this->e_mail)) && (!empty($this->passwd))) {
                if (!empty($this->signin_mdl->select($this->e_mail))) {
                    if ($this->secret->CheckPassword($this->passwd, $this->signin_mdl->select($this->e_mail)->user_pass)) {
                        $_SESSION['usrid'] = $this->signin_mdl->select($this->e_mail)->ID;
                        $_SESSION['full_name'] = $this->signin_mdl->select($this->e_mail)->display_name;
                        $_SESSION['email'] = $this->e_mail;
                        $_SESSION['access_level'] = $this->signin_mdl->select($this->e_mail)->access_level;
                        $_SESSION['logged_in'] = TRUE;
                        switch ($this->signin_mdl->select($this->e_mail)->access_level) {
                            case 1:
                                redirect(base_url('balcony?tab=box_control'), 'refresh');
                                break;
                            case 2:
                                redirect(base_url('setting?tab=payments&sec=view&income=0'), 'refresh');
                                break;
                            case 3:
                                redirect(base_url('setting?tab=demonstrative'), 'refresh');
                                break;
                            case 4:
                                redirect(base_url('balcony?tab=box_control'), 'refresh');
                                break;
                        }
                        if ($this->signin_mdl->select($this->e_mail)->access_level == (4)){
                            redirect(base_url('setting?tab=product&sec=import'), 'refresh');
                        }
                        redirect(base_url('setting?tab=product&sec=import'), 'refresh');
                    } else {
                        
                    }
                }
            }
        }
        $this->buffer(array('method' => $this->signin_mdl));
        $this->render(array('output' => 'signin'));
    }

    public function create_user() {
        $email = 'daniel@casadosparafusosvr.com.br';
        $password = 'Daniel_3101';
        $name = 'Daniel';
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $this->signin_mdl->create_user($email, $hashed_password, $name);

    }

    public function update_password_user($email_user, $password_new) {
        $email = $email_user;
        $hashed_password = password_hash($password_new, PASSWORD_BCRYPT);
    
        $this->signin_mdl->update_password_user($email, $hashed_password);

    }

    // --------------------------------------------------------------------
}
