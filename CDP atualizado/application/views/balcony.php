<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section >
    <!-- begin #page-container page builder -->
    <div id="page-container" class="fade page-sidebar-fixed page-sidebar-toggled">
        <?php $this->load->view('navigation'); ?>
		<?php if (filter_input(INPUT_GET, 'tab') == 'box_control') : ?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/library/jquery.maskMoney.min.js') . "'></script>");?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/balcony/box_control.js') . "'></script>");?>
			<div class="content" style="padding-top:5px;">
				<div class="col-lg-12">
				<div class="floating-message"></div>
					<div class="row">
						<div class="row justify-content-between col-12">
							<div class="col-4">
							Troco gaveta: 250,00
							</div>
							<div class="col-4">
							Data: <?php echo date('d/m/Y');?>
							</div>
						</div>
					</div>
					<hr style="margin-top:0px;">
					<div class="row">
						<?php $sums = $method->select_user_branch()["sums"]; ?>
						<?php foreach ($method->select_user_branch()["users"] AS $key => $value): ?>
							<div class="col-4">
								<h6 style="font-size:13px;"><?php echo $value->display_name; ?></h6>
								<hr style="margin: 3px 0 3px 0px;">
								<div class="row" data-seller-id-row="<?php echo $value->id;?>">
									<!--<p class="col-3"><b>Dinheiro<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->cash,2,",",".") : "00,00"; ?></b></p>
									<p class="col-3"><b>Cartão<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->card,2,",",".") : "00,00";; ?></b></p>
									<p class="col-3"><b>Pix<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->pix,2,",",".") : "00,00"; ?></b></p> -->
								</div>
								<div class="table-responsive" style="min-height:400px; overflow-y: auto; height:150px;">
									<table data-seller-id="<?php echo $value->id;?>" data-branch-id="<?php echo $value->branch_id;?>" class="table table-striped m-b-0">
										<tbody class="table-body-content-editable"  data-seller-id="<?php echo $value->id;?>">
										</tbody>
									</table>
									<br>
								</div>
								<div class="justify-content-end col-12 row" style="margin-top:2%;">
									<a href="#modal_add_balcony_value" data-toggle="modal" style="color:white" onclick="add_row('<?php echo $value->id;?>', '<?php echo $value->branch_id;?>')"class="btn btn-success">+</a>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<br>
					<hr style="margin: 5px 0 5px 0;">
					<div class="row">
						<div class="col-4">
							<table class="table table-striped m-b-0">
								<thead>
									<tr><h6>RESUMO VENDAS</h6></tr>
								</thead>
								<tbody>
									<tr>
										<td>Dinheiro</td>
										<td id="sum_cash"></td>
									</tr>
									<tr>
										<td>Cartão</td>
										<td id="sum_card"></td>
									</tr>
									<tr>
										<td>Pix</td>
										<td id ="sum_pix"></td>
									</tr>
									<tr>
										<td>TOTAL VENDA:</td>
										<td id="total"></td>
									</tr>
									<tr>
										<td>Clientes Atendidos:</td>
										<td id="client_number"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-4">
							<table class="table table-striped m-b-0">
								<thead>
									<tr><h6>FECHAMENTO</h6></tr>
								</thead>
								<tbody>
									<tr>
										<td>Acréscimo</td>
										<td id="increase_value" onblur="change_increase(event,'increase')" contenteditable="true">&nbsp;</td>
									</tr>
									<tr>
										<td>VENDA DINHEIRO</td>
										<td id="total_cash">-</td>
									</tr>
									<tr>
										<td>DESPESAS</td>
										<td id="total_expense">-</td>
									</tr>
									<tr>
										<td>RETIRADO:</td>
										<td id="removed_value" onblur="change_increase(event,'removed')" contenteditable="true">-</td>
									</tr>
									<tr>
										<td>À RETIRAR:</td>
										<td id="to_retrieve">-</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-4">
							<h6>DESPESAS</h6>
							<div style="overflow-y: auto; height:150px;">
								<table class="table table-striped m-b-0">
									<tbody id="expenses_list">
									</tbody>
								</table>
							</div>
							<div class="justify-content-end col-12 row" style="margin-top:2%;">
								<a href="#modal_add_balcony_expense" data-toggle="modal" style="color:white" onclick="add_row('<?php echo isset($value) ? $value->id : '';?>', '<?php echo isset($value) ? $value->branch_id : '';?>')"class="btn btn-success">+</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal_add_balcony_expense" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_add_balcony_expense" onsubmit="return handle_submit_balcony_expense(event,'<?php print_r($method->select_user_branch()['users'][0]->branch_id);?>')">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Descrição:</b></label>
									<div class="input-group m-b-10">
										<input type="text" name="balcony_add_expense_provider" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Valor:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_add_expense_value" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
									<a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal_add_balcony_value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_add_valcony" onsubmit="return handle_submit_balcony_value(event)">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Dinheiro:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_cash_add" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Cartão:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_card_add" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for=""><b>Pix:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_pix_add" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
									<a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>	
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal-edit-value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_edit_balcony_value">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Dinheiro:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_cash_edit" type="text" name="balcony_cash_edit" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Cartão:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_card_edit" type="text" name="balcony_card_edit" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for=""><b>Pix:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_pix_edit" type="text" name="balcony_pix_edit" class="form-control">
									</div>
								</div>
								<hr>
								<div class="modal-footer">
									<a style="color:white; margin: 0 50px 0 0;" onclick="handle_delete_balcony_value()" name="delete_button" class="btn btn-danger"><i class="ii ios-paper-plane"></i>&nbsp;Excluir</a>
									<a style="color:white" onclick="handle_edit_balcony_value(event)" name="save_button" class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</a>
									<a style="color:white" href="javascript:;" style="margin: 0 10px 0 10px;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal-edit-expense-value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_edit_expense_value">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Descrição:</b></label>
									<div class="input-group m-b-10">
										<input id="balcony_expense_edit_provider" type="text" name="balcony_expense_edit_provider" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Valor:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_expense_edit_value" type="text" name="balcony_expense_edit_value" class="form-control">
									</div>
								</div>
								<hr>
							<div class="modal-footer">
								<a style="color:white; margin: 0 50px 0 0;" onclick="handle_delete_expense()" name="delete_button" class="btn btn-danger"><i class="ii ios-paper-plane"></i>&nbsp;Excluir</a>
								<a style="color:white" onclick="handle_edit_expense_value(event)" name="save_button" class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</a>
								<a style="color:white" href="javascript:;" style="margin: 0 10px 0 10px;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endif;?>
		<?php if (filter_input(INPUT_GET, 'tab') == 'box_see' ) : ?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/library/jquery.maskMoney.min.js') . "'></script>");?>
			<?php echo("<script type='text/javascript' src='" . base_url('assets/js/balcony/box_control.js') . "'></script>");?>
			<div class="content" style="padding-top:5px;">
				<div class="col-lg-12">
				<div class="floating-message"></div>
					<div class="row">
						<div class="row justify-content-between col-12">
							<div class="col-4">
							Troco gaveta: 250,00
							</div>
							<div class="col-4 row">
								<input type="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');?>" 
								onchange="select_date(event)" class="form-control col-6">
							</div>
						</div>
					</div>
					<hr style="margin-top:0px;">
					<div class="row">
						<?php $sums = $method->select_user_branch()["sums"]; ?>
						<?php foreach ($method->select_user_branch()["users"] AS $key => $value): ?>
							<div class="col-4">
								<h6 style="font-size:13px;"><?php echo $value->display_name; ?></h6>
								<hr style="margin: 3px 0 3px 0px;">
								<div class="row" data-seller-id-row="<?php echo $value->id;?>">
									<!--<p class="col-3"><b>Dinheiro<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->cash,2,",",".") : "00,00"; ?></b></p>
									<p class="col-3"><b>Cartão<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->card,2,",",".") : "00,00";; ?></b></p>
									<p class="col-3"><b>Pix<br>R$<?php echo isset($sums[$key]) ? number_format((float)$sums[$key]->pix,2,",",".") : "00,00"; ?></b></p> -->
								</div>
								<div class="table-responsive" style="min-height:400px; overflow-y: auto; height:150px;">
									<table data-seller-id="<?php echo $value->id;?>" data-branch-id="<?php echo $value->branch_id;?>" class="table table-striped m-b-0">
										<tbody class="table-body-content-editable"  data-seller-id="<?php echo $value->id;?>">
										</tbody>
									</table>
									<br>
								</div>
								<!-- <div class="justify-content-end col-12 row" style="margin-top:2%;">
									<a href="#modal_add_balcony_value" data-toggle="modal" style="color:white" onclick="add_row('<?php echo $value->id;?>', '<?php echo $value->branch_id;?>')"class="btn btn-success">+</a>
								</div> -->
							</div>
						<?php endforeach; ?>
					</div>
					<br>
					<hr style="margin: 5px 0 5px 0;">
					<div class="row">
						<div class="col-4">
							<table class="table table-striped m-b-0">
								<thead>
									<tr><h6>RESUMO VENDAS</h6></tr>
								</thead>
								<tbody>
									<tr>
										<td>Dinheiro</td>
										<td id="sum_cash"></td>
									</tr>
									<tr>
										<td>Cartão</td>
										<td id="sum_card"></td>
									</tr>
									<tr>
										<td>Pix</td>
										<td id ="sum_pix"></td>
									</tr>
									<tr>
										<td>TOTAL VENDA:</td>
										<td id="total"></td>
									</tr>
									<tr>
										<td>Clientes Atendidos:</td>
										<td id="client_number"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-4">
							<table class="table table-striped m-b-0">
								<thead>
									<tr><h6>FECHAMENTO</h6></tr>
								</thead>
								<tbody>
									<tr>
										<td>Acréscimo</td>
										<td id="increase_value" onblur="change_increase(event,'increase')">&nbsp;</td>
									</tr>
									<tr>
										<td>VENDA DINHEIRO</td>
										<td id="total_cash">-</td>
									</tr>
									<tr>
										<td>DESPESAS</td>
										<td id="total_expense">-</td>
									</tr>
									<tr>
										<td>RETIRADO:</td>
										<td id="removed_value" onblur="change_increase(event,'removed')">-</td>
									</tr>
									<tr>
										<td>À RETIRAR:</td>
										<td id="to_retrieve">-</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-4">
							<h6>DESPESAS</h6>
							<div style="overflow-y: auto; height:150px;">
								<table class="table table-striped m-b-0">
									<tbody id="expenses_list">
									</tbody>
								</table>
							</div>
							<!-- <div class="justify-content-end col-12 row" style="margin-top:2%;">
								<a href="#modal_add_balcony_expense" data-toggle="modal" style="color:white" onclick="add_row('<?php echo $value->id;?>', '<?php echo $value->branch_id;?>')"class="btn btn-success">+</a>
							</div> -->
						</div>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal_add_balcony_expense" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_add_balcony_expense" onsubmit="return handle_submit_balcony_expense(event,'<?php print_r($method->select_user_branch()['users'][0]->branch_id);?>')">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Descrição:</b></label>
									<div class="input-group m-b-10">
										<input type="text" name="balcony_add_expense_provider" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Valor:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_add_expense_value" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
									<a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal_add_balcony_value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_add_valcony" onsubmit="return handle_submit_balcony_value(event)">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Dinheiro:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_cash_add" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Cartão:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_card_add" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for=""><b>Pix:</b></label>
									<div class="input-group m-b-10 col-4">
										<input placeholder="00,00" type="text" name="balcony_pix_add" class="form-control">
									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
									<a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>	
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal-edit-value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_edit_balcony_value">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Dinheiro:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_cash_edit" type="text" name="balcony_cash_edit" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Cartão:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_card_edit" type="text" name="balcony_card_edit" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for=""><b>Pix:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_pix_edit" type="text" name="balcony_pix_edit" class="form-control">
									</div>
								</div>
								<hr>
								<div class="modal-footer">
									<a style="color:white; margin: 0 50px 0 0;" onclick="handle_delete_balcony_value()" name="delete_button" class="btn btn-danger"><i class="ii ios-paper-plane"></i>&nbsp;Excluir</a>
									<a style="color:white" onclick="handle_edit_balcony_value(event)" name="save_button" class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</a>
									<a style="color:white" href="javascript:;" style="margin: 0 10px 0 10px;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal modal-message fade" id="modal-edit-expense-value" style="padding: 75px 17px 17px 30px;">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" id="form_edit_expense_value">
							<div class="modal-body">
								<hr>
								<div class="form-group">
								<label for=""><b >Descrição:</b></label>
									<div class="input-group m-b-10">
										<input id="balcony_expense_edit_provider" type="text" name="balcony_expense_edit_provider" class="form-control">
									</div>
								</div>    
								<div class="form-group">
									<label for=""><b >Valor:</b></label>
									<div class="input-group m-b-10 col-4">
										<input id="balcony_expense_edit_value" type="text" name="balcony_expense_edit_value" class="form-control">
									</div>
								</div>
								<hr>
							<div class="modal-footer">
								<a style="color:white; margin: 0 50px 0 0;" onclick="handle_delete_expense()" name="delete_button" class="btn btn-danger"><i class="ii ios-paper-plane"></i>&nbsp;Excluir</a>
								<a style="color:white" onclick="handle_edit_expense_value(event)" name="save_button" class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</a>
								<a style="color:white" href="javascript:;" style="margin: 0 10px 0 10px;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endif;?>
    </div>
</section>


		