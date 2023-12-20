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

class Balcony_Mdl extends CI_Model {

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    public function month_names(){
         return array(
            1 => 'janeiro',
            2 => 'fevereiro',
            3 => 'março',
            4 => 'abril',
            5 => 'maio',
            6 => 'junho',
            7 => 'julho',
            8 => 'agosto',
            9 => 'setembro',
            10 => 'outubro',
            11 => 'novembro',
            12 => 'dezembro'
        );
    }

    public function user_control($usrid = NULL) {
        $select = "SELECT * FROM wp_users WHERE id = '{$usrid}'";
        $result = $this->db->query($select)->result();
        if ((count($result)) === (1)) {
            return $result[key($result)];
        }
    }

    //SELECT sum(cash),sum(card),sum(pix) from balcony_values JOIN user_branch on user_branch.id_user = balcony_values.user_id AND DATE(balcony_values.insert_date) = CURRENT_DATE() JOIN balcony_branch on balcony_branch.id_user = 1 GROUP BY balcony_values.user_id

    public function select_user_branch(){
        $date = (isset($_GET['date']) && $_GET['date'] != 'null') ? $_GET['date'] : date('Y-m-d');
        $id_branch = preg_replace('/(\'|")/', null, filter_input(INPUT_GET, 'balcony'));

        $balcony = (isset($_GET['balcony']) && $_GET['balcony'] != 'null') ? $_GET['balcony'] :
            $this->db->get_where('balcony_branch', array('id_user' => $_SESSION['usrid']))->result()[0]->id_branch;
        
        if(isset($_GET['balcony']) && $_GET['balcony'] != 'null'){
            $select = "SELECT DISTINCT wp_users.id, wp_users.display_name, user_branch.id_branch as branch_id 
            FROM wp_users JOIN user_branch on wp_users.id = user_branch.id_user 
            WHERE user_branch.id_branch = $balcony ORDER BY wp_users.id";
            $result = $this->db->query($select)->result();
        }else{
            $select = "SELECT DISTINCT wp_users.id, wp_users.display_name, branch_office.id as branch_id 
            FROM wp_users 
            JOIN user_branch on wp_users.id = user_branch.id_user 
            JOIN branch_office ON user_branch.id_branch = branch_office.id 
            JOIN balcony_branch on branch_office.id = balcony_branch.id_branch 
            LEFT JOIN balcony_values on balcony_values.user_id = balcony_branch.id_user
            WHERE balcony_branch.id_user = ".$_SESSION['usrid']." ORDER BY wp_users.id;";
            $result = $this->db->query($select)->result();
        }

        $select2 = "SELECT sum(cash) as cash,sum(card) as card,sum(pix) as pix from 
        balcony_values JOIN user_branch on user_branch.id_user = balcony_values.user_id
        JOIN balcony_branch on balcony_values.branch_office_id = $balcony
        WHERE DATE(balcony_values.insert_date) = '$date'
        GROUP BY balcony_values.user_id";

        $result2 = $this->db->query($select2)->result();
        
        return array ("users"=>$result, "sums" => $result2);
    }

    public function add_register($sellerId, $branch_office_id, $card , $cash , $pix){
        $insert = "INSERT INTO balcony_values (id, user_id, branch_office_id, card, cash, pix, insert_date, user_last_changed) 
        VALUES (NULL,'{$sellerId}', '{$branch_office_id}','$card', '$cash', '$pix', '".date('Y-m-d H:i:s')."', '".$_SESSION['usrid']."')";

        $result = $this->db->query($insert);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }
    
