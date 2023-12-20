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

class Setting_Mdl extends CI_Model {

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

    public function payment_confirm($code = null, $status = null) {
        $update = "UPDATE user_ebook SET status = '{$status}' WHERE code = '{$code}'";
        $this->db->query($update);
    }

    // --------------------------------------------------------------------
    
    public function payment_deny($code = null) {
        $update = "UPDATE payment SET proof_payment = NULL, denied = 1 WHERE code_ebook = '{$code}'";
        $this->db->query($update);
    }

    public function select_ebook_js($code = NULL) {
        $select = "SELECT * FROM user_ebook WHERE code = $code";//"SELECT * FROM user_ebook /*AS ue JOIN wp_users AS us ON us.id = ue.id_user JOIN wp_users AS ur ON ur.id = ue.id_editor/ WHERE code = '{$code}' /AND status = 7*/";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            print_r(json_encode($result[key($result)]));
        }
    }
    
    public function getChapter_User_Mdl($code = NULL) {
        $select = "SELECT user_ebook.code, wp_users.display_name, id_ebook, id_user, user_ebook.id_editor, ebook.id, ebook.name, user_ebook.status 
        FROM user_ebook, wp_users, wp_users editor, ebook 
        WHERE wp_users.ID = user_ebook.id_user 
        AND user_ebook.id_editor = editor.ID 
        AND user_ebook.id_ebook = ebook.id 
        AND user_ebook.code = $code";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            print_r(json_encode($result[key($result)]));
        }
    }
    
    public function getEdital_Mdl($code = NULL) {
        $select = "SELECT code,id_editor,linkpay,name,price,description,ativo 
        FROM ebook
        WHERE code = $code";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            print_r(json_encode($result[key($result)]));
        }
    }

    // --------------------------------------------------------------------

    /**
     * Insert method
     * 
     * @return  void    No value is returned
     */
    public function insert($code = NULL, $base = NULL,$edital = NULL, $edit = NULL, $name = NULL, $pric = NULL, $desc = NULL, $date_emission = NULL, $link = NULL) {
        if ((!empty($code)) && (!empty($base)) && (!empty($name)) && (!empty($desc))) {
            $insert = "INSERT INTO ebook (code, photo, edital, id_editor, name, price, description, date_emission, linkpay) VALUES ('{$code}', '{$base}','$edital', '{$edit}', '{$name}', '{$pric}', '{$desc}', '{$date_emission}', '{$link}')";
            $this->db->query($insert);
        }
    }

    // --------------------------------------------------------------------

    public function editEdital_Mdl($code = NULL, $base = NULL,$edital = NULL, $edit = NULL, $name = NULL, $pric = NULL, $desc = NULL, $link = NULL, $ativo = NULL) {
        $insert = "UPDATE `ebook` SET `name` = '$name', linkpay='$link', price='$pric', description='$desc', id_editor='$edit', ativo=$ativo, photo='$base', edital='$edital' WHERE `ebook`.`code` = $code;";
            $this->db->query($insert);
    }

    public function editEditalInformations_Mdl($code = NULL, $edit = NULL, $name = NULL, $pric = NULL, $desc = NULL, $link = NULL, $ativo = NULL) {
        $insert = "UPDATE `ebook` SET `name` = '$name', linkpay='$link', price='$pric', description='$desc', id_editor='$edit', ativo=$ativo WHERE `ebook`.`code` = $code;";
            $this->db->query($insert);
    }

    /**
     * Select method
     * 
     * @param   string  $e_mail     The user e-mail
     * 
     * @return  string  If the e-mail exists in the database, returns the user password, otherwise returns NULL
     */
    public function select_user() {
        $select = "SELECT * FROM wp_users ORDER BY display_name ASC";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result;
        }
    }

    // --------------------------------------------------------------------

    public function select_user_ebook() {
        if (((filter_input(INPUT_GET, 'tab')) === ('ebook')) && ((filter_input(INPUT_GET, 'sec')) === ('all'))) {
            $select = "SELECT ue.title, ue.type, ue.code,us.user_email, ue.name, ue.description,ue.price, ue.content, us.display_name, ue.status, ebook.name as edital, ue.price FROM user_ebook as ue INNER JOIN wp_users as us ON us.id = ue.id_user LEFT JOIN payment ON ue.code = payment.code_ebook JOIN ebook ON ebook.id = ue.id_ebook WHERE ue.status = 2";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }
    
    public function list_chapters() {
        if (((filter_input(INPUT_GET, 'tab')) === ('chapter')) && ((filter_input(INPUT_GET, 'sec')) === ('list'))) {
            $select = "SELECT DISTINCT user_ebook.id, user_ebook.content, user_ebook.code, wp_users.user_nicename, wp_users.user_email, editor.user_nicename as editor_nicename, ebook.name as edital, user_ebook.title, status_list.name as status 
                    FROM wp_users, wp_users editor,user_ebook, ebook, status_list 
                        WHERE wp_users.ID = user_ebook.id_user 
                            AND editor.ID = user_ebook.id_editor
                            AND user_ebook.id_ebook = ebook.id 
                            AND user_ebook.status = status_list.code
                            AND ativo = true;";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    public function list_editais() {
        if (((filter_input(INPUT_GET, 'tab')) === ('edital')) && ((filter_input(INPUT_GET, 'sec')) === ('list'))) {
            $select = "SELECT DISTINCT 
            ebook.id, ebook.code, ebook.name as nome_edital, 
            editor.user_nicename as editor_nicename, ebook.linkpay, 
            ebook.price, COUNT(user_ebook.id) as qtdCapitulos 
            FROM ebook LEFT JOIN user_ebook
            on user_ebook.id_ebook = ebook.id 
            JOIN wp_users as editor
            ON ebook.id_editor = editor.ID 
            GROUP BY ebook.id
            ORDER BY ebook.id DESC";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    public function list_user_ebook($email = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('user')) && ((filter_input(INPUT_GET, 'sec')) === ('listchapters'))) {
            $select = "SELECT user_ebook.id, wp_users.user_nicename, wp_users.user_email, editor.user_nicename as editor_nicename, ebook.name as edital, status_list.name as status FROM wp_users, wp_users editor,user_ebook, ebook, status_list 
                        WHERE wp_users.ID = user_ebook.id_user 
                            AND editor.ID = user_ebook.id_editor 
                            AND user_ebook.id_ebook = ebook.id 
                            AND user_ebook.status = status_list.code
                            AND wp_users.user_email = '{$email}';";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    public function list_user_chapters($email = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('user')) && ((filter_input(INPUT_GET, 'sec')) === ('listchapters'))) {
            $select = "SELECT user_ebook.id, wp_users.user_nicename, wp_users.user_email, editor.user_nicename as editor_nicename, ebook.name as edital, status_list.name as status FROM wp_users, wp_users editor,user_ebook, ebook, status_list 
                        WHERE wp_users.ID = user_ebook.id_user 
                            AND editor.ID = user_ebook.id_editor 
                            AND user_ebook.id_ebook = ebook.id 
                            AND user_ebook.status = status_list.code
                            AND wp_users.user_email = '{$email}';";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    public function list_edital_chapters($idEbook = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('edital')) && ((filter_input(INPUT_GET, 'sec')) === ('listchapters'))) {
            $select = "SELECT user_ebook.code, user_ebook.id, user_ebook.content, wp_users.user_nicename, wp_users.user_email, editor.user_nicename as editor_nicename, ebook.name as edital, status_list.name as status FROM wp_users, wp_users editor,user_ebook, ebook, status_list 
            WHERE wp_users.ID = user_ebook.id_user 
                AND editor.ID = user_ebook.id_editor 
                AND user_ebook.id_ebook = ebook.id 
                AND user_ebook.status = status_list.code
                AND ebook.id = {$idEbook};";
            $result = $this->db->query($select)->result();
            //if ((count($result)) >= 1) {
                return $result;
            //}
        }
    }


    // --------------------------------------------------------------------

    public function select_user_ebook2($code_ebook = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('ebook')) && ((filter_input(INPUT_GET, 'sec')) === ('edit'))) {
            $select = "SELECT * FROM user_ebook AS ue JOIN wp_users AS us ON us.id = ue.id_user JOIN wp_users AS ur ON ur.id = ue.id_editor WHERE code = '{$code_ebook}' AND status = 6";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    // --------------------------------------------------------------------
    
    public function getImages($code = NULL) {
        $select = "SELECT * FROM photos WHERE code_ebook = '{$code}'";
        $result = $this->db->query($select)->result();
        return $result;
    }
    
    public function getComprovanteSearch($code = NULL) {
        $select = "SELECT proof_payment FROM payment WHERE code_ebook = '{$code}'";
        $result = $this->db->query($select)->result();
        return $result;
    }
    
    // --------------------------------------------------------------------

    public function select_payment() {
        if (((filter_input(INPUT_GET, 'tab')) === ('payment')) && ((filter_input(INPUT_GET, 'sec')) === ('view'))) {
            $select = "SELECT DISTINCT display_name, 
            ebook.name as ebook_name, 
            user_ebook.code, 
            user_email, 
            date_payment, 
            status, 
            proof_payment 
            FROM payment 
            JOIN user_ebook 
            ON payment.code_ebook = user_ebook.code 
            JOIN wp_users 
            ON user_ebook.id_user = wp_users.id 
            JOIN ebook 
            ON user_ebook.id_ebook = ebook.id 
            WHERE user_ebook.status = 3 
            ORDER BY `payment`.`proof_payment` 
            DESC";
            $result = $this->db->query($select)->result();
            if ((count($result)) >= 1) {
                return $result;
            }
        }
    }

    // --------------------------------------------------------------------

    public function select_payment2($code = null) {
        $select = "SELECT * FROM payment WHERE code_ebook = '{$code}'";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result;
        }
    }

    // --------------------------------------------------------------------

    public function insert_payment($code_ebook = NULL) {
        $insert = "INSERT INTO payment (code_ebook) VALUES ('{$code_ebook}')";
        $this->db->query($insert);
    }

    // --------------------------------------------------------------------

    public function update_payment($code_ebook = NULL, $proof_payment = NULL) {
        $update = "UPDATE payment SET code_ebook = '{$code_ebook}', proof_payment = '{$proof_payment}'";
        $this->db->query($update);
    }

    // --------------------------------------------------------------------

    /**
     * Select method
     * 
     * @param   string  $e_mail     The user e-mail
     * 
     * @return  string  If the e-mail exists in the database, returns the user password, otherwise returns NULL
     */
    public function select_editor() {
        $select = "SELECT * FROM wp_users WHERE access_level = 2 OR access_level = 5 ORDER BY ID;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result;
        }
    }
    
    public function select_chapters() {
        $select = "SELECT id, name FROM ebook;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result;
        }
    }
    public function findEmailByCode($code) {
        $select = "SELECT user_email from wp_users JOIN user_ebook ON user_ebook.id_user = wp_users.id AND user_ebook.code = $code;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result[0]->user_email;
        }
    }

    public function select_status() {
        $select = "SELECT * FROM status_list;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            return $result;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Select method
     * 
     * @param   string  $e_mail     The user e-mail
     * 
     * @return  string  If the e-mail exists in the database, returns the user password, otherwise returns NULL
     */
    public function select_capitulo() {
        if (((filter_input(INPUT_GET, 'tab')) === ('ebook') && (filter_input(INPUT_GET, 'sec')) === ('new'))) {
            return array(
                'Pesquisa Experimental ou Epidemiológica' => 'Pesquisa Experimental ou Epidemiológica',
                'Revisão Bibliográfica' => 'Revisão Bibliográfica',
                'Relato de Experiência e Estudo de Caso' => 'Relato de Experiência e Estudo de Caso',
            );
        }
    }

    // --------------------------------------------------------------------

    public function update_user($usrid = NULL, $docum = NULL, $email = NULL, $aclvl = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('user') && (filter_input(INPUT_GET, 'sec')) === ('updt'))) {
            if ((!empty($usrid)) && (!empty($email)) && (!empty($aclvl))) {
                $update = "UPDATE wp_users SET user_email = '{$email}', access_level = '{$aclvl}' WHERE id = '{$usrid}'";
                $this->db->query($update);
            }
        }
    }

    // --------------------------------------------------------------------
    
    public function update_chapter_Mdl($code = NULL, $editor = NULL, $edital = NULL, $status = NULL) {
        if ((!empty($code)) && (!empty($editor)) && (!empty($edital)) && (!empty($status))) {
            $update = "UPDATE user_ebook SET id_ebook = '{$edital}', id_editor = '{$editor}', status = '{$status}' WHERE code = '{$code}'";
            $this->db->query($update);
        }
    }

    public function update_user_ebook($code = NULL, $status = NULL, $disapproved_text = NULL) {
        if (((filter_input(INPUT_GET, 'tab')) === ('ebook') && (filter_input(INPUT_GET, 'sec')) === ('updt'))) {
            if ((!empty($code)) && (!empty($status))) {
                $update = "UPDATE user_ebook SET status = '{$status}', disapproved_text = '{$disapproved_text}' WHERE code = '{$code}'";
                $this->db->query($update);
            }
        }
    }

    public function uploadEbook($code = NULL, $doc = NULL) {
        // var_dump($doc);
        $document = $doc['tmp_name'];
        $length = $doc['size'];
        // $type = $doc['type'];
        // $name = $doc['name'];

        $fp = fopen($document, "rb");
        $content = fread($fp, $length);
        $content = addslashes($content);
        fclose($fp);

        $select = "SELECT * FROM ebook_docs WHERE code_ebook = '{$code}'";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= (1)) {
            $update = "UPDATE ebook_docs SET content = '{$content}', length = '{$length}' WHERE code_ebook = '{$code}'";
            $this->db->query($update);
        } else {
            $create = "INSERT INTO ebook_docs (code_ebook, content, length) VALUES ('{$code}', '{$content}', '{$length}')";
            $this->db->query($create);
        }
        $update = "UPDATE user_ebook SET status = '7' WHERE code = '{$code}'";
        $this->db->query($update);

    }

    public function getDoc($code = NULL) {
        $select = "SELECT user_ebook.title, ed.code_ebook, ed.content, ed.disapproved_text, ed.length FROM ebook_docs as ed JOIN user_ebook on ed.code_ebook = user_ebook.code WHERE code_ebook = $code";
        return $this->db->query($select)->result();
    }
    
    public function getResumoCodigo($code = NULL) {
        $select = "SELECT title, content FROM user_ebook WHERE code = $code";
        return $this->db->query($select)->result();
    }

    // --------------------------------------------------------------------

    /**
     * Select method
     * 
     * @return  string  If the e-mail exists in the database, returns the user password, otherwise returns NULL
     */
    public function user_control($usrid = NULL) {
        $select = "SELECT * FROM wp_users WHERE id = '{$usrid}'";
        $result = $this->db->query($select)->result();
        if ((count($result)) === (1)) {
            return $result[key($result)];
        }
    }

    public function create_user($email, $hashed_password,$name) {
        $data = array(
            'display_name' => $name,
            'user_email' => $email,
            'user_pass' => $hashed_password,
            'user_registered' => date('d-m-y h:i:s'),
        );
        $this->db->insert('wp_users', $data);
    }

    // --------------------------------------------------------------------

    public function save_table($data = NULL){
        $date = date("Y-m-d h:i:s");
        $user = $_SESSION['usrid'];
        $insert = "INSERT into table_save (id, id_user, date, data) VALUES (NULL, '$user', '$date', '$data')";
        $result = $this->db->query($insert);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
    
    public function select_save_tables(){
        $select = "SELECT table_save.id, display_name, date FROM table_save JOIN wp_users on table_save.id_user = wp_users.id ORDER BY id;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }
    
    public function select_table_state($date = NULL){
        $select = "SELECT data FROM table_save WHERE date = '$date'";
        $result = $this->db->query($select)->result();
        print_r($result);
    }

    public function save_xml($xml, $number, $emiter, $destine, $payment_method, $parcel_value, $parcel_date, $observation, $income, $my_account = NULL){
        
        // Se houver método de pagamentos instantaneos como dinheiro e cartão, a data de pagamento recebe a data atual
        if($payment_method == 1 || $payment_method == 3 || $payment_method == 4){ 
            $date = date("Y-m-d");
            $status = 1;
        }else{
            $status = 0;
            $date = NULL;
        }
        
        $this->db->trans_start();
        $query = "INSERT into payment (id, number, id_account, file, emiter, destine, method, observation, income) VALUES (NULL, '$number','$my_account','$xml', '$emiter', '$destine','$payment_method','$observation', '$income')";
        $this->db->query($query);
        $insert_id = $this->db->insert_id();
        
        foreach($parcel_value as $chave => $valor){
            $array_formatado[$chave] = array(
                'id'=> '', 
                'number'=>$number, 
                'parcel_value'=>$valor, 
                'parcel_date'=> $parcel_date[$chave], 
                'id_payment'=> $insert_id,
                'approved_date'=>$date,
                'status'=>$status,
                'insert_date'=> date('Y-m-d H:i:s'),
                'inserted_by'=> $_SESSION['usrid']
            );
        }

        $this->db->insert_batch('payment_date', $array_formatado);
        $this->db->trans_complete();
    }

    public function insert_manual_note($number, $emiter, $destine, $payment_method, $parcel_value, $parcel_date, $observation, $income, $my_account = NULL){
        $this->db->trans_start();
        $this->db->query("INSERT into payment (id, number, id_account, file, emiter, destine, method, observation, income) VALUES (NULL, '$number','$my_account', NULL, '$emiter', '$destine','$payment_method','$observation', '$income')");
        $insert_id = $this->db->insert_id();

        foreach($parcel_value as $chave => $valor){
            $array_formatado[$chave] = array(
                'id'=> NULL, 
                'number'=>$number, 
                'parcel_value'=>$valor, 
                'parcel_date'=> $parcel_date[$chave], 
                'id_payment'=> $insert_id,
                'insert_date'=> date('Y-m-d H:i:s'),
                'inserted_by'=> $_SESSION['usrid']
            );
        }

        $this->db->insert_batch('payment_date', $array_formatado);
        $this->db->trans_complete();
    }
    
    public function select_payments($date = NULL, $income = NULL, $client = NULL, $account = NULL, $status = NULL, $name = NULL, $date_init = NULL, $date_end = NULL){
        if(!isset($date) && !isset($date_init) && !isset($date_init)){
            $date_mouth = date("Y-m");
        }else{
            $date_mouth = $date;
        }
        if($income == NULL){
            $income = 'AND income IS NOT NULL';
        }elseif($income == 'NULL'){
            $income = 'AND income IS NOT NULL';
        }else{
            $income = 'AND income ='.$income;
        };

        if ($client){
            $client = "AND emiter = '$client'";
        };

        if ($account){
            $account = "AND destine = '$account'";
        };

        if ($status != NULL){
            $status = "AND pd.status = $status";
        }

        if ($name != NULL){
            $name = "AND account.name = '$name'";
        }

        $date_selected = NULL;
        if ($date_end != NULL && $date_init != NULL){
            $date_selected = "AND pd.parcel_date BETWEEN '$date_init' AND '$date_end'";
        }


        $select = "SELECT DISTINCT(p.id), IF(pd.parcel_date < CURDATE() AND pd.status = 0, 'late', 'none')  as before_today, pd.approved_date, p.number, p.emiter, p.destine, p.observation, 
        p.method,pd.id as id_payment, pd.parcel_value, account.name as account_name, pd.parcel_date, income.name as income_name, 
        payment_method.name as payment_method, payment_status.name as status 
        FROM payment as p 
        JOIN payment_date as pd on p.id = pd.id_payment 
        JOIN income on income.value = p.income 
        LEFT JOIN payment_method on p.method = payment_method.code
        LEFT JOIN account on p.id_account = account.id
        JOIN payment_status on pd.status = payment_status.code
         WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account $status $name $date_selected ORDER BY pd.parcel_date;";



        $result = $this->db->query($select)->result();
        return $result;
    }

    public function sum_values($date = NULL, $income = NULL, $client = NULL, $account = NULL, $date_init = NULL, $date_end = NULL){
        if(!isset($date_init) && !isset($date_end)){
            $date_mouth = date("Y-m");
        }else{
            $date_mouth = $date;
        }
        if($income == NULL){
            $income = 'AND income IS NOT NULL';
        }elseif($income == 'NULL'){
            $income = 'AND income IS NOT NULL';
        }else{
            $income = 'AND income ='.$income;
        };

        if ($client){
            $client = "AND emiter = '$client'";
        };

        if ($account){
            $account = "AND destine = '$account'";
        };

        $date_selected = NULL;
        if ($date_end != NULL && $date_init != NULL){
            $date_selected = "AND pd.parcel_date BETWEEN '$date_init' AND '$date_end'";
        }

        $select_total_income = "SELECT sum(pd.parcel_value) as total_value FROM payment as p JOIN payment_date as pd on p.id = pd.id_payment JOIN income on income.value = p.income left join payment_method on p.method = payment_method.code WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account $date_selected AND pd.status = 1 AND income = 1;";

        $select_sum = "SELECT sum(pd.parcel_value) as sum FROM payment as p JOIN payment_date as pd on p.id = pd.id_payment JOIN income on income.value = p.income left join payment_method on p.method = payment_method.code WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account $date_selected AND pd.status = 0 AND income = 1;";
        
        $select_sum_to_pay = "SELECT sum(pd.parcel_value) as select_sum_to_pay FROM payment as p JOIN payment_date as pd on p.id = pd.id_payment JOIN income on income.value = p.income left join payment_method on p.method = payment_method.code WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account $date_selected AND pd.status = 0 AND income = 0;";

        $select_sum_payed_query = "SELECT sum(pd.parcel_value) as select_sum_payed FROM payment as p JOIN payment_date as pd on p.id = pd.id_payment JOIN income on income.value = p.income left join payment_method on p.method = payment_method.code WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account $date_selected AND pd.status = 1 AND income = 0;";

        $result_total_income = $this->db->query($select_total_income)->result();
        $result_sum = $this->db->query($select_sum)->result();
        $select_sum_to_pay_query = $this->db->query($select_sum_to_pay)->result();
        $select_sum_payed = $this->db->query($select_sum_payed_query)->result();
        
        return array (
            "total_parcel_value"=> $result_total_income[0]->total_value,
            "sum_parcel_value"=> $result_sum[0]->sum,
            "select_sum_to_pay"=> $select_sum_to_pay_query[0]->select_sum_to_pay,
            "select_sum_payed"=> $select_sum_payed[0]->select_sum_payed
        );



        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function sum_payed_values($date = NULL, $income = NULL, $client = NULL, $account = NULL){
        if(!isset($date) && !isset($date_init) && !isset($date_init)){
            $date_mouth = date("Y-m");
        }else{
            $date_mouth = $date;
        }
        if($income == NULL){
            $income = 'AND income IS NOT NULL';
        }elseif($income == 'NULL'){
            $income = 'AND income IS NOT NULL';
        }else{
            $income = 'AND income ='.$income;
        };

        if ($client){
            $client = "AND emiter = '$client'";
        };

        if ($account){
            $account = "AND destine = '$account'";
        };
        $select = "SELECT sum(pd.parcel_value) as total_parcel_value FROM payment as p JOIN payment_date as pd on p.id = pd.id_payment JOIN income on income.value = p.income left join payment_method on p.method = payment_method.code WHERE pd.parcel_date LIKE 
        '%$date_mouth%' $income $client $account AND pd.status = 1;";

        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function xml_exists($number = NULL){
        $select = "SELECT id from payment where number = $number";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            echo 200;
        }
    }

    public function payment_date_exists($number = NULL, $date = NULL, $date_approved = NULL){
        $select = "SELECT DISTINCT(number), parcel_value, parcel_date from payment_date where number = '$number' AND payment_date.parcel_date = '$date'";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            echo '<p> O pagamento '.$result[0]->number.' no valor de 
            '.number_format((float)$result[0]->parcel_value,2,",",".").' com a data '.date("d/m/Y", strtotime($result[0]->parcel_date)).' está cadastrado e será dado como aprovado.<p>';
            echo '<input name="number[]" type="text" class="form-control" value="'.$result[0]->number.'" hidden readonly>';
            echo '<input name="date[]" type="text" class="form-control" value="'.$result[0]->parcel_date.'" hidden readonly>';
            echo '<input name="date_approved[]" type="text" class="form-control" value="'.$date_approved.'" hidden readonly>';
        }else{
            echo '<p> O pagamento '.$number.' não foi encontrado no sistema.<p>';
        }
    }

    public function update_with_ret($number, $date, $date_approved){
        for ($i = 0; $i < count($number); $i++) {
            $this->db->set('status', 1);
            $this->db->set('approved_date', $date_approved[$i]);
            $this->db->where('number', $number[$i]);
            $this->db->where('parcel_date', $date[$i]);
            $this->db->update('payment_date');
        }
    }

    public function select_client_payment(){
        $select = "SELECT emiter from payment group by emiter";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function select_account_payment(){
        $select = "SELECT destine from payment group by destine";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }
    
    public function select_contas_filter(){
        $select = "SELECT name from account group by name";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }
    
    public function select_status_filter(){
        $select = "SELECT code, name from payment_status";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }
    
    public function getNote($number=NULL, $emiter=NULL){
        $select = 
        "SELECT payment.id as note_id,
        payment_date.id as payment_id,
        payment_date.parcel_date,
        payment_date.parcel_value,
        payment.destine, 
        payment.emiter, 
        payment.id_account, 
        payment_method.name as method,
        payment.observation, 
        payment_status.name as status_name,
        income 
        FROM payment 
        JOIN payment_date 
            ON payment.id = payment_date.id_payment
        left join payment_method 
            on payment.method = payment_method.code
        join payment_status 
            on payment_date.status = payment_status.code
            AND payment.number = $number
        where payment.emiter LIKE '$emiter%'";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            print_r(json_encode($result));
        }
    }

    public function edit_note($number=NULL,$emiter=NULL,$destine=NULL,$account=NULL,$observation=NULL,$array_to_update=NULL){
        $escaped_observation = $this->db->escape("$observation");
        if (isset($account)){
            $account = ',id_account = '.$account;
        }
        $this->db->trans_start();
        $update = "UPDATE payment SET emiter = '$emiter', destine = '$destine', observation = $escaped_observation $account 
        WHERE number = '$number'";
        $result = $this->db->query($update);

        foreach ($array_to_update as $item) {

            $this->db->select('id');
            $this->db->from('payment_date');
            $this->db->where('id', $item['id']);
            $query = $this->db->get();
          
            if ($query->num_rows() > 0) {
              // Update the record if it exists
              $this->db->set('parcel_date', $item['parcel_date']);
              $this->db->where('id', ''.$item['id'].'');
              $this->db->update('payment_date');
            } else {
              // Insert the record if it does not exist
              $data = array(
                'id' => $item['id'],
                'number' => $number,
                'id_payment' => $item['id_payment'],
                'parcel_date' => $item['parcel_date'],
                'parcel_value' => $item['parcel_value']
              );
              print_r($data);
              $this->db->insert('payment_date', $data);
            }
          }

        $this->db->trans_complete();
        return $this->db->affected_rows();
    }

    public function getPayment($id=NULL){
        $select = "SELECT pd.id as payment_id, pd.number, pd.parcel_value, pd.parcel_date, payment_status.code as status_code, payment_status.name as status_name, approved_date 
        FROM payment_date as pd 
        join payment_status on pd.status = payment_status.code
        AND pd.id = '$id'";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            print_r(json_encode($result));
        }
    }

    public function edit_payment($id_edit_payment=NULL,$value_edit_payment=NULL,$date_edit_payment=NULL,$payment_status_edit_payment=NULL, $approved_date = NULL){
        $approved_date = !strlen($approved_date) ? 'NULL' : "'".$approved_date."'";
        $update = "UPDATE payment_date SET parcel_date = '$date_edit_payment', parcel_value = '$value_edit_payment', status = '$payment_status_edit_payment', approved_date = $approved_date WHERE id = '$id_edit_payment'";
        $this->db->query($update);
    }

    public function select_accesses(){
        $select = "SELECT * from login";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function create_login($name,$user,$password,$sistem){
        $insert = "INSERT into login (name,user,password,sistem) VALUES ('$name', '$user', '$password', '$sistem')";
        $result = $this->db->query($insert);
    }

    public function edit_login($id, $name, $user, $password, $sistem){
        $update = "UPDATE login SET name = '$name', user = '$user', password = '$password', sistem = '$sistem' WHERE id = '$id';";
        $result = $this->db->query($update);
    }

    public function select_accounts(){
        $select = "SELECT * from account";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function getPayment_methods(){
        $select = "SELECT * from payment_method";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function parcel_values_to_receive($year = NULL, $companies = NULL){
        $formated_year = isset($year) && $year != NULL ? ('AND YEAR(pd.parcel_date) = '. $year) : NULL;
        sort($companies);
        $formated_companies = isset($companies) ? ('AND p.id_account IN ('. implode(',', $companies).')') : '';
        $formated_companies_2 = 
        $select_query = "SELECT
        t1.month,
        t1.year,
        t3.to_pay,
        t2.to_receive,
        t4.delayed_to_receive,
        t5.expense_value,
        t6.balcony_prevision
        FROM (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year
            FROM payment_date pd 
            where YEAR(pd.parcel_date) = 2023
            GROUP BY month
            ORDER BY year, month
        ) t1
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value),0) AS to_receive
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 0 AND pd.parcel_date >= CURDATE()
            GROUP BY month
            ORDER BY year,month
        ) t2 ON t1.month = t2.month
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value), 0) AS to_pay
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 0 $formated_companies AND pd.status = 0
            GROUP BY month
            ORDER BY year,month
        ) t3 ON t1.month = t3.month
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, SUM(parcel_value) AS delayed_to_receive
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 0 AND pd.parcel_date < CURDATE() AND YEAR(pd.parcel_date) = 2023
            GROUP BY month
            ORDER BY year,month
        ) t4 ON t1.month = t4.month
        LEFT JOIN (
            SELECT MONTH(e.payment_date) AS month, YEAR(e.payment_date) AS year, SUM(value) AS expense_value
            FROM expense e 
            WHERE e.status = 0 AND YEAR(e.payment_date) = 2023
            GROUP BY month
            ORDER BY year,month
        ) t5 ON t1.month = t5.month 
        LEFT JOIN (
            SELECT MONTH(pr.year_month) as month, YEAR(pr.year_month), value as balcony_prevision
            FROM prevision_registred as pr
            WHERE accounts = '".implode(',', $companies)."'
        ) t6 ON t1.month = t6.month ORDER BY year, month";

        //return $select_query;
        return $this->db->query($select_query)->result();

        
    }

    public function parcel_values_to_receive_all_time($year = NULL, $companies = NULL){
        $formated_companies = isset($companies) ? ('AND p.id_account IN ('. implode(',', $companies).')') : '';
        $select_query = "SELECT 
        to_receive_all_time.year, 
        to_receive_all_time.sum_value as to_receive_all_time,
        to_pay_all_time.sum_value as to_pay_all_time,
        delayed_to_receive.sum_value as delayed_to_receive,
        expense_to_receive.expense_value as expense_value,
        prevision_all_time.sum_value as prevision_all_time
      FROM ( 
              SELECT YEAR(parcel_date) as year, SUM(parcel_value) AS sum_value
                  FROM payment_date pd 
                  LEFT JOIN payment p ON p.id = pd.id_payment
                  LEFT JOIN account on p.id_account = account.id
                  WHERE p.income = 1 $formated_companies AND pd.status = 0 AND pd.parcel_date >= CURDATE()
                  GROUP by YEAR(pd.parcel_date)
      ) as to_receive_all_time
      LEFT JOIN (
                  SELECT YEAR(parcel_date) as year, SUM(parcel_value) AS sum_value
                  FROM payment_date pd2 
                  LEFT JOIN payment p ON p.id = pd2.id_payment
                  LEFT JOIN account on p.id_account = account.id
                  WHERE p.income = 0 $formated_companies AND pd2.status = 0
                  GROUP by YEAR(pd2.parcel_date)
      ) as to_pay_all_time
      ON to_receive_all_time.year = to_pay_all_time.year
      LEFT JOIN (
                  SELECT YEAR(parcel_date) as year, SUM(parcel_value) AS sum_value
                  FROM payment_date pd3
                  LEFT JOIN payment p ON p.id = pd3.id_payment
                  LEFT JOIN account on p.id_account = account.id
                  WHERE p.income = 1 $formated_companies AND pd3.status = 0 AND pd3.parcel_date < CURDATE() AND YEAR(pd3.parcel_date) = 2023
                  GROUP by YEAR(pd3.parcel_date)
      ) as delayed_to_receive
      ON to_receive_all_time.year = delayed_to_receive.year
      LEFT JOIN (
                SELECT YEAR(e.payment_date) as year, SUM(e.value) AS expense_value 
                FROM expense e 
                WHERE e.status = 0
                AND YEAR(e.payment_date) = 2023 GROUP by YEAR(e.payment_date)
      ) as expense_to_receive
      ON to_receive_all_time.year = expense_to_receive.year
      LEFT JOIN (
            SELECT MONTH(pr.year_month) as month, YEAR(pr.year_month) as year, sum(value) as sum_value
            FROM prevision_registred as pr
            WHERE accounts = '".implode(',', $companies)."'
            AND YEAR(pr.year_month) = 2023
        ) as prevision_all_time 
       ON to_receive_all_time.year = prevision_all_time.year";
    
        return $this->db->query($select_query)->result();

    }

    public function parcel_values_received($year = NULL, $companies = NULL){
        $formated_year = isset($year) && $year != NULL ? ('AND YEAR(pd.parcel_date) = '. $year) : NULL;
        $formated_companies = isset($companies) ? ('AND p.id_account IN ('. implode(',', $companies).')') : '';
        $select_query = "SELECT
        t1.month,
        t1.year,
        t3.to_pay,
        t2.to_receive,
        t4.received,
        t5.expense_value,
        t6.balcony_value
        FROM (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year
            FROM payment_date pd 
            where YEAR(pd.parcel_date) = 2023
            GROUP BY month
            ORDER BY year, month
        ) t1
        LEFT JOIN (
            SELECT MONTH(pd.approved_date) AS month, YEAR(pd.approved_date) AS year, COALESCE(SUM(parcel_value),0) AS to_receive
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 1 AND pd.approved_date < current_date() AND YEAR(pd.approved_date) = 2023
            GROUP BY month
            ORDER BY year, month
        ) t2 ON t1.month = t2.month
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value), 0) AS to_pay
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 0 $formated_companies AND pd.status = 1
            GROUP BY month
            ORDER BY year, month
        ) t3 ON t1.month = t3.month
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value),0) AS received
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 1 AND pd.parcel_date < NOW()
            GROUP BY month
            ORDER BY year, month
        ) t4 ON t1.month = t4.month
        LEFT JOIN (
            SELECT MONTH(e.approved_date) AS month, YEAR(e.approved_date) AS year, SUM(value) AS expense_value
            FROM expense e 
            WHERE e.status = 1 AND approved_date != '' AND YEAR(e.approved_date) = 2023
            GROUP BY month
            ORDER BY year,month
        ) t5 ON t1.month = t5.month
        LEFT JOIN (
            SELECT 
            MONTH(insert_date) as month,
            YEAR(insert_date) AS year,
            sum(cash) + sum(pix) + sum(card) as balcony_value 
            FROM balcony_values 
            GROUP BY MONTH(insert_date)
        ) t6 ON t1.month = t6.month 
        ORDER BY 
        year,
        month";
        return $this->db->query($select_query)->result();
    }

    public function select_defaulters_companies($companies){
        $formated_companies = isset($companies) ? ('AND payment.id_account IN ('. implode(',', $companies).')') : '';
        $select = "SELECT SUM(parcel_value) as total, YEAR(parcel_date) as year FROM payment_date 
        JOIN payment ON payment.id = payment_date.id_payment
        WHERE parcel_date < CURDATE() 
        AND payment.income = 1
        AND status = 0
        $formated_companies
        GROUP by year
        ORDER by year;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function select_defaulters(){
        $select = "SELECT SUM(parcel_value) as total, YEAR(parcel_date) as year FROM payment_date 
        JOIN payment ON payment.id = payment_date.id_payment
        WHERE parcel_date < CURDATE() 
        AND payment.income = 1
        AND status = 0
        GROUP by year
        ORDER by year;";
        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    /* 
    $formated_year = isset($year) && $year != NULL ? ('AND YEAR(pd.parcel_date) = '. $year) : NULL;
        $formated_companies = isset($companies) ? ('AND p.id_account IN ('. implode(',', $companies).')') : '';
        $select_query = "SELECT
        t1.month,
        t1.year,
        t2.to_pay,
        t1.to_receive,
        t3.delayed_to_receive
        FROM (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value),0) AS to_receive
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 0 AND pd.parcel_date > NOW()
            GROUP BY month
            ORDER BY year, month
        ) t1
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value), 0) AS to_pay
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 0 $formated_companies AND pd.status = 0
            GROUP BY month
            ORDER BY year, month
        ) t2 ON t1.month = t2.month
        LEFT JOIN (
            SELECT MONTH(pd.parcel_date) AS month, YEAR(pd.parcel_date) AS year, COALESCE(SUM(parcel_value),0) AS delayed_to_receive
            FROM payment_date pd 
            LEFT JOIN payment p ON p.id = pd.id_payment
            LEFT JOIN account on p.id_account = account.id
            WHERE p.income = 1 $formated_companies AND pd.status = 0 AND pd.parcel_date < NOW()
            GROUP BY month
            ORDER BY year, month
        ) t3 ON t3.month = t1.month";
    */

    //filter_input(INPUT_GET, 'year')

    public function select_month_payments($month = NULL, $year = NULL){
        $select = "SELECT pd.parcel_date as date,
        SUM(CASE WHEN p.income = 1 THEN pd.parcel_value ELSE 0 END) AS to_receive,
        SUM(CASE WHEN p.income = 0 THEN pd.parcel_value ELSE 0 END) AS to_pay,
        SUM(CASE WHEN p.income = 1 THEN pd.parcel_value ELSE -pd.parcel_value END) AS result,
        CASE WHEN SUM(CASE WHEN p.income = 1 THEN pd.parcel_value ELSE -pd.parcel_value END) < 0 THEN 'late' ELSE 'positive' END AS result_status
        FROM payment p
        INNER JOIN payment_date pd ON p.id = pd.id_payment 
        WHERE MONTH(pd.parcel_date) = '$month' AND YEAR(pd.parcel_date) = '$year' AND pd.status = 0
        GROUP BY DAY(pd.parcel_date)";

        $result = $this->db->query($select)->result();
        if ((count($result)) >= 1) {
            return $result;
        }
    }

    public function select_year_notes(){
        $select = "SELECT YEAR(pd.parcel_date) as year from payment_date as pd GROUP by YEAR(pd.parcel_date)";
        return $this->db->query($select)->result();
    }

    public function account_values(){
        $select = "SELECT * FROM account;";

        $result = $this->db->query($select)->result();

        if ((count($result)) >= 1) {
            return $result;
        }

        /*$this->load->database();

        // Retrieve all accounts from the database
        $accounts = $this->db->get('account')->result_array();

        // Loop over the accounts
        $result_recent_value_row =[]
        foreach ($accounts as $account) {
            $value = $this->db->get_where('account_value', array('id_account' => $account['id']))->row()->value;
            $account['id']

            $aux_query = "SELECT id, id_account, id_user, value, date 
            FROM account_value WHERE id_account = '$account['id']'";
            $result_recent_value_row = $this->db->query($aux_query)->result();

        }?*/


        /*$id_accounts = "SELECT id from account;";
        $result_ids = $this->db->query($id_accounts)->result();

        foreach($result_ids){
            $aux_query = "SELECT id, id_account, id_user, value, date 
            FROM account_value WHERE id_account = '$result_ids->id'";
            $result_recent_value_row = $result_ids = $this->db->query($aux_query)->result();
        }*/

        /*$select = "SELECT a.id, a.name, av.id_account, av.id_user, av.value, av.old_value, av.date
        FROM account a
        LEFT JOIN (
          SELECT id_account, id_user, value, old_value, date, MAX(date) AS max_date
          FROM account_value
          WHERE DATE(date) = '2022-12-28'
          GROUP BY id_account
        ) av ON a.id = av.id_account AND av.date = av.max_date;";
        return $this->db->query($select)->result();*/

        
    }

    public function insert_account_value($id_account=NULL, $value=NULL){
        $this->db->trans_start();
        $dateToday = date('Y-m-d');
        $select = "SELECT value from account_value WHERE DATE(account_value.date) = '" .date('Y-m-d')."' AND id_account='$id_account' ORDER BY id ASC";
        $exists = $this->db->query($select)->last_row();
        if(isset($exists)){
            $old_value = $exists->value;
            $insert = "INSERT INTO account_value (id,id_account,id_user,value,old_value, date) VALUES (NULL,'$id_account','".$_SESSION['usrid']."','$value','$old_value', NOW())";
        }else{
            $insert = "INSERT INTO account_value (id,id_account,id_user,value,old_value, date) VALUES (NULL,'$id_account','".$_SESSION['usrid']."','$value','0', NOW())";
        }
        $result = $this->db->query($insert);

        if ($this->db->trans_status() === FALSE){
            $error = $this->db->error();
            echo 500;
        }else {
            echo 200;
        }

        $this->db->trans_complete();
    }

    public function get_history_account_values(){
        $most_recent = "SELECT *,account.id FROM `account_value` join account on account_value.id_account = account.id where date = (SELECT MAX(date) FROM `account_value`)";
        return $result = $this->db->query($most_recent)->result();
    }

    public function get_sum_historic_acconts_today(){
        $most_recent_bank_values = "SELECT SUM(value) as sum FROM `account_value` join account on account_value.id_account = account.id where date = (SELECT MAX(date) FROM `account_value`)";
        $sum_most_recent_bank_values = $this->db->query($most_recent_bank_values)->result()[0]->sum;

        $most_recent_hands_values = "SELECT SUM(value) as sum FROM `hands_balance` where date = (SELECT MAX(date) FROM `account_value`)";
        $sum_most_recent_hands_values = $this->db->query($most_recent_hands_values)->result()[0]->sum;

        return $sum_most_recent_hands_values + $sum_most_recent_bank_values;
    }

    public function get_history_hands_value_date($date){

        $result_hands_balance = "SELECT date from hands_balance where DATE(date) = '$date' GROUP by date";
        $result_registers = $this->db->query($result_hands_balance)->result();

        $array_result = [];
        foreach($result_registers as $key => $value){
            $date = $value->date;

            $history_per_date = "SELECT * FROM hands_balance where date = '$date'";
            $array_result[$key] = $result = $this->db->query($history_per_date)->result();
        }

        return $array_result;

    }
    public function get_history_account_values_date($date){

        $result_registers_date = "SELECT date from account_value where DATE(date) = '$date' GROUP by date";
        $result_registers = $this->db->query($result_registers_date)->result();

        $array_result = [];
        foreach($result_registers as $key => $value){
            $date = $value->date;

            $history_per_date = "SELECT *,account_value.id as id, wp_users.user_email 
            FROM `account_value` 
            join account on account_value.id_account = account.id
            join wp_users on account_value.id_user = wp_users.id
            where date = '$date'";
            $array_result[$key] = $result = $this->db->query($history_per_date)->result();
        }

        return $array_result;

    }

    //SELECT *,account.id FROM `account_value` join account on account_value.id_account = account.id where DATE(date) = 2023-01-12;

    public function post_account_values($account_ids, $account_values, $hands_value,$antecipation_card){
        $dateTime= date("Y-m-d H:i:s");
        $id_user = $user = $_SESSION['usrid'];

        foreach($account_ids as $chave => $valor){
            $array_formatado[$chave] = array(
                'id_account'=> $account_ids[$chave],
                'id_user'=> $id_user,
                'value'=> $account_values[$chave],
                'date'=> $dateTime
            );
        }
        $insert_hands_value = "INSERT INTO hands_balance (id,name,value,date) VALUES (NULL, 'hands_value', $hands_value, '$dateTime')";
        $insert_antecipation_card = "INSERT INTO hands_balance (id,name,value,date) VALUES (NULL, 'antecipation_card', $antecipation_card, '$dateTime')";

        $this->db->trans_start();
            $this->db->query($insert_hands_value);
            $this->db->query($insert_antecipation_card);
            $this->db->insert_batch('account_value', $array_formatado);
        $this->db->trans_complete();
    }

    public function get_history_hands_balance($name){
        $most_recent = "SELECT * FROM hands_balance WHERE date = (SELECT MAX(date) FROM `hands_balance`) AND name = '$name';";
        return $result = $this->db->query($most_recent)->result();
    }

    public function insert_expense($provider, $value, $payment_date, $approved_date, $description, $status_expense, $expense_type){
        $insert_expense = "INSERT INTO expense (id, provider,value, payment_date, approved_date, description, status, expense_type) 
        VALUES (NULL, '{$provider}','{$value}','{$payment_date}','{$approved_date}','{$description}','{$status_expense}','{$expense_type}')";
        
        $result = $this->db->query($insert_expense);

        if ($result) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error');
        }

        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
    }

    public function update_expense($id, $provider, $value, $payment_date, $approved_date, $description, $status_expense, $expense_type){
        $update = "UPDATE expense SET
        provider = '$provider',
        value = '$value',
        payment_date = '$payment_date',
        approved_date = '$approved_date',
        description = '$description',
        status = '$status_expense',
        expense_type = '$expense_type'
        WHERE id = '$id';";
        
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

    public function get_recents_notes($income){
        $select = "SELECT payment_date.id, payment_date.number, emiter, destine, parcel_value, parcel_date, account.name as account,
         payment_status.name as status 
         from payment join payment_date on payment_date.id_payment = payment.id 
         join account on account.id = payment.id_account 
         join payment_status on payment_status.id = payment_date.status 
         WHERE payment.income = $income
         ORDER BY payment_date.id DESC limit 50";
        
        return $this->db->query($select)->result();
        
    }
    
    public function save_prevision($value,$date,$accounts){
        
        $this->db->where('year_month', $date);
        $this->db->where('accounts', $accounts);
        $query = $this->db->get('prevision_registred');
        $result = $query->row();

        if ($result) {
            $data = array(
                'value' => $value
            );
            $this->db->where('year_month', $date);
            $this->db->where('accounts', $accounts);
            $this->db->update('prevision_registred', $data);
        } else {
            $data = array(
                'value' => $value,
                'year_month' => $date,
                'accounts' => $accounts
            );
            $this->db->insert('prevision_registred', $data);
        }

        
        return ($this->db->affected_rows() > 0);
    }
    
}
