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

<header style="position: fixed; z-index: 1200; width: 100%;">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a href=""><img src="http://editurapasteur.newtisolucoes.com.br/wp-content/uploads/2020/05/PASTEUR-LOGO-SITE.png" alt="" style="position: relative; max-width: 200px; left: -45px; top: 5px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span>Site</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <button type="button" class="navbar-toggler" data-click="sidebar-toggled">
                <span>Menu</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/ebooks/">E-books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/sistema/">Painel do Autor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/quem-somos/">Quem Somos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/faq/">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://editorapasteur.com.br/contato/">Contato</a>
                    </li>
                </ul>
            </div>
        </nav><!--/navbar navbar-expand-lg navbar-light bg-light-->
</header>

<body>
<section>
    <!-- begin #page-container -->
    <div>
        <div class="fade page-sidebar-fixed page-header-fixed show" style="margin: 0px 50px; ">
                <div class="row">
                    <?php foreach ($method->select() as $key => $value) : ?>
                        <div class="col-sm-4">
                            <div class="card" style="min-height:225px; margin-bottom:5%">
                                <!-- style="min-height: 509px;" -->
                                <!--<div style="min-height: 240px; text-align: center;">
                                    <a style="text-align: center;"><img class="card-img-top" style="max-width: 150px;" src="<?php //echo $value->photo; 
                                                                                                                            ?>" data-holder-rendered="true"></a>
                                </div>-->
                                <div class="card-body">
                                    <span class="text-danger codigoEbook"><b><?php echo $value->code; ?></b></span>
                                    <br />
                                    <h6 class="tipoEbook"><?php echo $value->type; ?></h6>
                                    <h5 class="nomeEbook"><?php echo $value->name; ?></h5>
                                    <p><?php echo $value->description; ?></p>
                                    <span class="text-green-darker"><b>R$<?php echo $value->price; ?></b></span>
                                </div>
                                <div class="card-footer bg-light">
                                    <a href="<?php echo base_url()?>"  class="btn btn-sm btn-primary"><i class="ii md-eye"></i>&nbsp;Submeter Resumo</a>
                                    <a href="<?php echo base_url() . 'public/notices/getEdital?code=' . $value->code; ?>" class="btn btn-sm <?php echo empty($value->edital) ? '' : 'btn-success'; ?>"><i class="ii md-eye"></i>&nbsp;Ver Edital</a>
                                </div>
                            </div>
                            <!--/card-->
                        </div>
                    <?php endforeach; ?>
                </div>
                <!--/row-->
        </div>
        <!--/row-->
</section>
</body>

</html>