<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/e/bycgnlmmcg.css'); ?>">
<style></style>

    <div id="sidebar" class="sidebar sidebar-custom">
    <img src="<?php echo base_url('assets/images/logo_cdp.png'); ?>" class="image-logo-top" alt="">
    <br>
        <div data-scrollbar="true" data-height="100%">
            <ul class="nav">
                <li class="nav-profile">
                    <div>
                        <div class="info">
                            <b>
                                <?php
                                if ((session_status()) !== (2)) {
                                    session_start();
                                }
                                echo $_SESSION['full_name'];
                                ?>
                            </b>
                            <?php if (($method->user_control($_SESSION['usrid'])->access_level) == (3)) : ?>
                                <small>Administrador</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="nav">
                <!-- <li class="nav-header">
                    <h5>Navegação</h5>
                <hr style="border-top: 1px solid white; margin: 2%;" />
                </li> -->
                <br>
                <?php $access_level = $method->user_control($_SESSION['usrid'])->access_level; ?>
                <?php if ($access_level == 3 || $access_level == 2) : ?>
                    <li class="has-sub">
                        <a href="javascript:void(0);">
                            <i class="ii"><ion-icon name="cash"></ion-icon></i>
                            <span>Demonstrativo</span>
                        </a>
                        <ul class="sub-menu">
                            <?php if ($access_level == 3) : ?>
                            <li><a href="<?php echo base_url('setting?tab=demonstrative&year='.date('Y')); ?>"><i class="ii ios-cash text-theme"></i> Fluxo de caixa</a></li>
                            <li><a href="<?php echo base_url('setting?tab=bank_values'); ?>"><i class="ii ios-cash text-theme"></i> Saldo bancário</a></li>
                            <?php endif;?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($access_level == 3 || $access_level == 2) : ?>
                    <li class="has-sub">
                        <a href="javascript:void(0);">
                            <i class="ii"><ion-icon name="bar-chart-outline"></ion-icon></i>
                            <span>Dashboard</span>
                        </a> 
                        <ul class="sub-menu">
                            <li><a href="<?php echo base_url('dashboard?tab=general'); ?>"><i class="ii ios-cog text-theme"></i> Geral</a></li>
                            <li><a href="<?php echo base_url('dashboard?tab=entries_historic'); ?>"><i class="ii ios-cash text-theme"></i> Hist. Entradas</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($access_level == 3 || $access_level == 2) : ?>
                    <li class="has-sub">
                        <a href="javascript:void(0);">
                            <i class="ii md-cog"></i>
                            <span>Administração</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo base_url('setting?tab=receivements&sec=view&income=1'); ?>"><i class="ii ios-cash text-theme"></i> A Receber</a></li>
                            <li><a href="<?php echo base_url('setting?tab=payments&sec=view&income=0'); ?>"><i class="ii ios-cash text-theme"></i> A Pagar</a></li>
                            <li><a href="<?php echo base_url('setting?tab=expenses&sec=list'); ?>"><i class="ii ios-cash text-theme"></i> Despesas</a></li>
                            <?php if ($access_level == 3) : ?>
                            <li><a href="<?php echo base_url('setting?tab=product&sec=import'); ?>"><i class="ii ios-card text-theme"></i> Import Ao3</a></li>
                            <li><a href="<?php echo base_url('setting?tab=user&sec=view'); ?>"><i class="ii ios-people text-theme"></i> Usuários</a></li>
                            <li><a href="<?php echo base_url('setting?tab=logins&sec=all'); ?>"><i class="ii ios-people text-theme"></i> Acessos</a></li>
                            <?php endif;?>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if ($access_level == 3 || $access_level == 4) : ?>
                    <li class="has-sub">
                        <a href="javascript:void(0);">
                            <i class="ii"><ion-icon name="storefront-outline"></ion-icon></ion-icon></i>
                            <span>Caixa</span>
                        </a>
                        <ul class="sub-menu">
                            <?php if ($access_level == 3) : ?>
                                <li><a href="<?php echo base_url('balcony?tab=box_see&balcony=1&date='.date('Y-m-d'))?>">Barra Mansa</a>
                                <li><a href="<?php echo base_url('balcony?tab=box_see&balcony=2&date='.date('Y-m-d'))?>">Volta Redonda AM</a>
                                <li><a href="<?php echo base_url('balcony?tab=box_see&balcony=3&date='.date('Y-m-d'))?>">Volta Redonda Ret</a>
                            <?php endif; ?>
                            <?php if ($access_level == 4) : ?>
                            <li><a href="<?php echo base_url('balcony?tab=box_control')?>">Controle de caixa</a>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="<?php echo base_url('logout'); ?>">
                        <i class="ii ios-log-out"></i>
                        <span>Sair</span>
                    </a>
                </li>
                <!-- begin sidebar minify button -->
                <li><a href="javascript:void(0);" class="sidebar-minify-btn" data-click="sidebar-minify"><i style="color:blue" class="ii ios-arrow-back"></i> <span>Reduzir</span></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
<!-- end #sidebar -->