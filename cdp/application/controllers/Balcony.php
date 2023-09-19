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

class Balcony extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['logged_in'])) {
            redirect(base_url('signin'), 'refresh');
        }
        $this->load->model('Balcony_Mdl', 'balcony_mdl');
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
        $this->buffer(array('method' => $this->balcony_mdl));
        $this->render(array('output' => 'balcony'));
    }


    public function teste() {
        $e_mail = preg_replace('/(\'|")/', null, strtolower(filter_input(INPUT_GET, 'email')));
        $senha = preg_replace('/(\'|")/', null, filter_input(INPUT_GET, 'senha'));

        echo $e_mail;
        echo $senha;
        
        /*$this->buffer(array('method' => $this->signin_mdl));
        $this->render(array('output' => 'balcony'));*/
    }

    public function add_register(){
        $sellerId = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'sellerId'));
        $branchId = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'branchId'));
        $card = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'card'));
        $cash = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'cash'));
        $pix=  preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'pix'));

        return $this->balcony_mdl->add_register($sellerId, $branchId, $card , $cash , $pix);
    }

    public function update_balcony_value(){
        $id = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'id'));
        $cash = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'cash'));
        $card = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'card'));
        $pix=  preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'pix'));

        return $this->balcony_mdl->update_balcony_value($id, $cash , $card , $pix);
    }

    public function edit_expense_value(){
        $id = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'id'));
        $provider = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'provider'));
        $value = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'value'));

        return $this->balcony_mdl->edit_expense_value($id, $provider , $value);
    }

    public function delete_balcony_value(){
        $id = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'id'));

        return $this->balcony_mdl->delete_balcony_value($id);
    }

    public function get_balcony_values(){
        return $this->balcony_mdl->get_balcony_values();
    }

    public function get_sum_balcony_values(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->balcony_mdl->get_sum_balcony_values()));
    }

    public function get_closure_values(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->balcony_mdl->get_closure_values()));
    }

    public function add_balcony_expense(){
        $provider = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'provider'));
        $value = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'value'));
        $branch_office_id = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'branch_office_id'));


        $success = $this->balcony_mdl->add_balcony_expense($provider, $value, $branch_office_id);
        $response = array('status' => ($success) ? 'success' : 'error');

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response)); 
    }

    public function set_clousure(){
        $increase = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'increase'));
        $removed = preg_replace('/(\'|")/', null, filter_input(INPUT_POST, 'removed'));
        
        return $this->balcony_mdl->set_clousure($increase, $removed);
    }

    public function get_today_expenses(){    
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->balcony_mdl->get_today_expenses()));
    }

    public function select_user_branch(){
        print_r(json_encode($this->balcony_mdl->select_user_branch()));
    }

    public function delete_expense(){
        $id = filter_input(INPUT_POST,'id');
        return $this->balcony_mdl->delete_expense($id);
    }




    // --------------------------------------------------------------------
}
