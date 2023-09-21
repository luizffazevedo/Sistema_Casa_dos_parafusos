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

class Setting extends MY_Controller {

    /**
     * @access  private
     * @var     string  
     */
    private $base;

    /**
     * @access  private
     * @var     string  
     */
    private $edital;

    /**
     * @access  private
     * @var     string  
     */
    private $type;

    /**
     * @access  private
     * @var     string  
     */
    private $edit;

    /**
     * @access  private
     * @var     string  
     */
    private $name;

    /**
     * @access  private
     * @var     string  
     */
    private $pric;

    /**
     * @access  private
     * @var     string  
     */
    private $desc;

    /**
     * @access  private
     * @var     string  
     */
    private $usrid;

    /**
     * @access  private
     * @var     string  
     */
    private $docum;

    /**
     * @access  private
     * @var     string  
     */
    private $aclvl;

    /**
     * @access  private
     * @var     string  
     */
    private $code;

    /**
     * @access  private
     * @var     string  
     */
    private $status;

    /**
     * @access  private
     * @var     string  
     */
    private $txtdeny;
    
    /**
     * @access  private
     * @var     string  
     */
    private $date_emission;

    /**
     * @access  private
     * @var     string  
     */
    private $ativo;
   
    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['logged_in'])) {
            redirect(base_url('signin'), 'refresh');
        }
        $this->load->model('Setting_Mdl', 'setting_mdl');
        $this->load->model('Email_Mdl', 'email_mdl');
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
        $this->buffer(array('method' => $this->setting_mdl));
        $this->render(array('output' => 'setting'));
    }


    // --------------------------------------------------------------------

    // --------------------------------------------------------------------
    
    public function select() {
        $this->code = preg_replace('/(\'|")/', NULL, filter_input(INPUT_GET, 'code'));
        $this->setting_mdl->select_ebook_js($this->code);
    }
    
    public function send_email($email) {
        $this->email_mdl->send_email($email, "Próxima etapa do capitulo", 'Seu capítulo está em uma nova etapa, acesse <a href="https://editorapasteur.com.br/sistema/">editorapasteur.com.br/sistema</a> para conferir.');
    }

    public function save_table(){
        $table = filter_input(INPUT_POST, 'tableData');
        echo($save_table = $this->setting_mdl->save_table($table));
    }

    public function select_table_state(){
        $date = filter_input(INPUT_GET, 'date');
        return $this->setting_mdl->select_table_state($date);
    }

    public function xml_exists(){
        $number = filter_input(INPUT_GET, 'number');
        return $this->setting_mdl->xml_exists($number);
    }

    public function payment_date_exists(){
        $number = filter_input(INPUT_GET, 'number');
        $date = filter_input(INPUT_GET, 'date');
        $date_payment = filter_input(INPUT_GET, 'date_payment'); 
        return $this->setting_mdl->payment_date_exists($number,$date,$date_payment);
    }

    public function save_xml(){
        $xml = $_POST['xml_doc'];
        $number = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'number'));
        $emiter = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'emiter'));
        $destine = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'destine'));
        $payment_method = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'payment_method'));
        $parcel_value = $_POST['parcel_value'];
        $parcel_date = $_POST['parcel_date'];
        $observation = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'observation'));
        $income = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'income'));
        $my_account = $this->input->post('account', 1);
        if ((!empty($xml))) {
            $this->setting_mdl->save_xml($xml, $number, $emiter, $destine, $payment_method, $parcel_value, $parcel_date, $observation, $income, $my_account);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function insert_manual_note(){
        $number = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'number'));
        $emiter = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'emiter'));
        $destine = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'destine'));
        $payment_method = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'payment_method'));
        $parcel_value = $_POST['parcel_value'];
        $parcel_date = $_POST['parcel_date'];
        $observation = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'observation'));
        $income = preg_replace('/(\'|")/', NULL, filter_input(INPUT_POST, 'income'));
        $my_account = $this->input->post('account', 1);
        $this->setting_mdl->insert_manual_note($number, $emiter, $destine, $payment_method, $parcel_value, $parcel_date, $observation, $income, $my_account);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function update_with_ret(){
        $number = $_POST['number'];
        $date = $_POST['date'];
        $date_approved = $_POST['date_approved'];
        if (!empty($number)){
            $this->setting_mdl->update_with_ret($number,$date,$date_approved);
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getNote(){
        $number = $_GET['number'];
        if (!empty($number)){
            return $this->setting_mdl->getNote($number);
        }
    }

    public function edit_note(){
        $number = $_POST['number'];
        $emiter = $_POST['emiter'];
        $destine = $_POST['destine'];
        $observation = $_POST['observation'];
        $account = $_POST['observation'];
        if(isset($_POST['selected_account_edit'])){
            $account = $_POST['selected_account_edit'];
        }else{
            $account = NULL;
        }

        $id_note = $_POST['id_note']; // id do pagamento
        $id_note_edit = $_POST['note_id_edit']; // id do registro da nota no banco
        $parcel_date = $_POST['parcel_date'];
        $parcel_value = $_POST['parcel_value'];
        
        foreach($parcel_date AS $key => $value ){
            if (isset($id_note[$key])) {
                $array_to_update[$key] = array (
                'id'=>$id_note[$key],
                'parcel_date'=>$parcel_date[$key],
                'parcel_value'=>$parcel_value[$key],
                'id_payment'=>$id_note_edit,
                );
            } else {
                $array_to_update[$key] = array (
                'id'=>NULL,
                'parcel_date'=>$parcel_date[$key],
                'parcel_value'=>$parcel_value[$key],
                'id_payment'=>$id_note_edit,
                );
            }
        }
        
        $affected_rows = $this->setting_mdl->edit_note($number,$emiter,$destine,$account,$observation,$array_to_update);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function getPayment(){
        $id = $_GET['id'];
        if (!empty($id)){
            return $this->setting_mdl->getPayment($id);
        }
    }

    public function edit_payment(){
        $id = filter_input(INPUT_POST, 'id');
        $value_edit_payment = filter_input(INPUT_POST, 'value');
        $date_edit_payment = filter_input(INPUT_POST, 'date');
        $payment_status_edit_payment = filter_input(INPUT_POST, 'status');
        $approved_date = filter_input(INPUT_POST, 'date_approved');

        $this->setting_mdl->edit_payment($id, $value_edit_payment, $date_edit_payment, $payment_status_edit_payment,$approved_date);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function create_login(){
        $name = filter_input(INPUT_POST, 'name');
        $login = filter_input(INPUT_POST, 'user');
        $password = filter_input(INPUT_POST, 'password');
        $sistem = filter_input(INPUT_POST, 'sistem');
        $this->setting_mdl->create_login($name,$login,$password,$sistem);
        redirect(base_url('setting?tab=logins&sec=all'), 'refresh');
    }

    public function edit_login(){
        $id = filter_input(INPUT_POST, 'id');
        $name = filter_input(INPUT_POST, 'name');
        $login = filter_input(INPUT_POST, 'user');
        $password = filter_input(INPUT_POST, 'password');
        $sistem = filter_input(INPUT_POST, 'sistem');
        $this->setting_mdl->edit_login($id,$name,$login,$password,$sistem);
        redirect(base_url('setting?tab=logins&sec=all'), 'refresh');
    }

    public function parcel_values_to_receive(){
        $year = filter_input(INPUT_POST, 'year');
        $companies = $_POST['companies'];
        print_r(json_encode($this->setting_mdl->parcel_values_to_receive($year, $companies)));
    }

    public function parcel_values_to_receive_all_time(){
        $year = filter_input(INPUT_POST, 'year');
        $companies = $_POST['companies'];
        print_r(json_encode($this->setting_mdl->parcel_values_to_receive_all_time($year, $companies)));
    }

    public function parcel_values_received(){
        $year = filter_input(INPUT_POST, 'year');
        $companies = $_POST['companies'];
        print_r(json_encode($this->setting_mdl->parcel_values_received($year, $companies)));
    }

    public function select_defaulters_companies(){
        $companies = $_POST['companies'];
        print_r(json_encode($this->setting_mdl->select_defaulters_companies($companies)));
    }

    public function insert_account_value(){
        $id_account = filter_input(INPUT_POST, 'id_account');
        $value = filter_input(INPUT_POST, 'value');
        echo $this->setting_mdl->insert_account_value($id_account, $value);
    }

    public function get_history_account_values(){
        $date = filter_input(INPUT_GET, 'date');
        echo $this->setting_mdl->get_history_account_values($date);
    }

    public function get_history_account_values_date(){
        $date = filter_input(INPUT_GET, 'date');
        print_r(json_encode($this->setting_mdl->get_history_account_values_date($date)));
    }

    public function get_history_hands_value_date(){
        $date = filter_input(INPUT_GET, 'date');
        print_r(json_encode($this->setting_mdl->get_history_hands_value_date($date)));
    }

    public function post_account_values(){
        $account_ids = $_POST['account_id'];
        $account_values = $_POST['account_value'];
        $hands_value = $_POST['hands_value'];
        $antecipation_card = $_POST['antecipation_card'];
        $this->setting_mdl->post_account_values($account_ids, $account_values,$hands_value,$antecipation_card);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function insert_expense(){
        $provider = (filter_input(INPUT_POST,'provider'));
        $value = (filter_input(INPUT_POST,'value'));
        $payment_date = (filter_input(INPUT_POST,'payment_date'));
        $approved_date = (filter_input(INPUT_POST,'approved_date'));
        $description = (filter_input(INPUT_POST,'description'));
        $expense_type = (filter_input(INPUT_POST,'expense_type'));
        $status_expense = (filter_input(INPUT_POST,'status_expense'));
        return $this->setting_mdl->insert_expense($provider, $value, $payment_date, $approved_date, $description, $status_expense, $expense_type);
    }

    public function update_expense(){
        $id = (filter_input(INPUT_POST,'id'));
        $provider = (filter_input(INPUT_POST,'provider'));
        $value = (filter_input(INPUT_POST,'value'));
        $payment_date = (filter_input(INPUT_POST,'payment_date'));
        $approved_date = (filter_input(INPUT_POST,'approved_date'));
        $description = (filter_input(INPUT_POST,'description'));
        $expense_type = (filter_input(INPUT_POST,'expense_type'));
        $status_expense = (filter_input(INPUT_POST,'status_expense'));
        return $this->setting_mdl->update_expense($id,$provider, $value, $payment_date, $approved_date, $description, $status_expense, $expense_type);
    }

    public function delete_expense(){
        $id = (filter_input(INPUT_POST,'id'));
        return $this->setting_mdl->delete_expense($id);
    }

    public function get_expenses(){
        $year_month = filter_input(INPUT_GET,'year_month');
        $year_month = $year_month != '' ? $year_month : date('Y-m');
        $this->db->select('e.id,e.provider,e.payment_date,
        e.approved_date,e.value,e.description, payment_status.name as status_name,
        payment_status.id as status_id, expense_type.name as type, expense_type.id as expense_type, branch_office.name as branch_name');
        $this->db->from('expense as e');
        $this->db->join('expense_type','e.expense_type=expense_type.id');
        $this->db->join('payment_status','e.status=payment_status.id');
        $this->db->join('branch_office','e.branch_office_id=branch_office.id','left');
        $this->db->like('e.payment_date',$year_month);
        $this->db->order_by('e.payment_date', 'desc');
        $result = $this->db->get()->result();
        if ($result) {
            $response = array('status' => 'success', 'data' => $result);
        } else {
            $response = array('status' => 'error');
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_recents_notes(){
        $income = filter_input(INPUT_GET,'income');
        $result = $this->setting_mdl->get_recents_notes($income);
        if ($result) {
            $response = array('status' => 'success', 'data' => $result);
        } else {
            $response = array('status' => 'error');
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function save_prevision(){
        $updatedValue = filter_input(INPUT_POST,'updatedValue');
        $date = filter_input(INPUT_POST,'date');
        $accounts = filter_input(INPUT_POST,'accounts');

        $success = $this->setting_mdl->save_prevision($updatedValue, $date, $accounts);
        $response = array('status' => ($success) ? 'success' : 'error');
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
