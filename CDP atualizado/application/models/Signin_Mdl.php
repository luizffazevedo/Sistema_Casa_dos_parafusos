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

class Signin_Mdl extends CI_Model {

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
     * Select method
     * 
     * @param   string  $e_mail     The user e-mail
     * 
     * @return  string  If the e-mail exists in the database, returns the user password, otherwise returns NULL
     */
    public function select($e_mail = NULL) {
        if ((!empty($e_mail))) {
            $select = "SELECT * FROM wp_users WHERE user_email = '{$e_mail}'";
            $result = $this->db->query($select)->result();
            if ((count($result)) === (1)) {
                return $result[key($result)];
            }
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

    public function update_password_user($email, $hashed_password) {
        if ((!empty($email)) && (!empty($hashed_password))) {
            $update = "UPDATE wp_users SET user_pass = '{$hashed_password}' WHERE user_email = '{$email}'";
            $this->db->query($update);
        }
    }

    // --------------------------------------------------------------------
}
