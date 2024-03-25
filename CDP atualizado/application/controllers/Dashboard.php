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

class Dashboard extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['logged_in'])) {
            redirect(base_url('signin'), 'refresh');
        }
        $this->load->model('Dashboard_Mdl', 'dashboard_mdl');
    }

    // --------------------------------------------------------------------Teste

    /**
     * Index method
     *
     * Maps to the following URL
     * 		https://www.atez.com.br/welcome
     * 
     * @return  void    No value is returned
     */
    public function index() {
        $this->buffer(array('method' => $this->dashboard_mdl)); 
        $this->render(array('output' => 'dashboard'));
    }


    public function get_atendments() {
        $branch_id = preg_replace('/(\'|")/', null, filter_input(INPUT_GET, 'branch_id'));
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_atendments()));
    }

    public function get_balcony_payments() {
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_balcony_payments()));
    }

    public function get_payments_values(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_payments_values()));
    }

    public function get_balcony_values_dashboard(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_balcony_values_dashboard()));
    }
    
    public function get_expenses_chart(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_expenses_chart()));
    }

    public function get_entries_historic(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_entries_historic()));
    }

    public function get_exit_historic(){
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($this->dashboard_mdl->get_exit_historic()));
    }
    
    

    // --------------------------------------------------------------------Teste
}
