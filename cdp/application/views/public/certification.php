<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?php echo lang('lang'); ?>">

<head>
    <meta charset="UTF-8">
    <title>Editora Pasteur</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="An open source application development framework for PHP">
    <meta name="keywords" content="codeigniter, development, framework">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="">
    <link rel="canonical" href="<?php echo base_url(''); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="https://editorapasteur.com.br/wp-content/uploads/2019/07/cropped-editora_LOGO01-32x32.jpg">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/f/sample.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/a/dozxgmrxcx.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/c/ybxydmjbnh.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/d/bycgnlmmcg.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e/bycgnlmmcg.css'); ?>">
</head>

<body>
    <section>
        <div id="page-container" class="fade show">
            <div class="login login-v2 animated fadeIn" data-pageload-addclass="animated fadeIn">
                <div class="login-header">
                    <div class="brand">
                        <span style="background-color: transparent; border: 1.5px solid #353535; border-radius: 10px; padding: 5px; color: #353535;">Validar Certificado</span>
                    </div>
                </div>
                <br>
                <div class="login-content">
                    <form onsubmit="validarCertificadoDOI(event); return false;" class="margin-bottom-0">
                        <h2><b>Carta de Publicação</b></h2>
                        <div class="form-group m-b-20">
                            <p style="font-size:14px; color:black;"><b>DOI do capítulo:</b></p>
                            <input id="doiCertification" placeholder="10.29327/545733.2-21" type="text" name="code" class="form-control form-control-lg" required="">
                        </div>
                        <div class="form-group m-b-20">
                            <button class="btn btn-success btn-block btn-lg">Validar</button>
                        </div>
                    </form>
                    <hr>
                    <h3>Carta de Aceite</h3>
                    <form id="formValidateCertification" onsubmit="validarCertificado(event); return false;" class="margin-bottom-0">
                        <div class="form-group m-b-20">
                            <p style="font-size:14px; color:black;"><b>Código na certificação:</b></p>
                            <input id="codeCertification" type="text" name="code" class="form-control form-control-lg" required="">
                        </div>
                        <div class="form-group m-b-20">
                            <p style="font-size:14px; color:black;"><b>Mes e ano:</b></p>
                            <input id="date_emission" type="month" name="date_emission" class="form-control form-control-lg" required="">
                        </div>
                        <div class="form-group m-b-20">
                            <button class="btn btn-success btn-block btn-lg">Validar</button>
                        </div>
                    </form>
                </div>
                <div style="color:black" id="alerta-result" class="alert alert-success" role="alert" hidden>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="<?php echo base_url('assets/js/b/scnhwbmzpi.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/c/ybxydmjbnh.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/e/advimjgnmd.js'); ?>"></script>
</body>

</html>