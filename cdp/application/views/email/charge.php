<div class="div_body">
    <div class="content">Notificamos que o pagamento da nota n° <b> <?php echo $number; ?></b> no valor de <b><br>R$<?php echo str_replace(".", ",", $parcel_value); ?></b> com data de 
        vencimento em <b><?php echo date('d/m/Y', strtotime($parcel_date)); ?></b><?php echo $message; ?></br>
        <br>Para segunda via do boleto ou demais informações entre em contato através do email <a href='mailto:faturamento@casadosparafusosvr.com.br'>faturamento@casadosparafusosvr.com.br</a></br>
        ou pelo telefone (24)3029-3745</br><hr style='border-color:black;'>
        Caso já tenha efetuado o pagamento, por favor desconsidere esse email.
    </div>
</div>

<style>
    .div_body{
        background-image: url('<?php echo base_url('assets/images/email/charge_background.jpg');?>');
        width:600px;
        height:700px;
        color: #5a5a5a;
        font-family: Arial, sans-serif;
        font-size: medium;
    }
    .content{
        width:500px;
        padding-left: 50px;
        padding-top: 220px;
    }
</style>