    public function update_balcony_value($id, $cash, $card , $pix){
        $update = "UPDATE balcony_values SET cash = '$cash', card = '$card', pix = '$pix' WHERE id = '$id'";
        $result = $this->db->query($update);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function edit_expense_value($id, $provider, $value){
        $update = "UPDATE expense SET provider = '$provider', value = '$value' where id = $id";
        $result = $this->db->query($update);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function delete_balcony_value($id){
        $delete = "DELETE FROM balcony_values WHERE id = $id";
        $result = $this->db->query($delete);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function get_balcony_values(){
        $date = (isset($_GET['date']) && $_GET['date'] != 'null') ? $_GET['date'] : date('Y-m-d');
        $balcony = (isset($_GET['balcony']) && $_GET['balcony'] != 'null') ? $_GET['balcony'] :
            $this->db->get_where('balcony_branch', array('id_user' => $_SESSION['usrid']))->result()[0]->id_branch;

        $select = " SELECT t1.user_id,
        t1.user_id,
        t1.id,
        t1.card,
        t1.cash,
        t1.pix,
        t1.insert_hour,
        t2.sum_user_id,
        t2.sum_cash,
        t2.sum_card,
        t2.sum_pix FROM
        (
        SELECT DISTINCT bv.user_id, bv.id, bv.card, bv.cash, bv.pix, DATE_FORMAT(bv.insert_date,'%H:%i:%m') as insert_hour from balcony_values as bv 
                JOIN branch_office as bo on bv.branch_office_id =  bo.id 
                JOIN balcony_branch as bb on bb.id_branch = bo.id 
                WHERE bb.id_branch = $balcony
                AND DATE(bv.insert_date) = '$date'
                ORDER BY bv.id
        ) t1
        LEFT JOIN (
        SELECT user_id as sum_user_id, SUM(cash) as sum_cash, SUM(card) as sum_card, sum(pix) as sum_pix FROM `balcony_values` 
        JOIN branch_office ON branch_office.id = balcony_values.branch_office_id
        AND branch_office.id = $balcony
        WHERE DATE(balcony_values.insert_date) = '$date'
        GROUP by balcony_values.user_id)
        t2 ON t1.user_id = t2.sum_user_id";


        //echo $select;
        $result = $this->db->query($select)->result();
        
        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($result));
    }

    public function get_sum_balcony_values(){
        $date = (isset($_GET['date']) && $_GET['date'] != 'null') ? $_GET['date'] : date('Y-m-d');
        $balcony = (isset($_GET['balcony']) && $_GET['balcony'] != 'null') ? "bv.branch_office_id=".$_GET['balcony'] : "bb.id_user = ".$_SESSION['usrid'];

        $branch_office_id = (isset($_GET['balcony']) && $_GET['balcony'] != 'null') ? $_GET['balcony'] :
            $this->db->get_where('balcony_branch', array('id_user' => $_SESSION['usrid']))->result()[0]->id_branch;


        if(isset($_GET['balcony']) && $_GET['balcony'] != 'null'){
            $select = "SELECT t1.sum_cash, t1.sum_card, t1.sum_pix, t1.client_number, t1.total_sum, t2.total_expense FROM (
                SELECT 
                    SUM(cash) as sum_cash, 
                    SUM(card) as sum_card, 
                    SUM(pix) as sum_pix, 
                    count(bv.id) as client_number, 
                    SUM(cash) + SUM(card) + SUM(pix) as total_sum
                        FROM balcony_values as bv 
                            WHERE DATE(insert_date) = '$date' and branch_office_id = $branch_office_id
                ) as t1 JOIN (
                    SELECT sum(e.value) as total_expense From expense as e 
                    where e.branch_office_id = $branch_office_id
                    AND DATE(payment_date) = '$date'
                ) as t2";
        }else{
            $select = "SELECT t1.sum_cash, t1.sum_card, t1.sum_pix, t1.client_number, t1.total_sum, t2.total_expense FROM (
                SELECT 
                        SUM(cash) as sum_cash, 
                        SUM(card) as sum_card, 
                        SUM(pix) as sum_pix, 
                        count(bv.id) as client_number, 
                        SUM(cash) + SUM(card) + SUM(pix) as total_sum
                    FROM balcony_values as bv 
                    JOIN branch_office as bo on bv.branch_office_id =  bo.id 
                    JOIN balcony_branch as bb on bb.id_branch = bo.id 
                    AND DATE(bv.insert_date) = '$date' AND $balcony
                    ORDER BY bv.id
                ) as t1 JOIN (SELECT sum(e.value) as total_expense From expense as e where e.branch_office_id = $branch_office_id AND DATE(payment_date) = '$date') as t2";
        }        
        
        return $this->db->query($select)->result();
    }

    public function set_clousure($increase, $removed){
        $branch_office_id = $this->db->get_where('balcony_branch', array('id_user' => $_SESSION['usrid']))->result()[0]->id_branch;
        $exists = "SELECT id from closure where DATE(date) = CURRENT_DATE() and branch_office_id = $branch_office_id";
        $id_exists = $this->db->query($exists)->result();

        if(count($id_exists) > 0){
            $id = $id_exists[0]->id;
            $query = "UPDATE closure SET increase = '$increase', removed = '$removed' WHERE id = $id";
        }else{
            $query = "INSERT INTO closure (id, increase, removed, branch_office_id, date) VALUES (NULL, '$increase', '$removed', '$branch_office_id', CURRENT_TIMESTAMP());";
        }
       $result = $this->db->query($query);
        
        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response)); 

    }

    public function add_balcony_expense($provider,$value,$branch_office_id){
        $insert = "
        INSERT INTO `expense`
            (`id`,`branch_office_id`,`provider`,`value`,`payment_date`,`approved_date`,`description`,
            `status`,
            `expense_type`)
            VALUES
            (NULL, '$branch_office_id', '$provider', '$value', CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP(),NULL,
            1,
            1);
        ";
    
        $result = $this->db->query($insert);
   
       return $result;
    }

    public function delete_expense($id){
        $update = "DELETE FROM expense WHERE id = $id;";
        
        $result = $this->db->query($update);
        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function get_closure_values(){
        $date = isset($_GET['date']) && $_GET['date'] != 'null' ? $_GET['date'] : date('Y-m-d');
        $branch_office_id = isset($_GET['balcony']) && $_GET['balcony'] != 'null' ? $_GET['balcony'] : 
            $this->db->query('SELECT id_branch from balcony_branch where id_user = '.$_SESSION['usrid'])->result()[0]->id_branch;

        $select = "SELECT MAX(increase) as increase, MAX(removed) as removed FROM `closure` where DATE(date) = '$date' AND branch_office_id = $branch_office_id";
        $response = $this->db->query($select)->result();

        return $response;
    }

    public function get_today_expenses(){
        $date = isset($_GET['date']) && $_GET['date'] != 'null' ? $_GET['date'] : date('Y-m-d');
        $branch_office_id = isset($_GET['balcony']) && $_GET['balcony'] != 'null' ? $_GET['balcony'] : 
            $this->db->query('SELECT id_branch from balcony_branch where id_user = '.$_SESSION['usrid'])->result()[0]->id_branch;

        $select = "SELECT * FROM expense WHERE branch_office_id = $branch_office_id AND payment_date = '$date'";

        //echo $select;

        $response = $this->db->query($select)->result();

        $return = array('status' => ($response) ? 'success' : 'error', 'data' => $response);
        return $return;
    }
}
