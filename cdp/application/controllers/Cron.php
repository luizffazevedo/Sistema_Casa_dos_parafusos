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

class Cron extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Cron_Mdl', 'cron_mdl');
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
        $this->buffer(array('method' => $this->cron_mdl));
        $this->render(array('output' => 'cron'));
    }


    // --------------------------------------------------------------------
    public function demand_late_charges(){
        $secret = filter_input(INPUT_POST, 'secret');
        if($secret == "25b33939-8334-4a4a-8329-75b03927857a"){
            $late_emails = $this->cron_mdl->demand_late_emails();
            print_r($late_emails);
            $this->email_mdl->email_init();
            foreach ($late_emails as $email){
                $email->message = " não foi identificado e está em atraso de 3 dias.";
                $email_body = $this->load->view('email/charge', $email, TRUE);
                $this->email_mdl->send_email_no_connection($email->email_destine, "Informamos que a nota n°".$email->number." está em atraso de 5 dias - ".$email->destine, $email_body);
                sleep(2); 
            }
            $this->email_mdl->email_close();
        }
    }

    public function demand_today_charges(){
        $secret = filter_input(INPUT_POST, 'secret');
        if($secret == "25b33939-8334-4a4a-8329-75b03927857a"){
            $today_emails = $this->cron_mdl->demand_today_emails();
            print_r($today_emails);
            $this->email_mdl->email_init();
            foreach ($today_emails as $email){
                $email->message = " vence <b>hoje</b>.";
                $email_body = $this->load->view('email/charge', $email, TRUE);
                $this->email_mdl->send_email_no_connection($email->email_destine, "O pagamento da nota n°".$email->number." vence hoje! - ".$email->destine, $email_body); 
                sleep(2);
            }
            $this->email_mdl->email_close();
        }
    }

    public function demand_future_charges(){
        $secret = filter_input(INPUT_POST, 'secret');
        if($secret == "25b33939-8334-4a4a-8329-75b03927857a"){
            $future_emails = $this->cron_mdl->demand_future_emails();
            print_r($future_emails);
            $this->email_mdl->email_init();
            foreach ($future_emails as $email){
                $email->message = " vencerá em três dias.";
                $email_body = $this->load->view('email/charge', $email, TRUE);
                $this->email_mdl->send_email_no_connection($email->email_destine, "Lembrete de vencimento da nota n°".$email->number." em 3 dias - ".$email->destine, $email_body); 
                sleep(2);
            }
            $this->email_mdl->email_close();
        }
    }

    public function process_email(){
        /*$subjects = filter_input(INPUT_POST,'text');
        $this->output->set_content_type('application/json')->set_output(json_encode($subjects));*/
        
        $requestBody = file_get_contents("php://input");        
        file_put_contents('assets/received.txt', $requestBody);

        $response = array(
            'status' => 'success',
            'message' => 'Email received and processed successfully'
        );

        // Converte a resposta em JSON e envia de volta
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
