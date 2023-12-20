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

class Cron_Mdl extends CI_Model {

    /**
     * Constructor method
     *
     * @return  void    No value is returned
     */
    public function __construct() {
        parent::__construct();
    }

    public function demand_late_emails(){
        $select = "SELECT payment.email_destine, payment.number, payment.destine, payment_date.parcel_value, payment_date.parcel_date, payment.emiter FROM `payment` join payment_date on payment.id = payment_date.id_payment where email_destine IS NOT NULL
        AND payment.income = 1 AND payment_date.status = 0 AND DATE(parcel_date) = CURRENT_DATE() - INTERVAL 5 DAY";
        return ($this->db->query($select)->result()); 
    }
    
    public function demand_today_emails(){
        $select = "SELECT payment.email_destine, payment.number, payment.destine, payment_date.parcel_value, payment_date.parcel_date, payment.emiter FROM `payment` join payment_date on payment.id = payment_date.id_payment where email_destine IS NOT NULL
        AND payment.income = 1 AND payment_date.status = 0 AND DATE(parcel_date) = CURRENT_DATE()";
        return ($this->db->query($select)->result()); 
    }
    
    public function demand_future_emails(){
        $select = "SELECT payment.email_destine, payment.number, payment.destine, payment_date.parcel_value, payment_date.parcel_date, payment.emiter FROM `payment` join payment_date on payment.id = payment_date.id_payment where email_destine IS NOT NULL
        AND payment.income = 1 AND payment_date.status = 0 AND DATE(parcel_date) = CURRENT_DATE() + INTERVAL 3 DAY";
        return ($this->db->query($select)->result()); 
    }
}