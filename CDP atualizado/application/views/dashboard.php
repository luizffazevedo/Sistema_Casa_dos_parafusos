<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section >
    <!-- begin #page-container page builder -->
    <div id="page-container" class="fade page-sidebar-fixed page-sidebar-toggled">
        <?php $this->load->view('navigation'); ?>
		<?php if (filter_input(INPUT_GET, 'tab') == 'general') : ?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/dashboard/general.js?version=0.0.7') . "'></script>");?>
			<div class="content" style="padding-top:15px;">
				<div class="col-lg-12 row">
					<div class="col-sm-12 row"style="margin-bottom:1%;">
						<!--<div class="col-2 offset-md-10"><h6><?php echo date('d/m/Y') ?></h6></div>-->
						<div class="warp row col-md-6">
							<div class="col-12 row">
								<div class="col-6">
									<h6>Contas / Fornecedor a Realizar</h6>
								</div>
								<div class="col-6">
									<h6>Contas / Fornecedor Realizado</h6>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">A Receber</h6>
									<h5 id="to_receive" style="color:green"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">A Pagar</h6>
									<h5 id="to_pay" style="color:gray"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">Realizado</h6>
									<h5 id="received" style="color:green"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">Pago</h6>
									<h5 id="payied" style="color:gray"></h5>
								</div>
							</div>
						</div>
						<div class="warp row col-md-6" style="margin-left:1%;">
							<div class="col-12 row">
								<div class="col-6">
									<h6>Venda Balcão</h6>
								</div>
								<div class="col-6">
									<h6></h6>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">Venda Total</h6>
									<h5 id="total_balcony" style="color:green"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">A Retirar</h6>
									<h5 id="to_remove" style="color:green"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">Retirado</h6>
									<h5 id="removed" style="color:green"></h5>
								</div>
							</div>
							<div class="card col-md-3 dash-card">
								<div class="card-body">
									<h6 class="card-title">Despesas</h6>
									<h5 id="expense_value" style="color:gray"></h5>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 row dashbord-card-border">
						<div class="col-5" style="padding-top:1%; padding-left:1;">
							<h5>Venda Balcão</h5>
						</div>
						<div class="col-12" id="balony_valyes_chart" ></div>
					</div>
					<div class="col-8 row dashbord-card-border">
						<div class="col-5" style="padding-top:1%; padding-left:1;">
							<h5>Atendimentos / Dia</h5>
						</div>
						<div class="col-12" id="presence_chart" ></div>
					</div>
					<div class="col-4 row dashbord-card-border" style="margin-left:1%;">
						<div class="col-12" id="expense_chart"></div>
					</div>
				</div>
				<div class="col-lg-12 row">
					
				</div>
			</div>
		<?php endif;?>
		<?php if (filter_input(INPUT_GET, 'tab') == 'entries_historic') : ?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/dashboard/entries_historic.js?version=0.0.8') . "'></script>");?>
			<div class="content" style="padding-top:15px;">
				<div class="col-lg-12 row">
					<div class="col-12 row dashbord-card-border">
						<div class="col-5" style="padding-top:1%; padding-left:1;">
							<h5>Entrada de notas</h5> 
						</div>
						<div class="col-12" id="entries_historic" ></div>
					</div>
					<div class="col-12 row dashbord-card-border">
						<div class="col-5" style="padding-top:1%; padding-left:1;">
							<h5>Entrada de notas</h5> 
						</div>
						<div class="col-12" id="entries_historic_payment" ></div>
					</div>
				</div>
			</div>
		<?php endif;?>
    </div>
</section>


		