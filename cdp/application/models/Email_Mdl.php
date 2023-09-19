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

class Email_Mdl extends CI_Model {

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
        $this->load->library('email');
    }

    public function email_init(){
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'br590.hostgator.com.br';
        $config['smtp_port']    = '587';
        $config['smtp_timeout'] = '30';

        $config['smtp_user']    = 'no-reply@casadosparafusosbm.com.br';    //Important
        $config['smtp_pass']    = 'No@Reply0604';  //Important

        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $this->email->initialize($config);
    }

    public function send_email_no_connection($email, $subject, $message) {
    $from = "no-reply@casadosparafusosbm.com.br";
    $this->email->set_mailtype("html");
    $this->email->from($from);
    $this->email->to($email);
    $this->email->bcc($from);
    $this->email->subject($subject);
    $this->email->message($message);
    $this->email->send();
    }

    public function email_close(){
        $this->email->clear();
    }
}
