<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section >
    <!-- begin #page-container page builder -->
    <div id="page-container" class="fade page-sidebar-fixed page-sidebar-toggled">
        <?php $this->load->view('navigation'); ?>
        <div class="content">
        <div class="floating-message"></div>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('product') && (filter_input(INPUT_GET, 'sec')) === ('import')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-4">
                                <input class="form-control" type="file" onchange=read(this)>
                            </div>
                            <div class="col-2">
                                <button onclick="exportToExcel()" class="btn btn-success col-12">Exportar para Bling</button>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary col-12" onclick="saveTable()">Salvar Versão</button>
                            </div>
                            <div class="col-2">
                                <select class="form-group" onchange="select_table_state(event)" style="width:200px; height:35px;">
                                    <option selected="true" disabled="disabled">Selecionar Versão</option>    
                                    <?php foreach ($method->select_save_tables() AS $key => $value): ?>
                                        <option value="<?php echo $value->date; ?>"><?php echo $value->date; ?> - <?php echo $value->display_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div >
                            <div class="table-responsive">
                                <table class="table table-striped m-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Selecionar</th>
                                            <th>SKU</th>
                                            <th>Descricao</th>
                                            <th>Preço de custo</th>
                                            <th>Preço</th>
                                            <th>Categoria</th>
                                            <th>Marcap</th>
                                            <th>Valor Final</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="import_table_products">
                                        
                                        <!--<?php foreach ($method->select_user(key($method->select_user())) as $key => $value): ?>
                                            <tr id="<?php echo $value->ID ?>">
                                                <td contenteditable="true" class="idUserList"><?php echo $value->ID; ?></td>
                                                <td class="nomeUserList"><?php echo $value->display_name; ?></td>
                                                <td class="emailUserList"><?php echo $value->user_email; ?></td>
                                                <?php if (($value->access_level) == (1)): ?>
                                                    <td class="acessoUserList">Escritor</td>
                                                <?php endif; ?>
                                                <?php if (($value->access_level) == (2)): ?>
                                                    <td class="acessoUserList">Editor</td>
                                                <?php endif; ?>
                                                <?php if (($value->access_level) == (3)): ?>
                                                    <td class="acessoUserList">Administrador</td>
                                                <?php endif; ?>
                                                <td class="with-btn" nowrap=""><a href="#modal-message" onclick="fillModalEditUser()" class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>"><i class="ii ios-create"></i>&nbsp;Editar</a></td>
                                            </tr>
                                        <?php endforeach; ?> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('payments') && (filter_input(INPUT_GET, 'sec')) === ('view')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                <a href="#modal-message" data-toggle="modal" class="btn btn-success col-2" >Adicionar nota</a>
                                <a href="#modal-add-note-manual" data-toggle="modal" class="btn btn-secondary col-2" >Adicionar Nota Manual</a>
                                <a href="#modal-edit-note" data-toggle="modal" class="btn btn-warning col-2" >Modificar Nota</a>
                                <!-- <a disabled="disabled" href="#modal-ret-archive" onclick="clean_ret_modal()" data-toggle="modal" class="btn btn-primary col-2" >Arquivo RET</a>-->
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!--<select class="form-group col-1" onchange="select_income_xml(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled selected>Operação</option>
                                <option value="NULL" <?php echo filter_input(INPUT_GET, 'income')=== 'NULL' ? 'selected': '' ?>>Todos</option>    
                                <option value="1" <?php echo filter_input(INPUT_GET, 'income')=== '1' ? 'selected': '' ?>>Receber</option>    
                                <option value="0" <?php echo filter_input(INPUT_GET, 'income')=== '0' ? 'selected': '' ?>>Pagar</option>    
                            </select> -->
                            <input type="month" class="form-group col-2" onchange="select_date_xml(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'year_mouth')?>">
                            <select class="form-group col-2" onchange="select_client_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'client') ? filter_input(INPUT_GET, 'client'): 'Emissor';?></option>
                                <?php foreach ($method->select_client_payment() AS $key => $value): ?>
                                        <option><?php echo $value->emiter; ?></option>
                                    <?php endforeach; ?>    
                            </select>
                            <select class="form-group col-2" onchange="select_account_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'account') ? filter_input(INPUT_GET, 'account'): 'Destino';?></option>    
                                <?php foreach ($method->select_account_payment() AS $key => $value): ?>
                                    <option><?php echo $value->destine; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-group col-2" onchange="select_status_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'status') ? filter_input(INPUT_GET, 'status'): 'Estado';?></option>    
                                <option value=''>Todos</option>    
                                <?php foreach ($method->select_status_filter() AS $key => $value): ?>
                                    <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="col-1">
                                <a class="btn btn-primary" href="<?php echo base_url('setting?tab=payments&sec=view&income=0')?>">Limpar</a>
                            </div>
                            <input id="date_init" type="date" class="form-group col-2" onchange="select_date_payments(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'date_init')?>">
                            <input id="date_end" type="date" class="form-group col-2" onchange="select_date_payments(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'date_end')?>">
                        </div>
                    </div>
                    <div class="row align-items-end col-12">
                        <?php $total_parcel_value = $method->sum_values(filter_input(INPUT_GET, 'year_mouth'),filter_input(INPUT_GET, 'income'),
                            filter_input(INPUT_GET, 'client'),filter_input(INPUT_GET, 'account'),filter_input(INPUT_GET, 'date_init'), filter_input(INPUT_GET, 'date_end')); ?>
                        <div class="col-7">
                        </div>
                        <div class="col-2">
                            <h5>A pagar:
                                <span style="color:red">
                                <?php echo number_format((float)$total_parcel_value['select_sum_to_pay'],2,",",".");?>
                                </span>
                            </h5>
                        </div>
                        <div class="col-2">
                            <h5>Pago:
                                <span style="color:blue">
                                <?php echo number_format((float)$total_parcel_value['select_sum_payed'],2,",",".");?>
                                </span>
                            </h5>
                        </div>
                        <div class="col-1">
                        <a style="color:white" data-toggle="modal" onclick="download_table_to_excel('table_xml_values','Lista_de_pagamentos')"class="btn btn-success" >Baixar xls</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="table_xml_values" class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Número</th>
                                        <th>Emissor</th>
                                        <th>Destino</th>
                                        <th style="text-align: center;">Data</th>
                                        <!--<th style="text-align: center;">Método</th>-->
                                        <th style="text-align: center;">Valor</th>
                                        <!--<th style="text-align: center;">Operação</th>-->
                                        <th style="text-align: center;">Estado</th>
                                        <th>Pagamento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $table_data = $method->select_payments(
                                        filter_input(INPUT_GET, 'year_mouth'),
                                        filter_input(INPUT_GET, 'income'),
                                        filter_input(INPUT_GET, 'client'),
                                        filter_input(INPUT_GET, 'account'),
                                        filter_input(INPUT_GET, 'status'),
                                        filter_input(INPUT_GET, 'name'),
                                        filter_input(INPUT_GET, 'date_init'),
                                        filter_input(INPUT_GET, 'date_end') );?>
                                     <?php if(!empty($table_data)) : ?>
                                        <?php foreach ($table_data as $key => $value): ?>
                                            <tr class="<?php echo $value->before_today; ?>" id="<?php echo $value->id ?>">
                                                <td></td>
                                                <td><?php echo $value->number; ?></td>
                                                <td><?php echo $value->emiter; ?></td>
                                                <td><?php echo $value->destine; ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($value->parcel_date)); ?></td>
                                                <!--<td style="text-align: center;"><?php echo $value->payment_method; ?></td>-->
                                                <td style="text-align: center;"><?php echo number_format($value->parcel_value,2,",","."); ?></td>
                                                <!--<td style="text-align: center;"><?php echo $value->income_name; ?></td>-->
                                                <td style="text-align: center;"><?php echo $value->status; ?></td>
                                                <td style="text-align: center;"><button class="btn btn-primary" href="#modal-edit-payment" data-toggle="modal" onclick="fillModalEditPayment('<?php echo $value->id_payment; ?>')">Ver</button></td>
                                                <td></td>
                                                <!--<tdclass="with-btn" nowrap=""><a href="#modal-message" onclick="fillModalEditUser()"
                                                class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>">
                                                <i class="ii ios-create"></i>&nbsp;Editar</a></td> -->
                                            </tr>
                                        <?php endforeach; ?> 
                                    <?php endif; ?> 
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-message">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/save_xml'); ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for=""><b>Selecionar arquivo .xml:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="xml" accept=".xml" type="file" name="xml_doc" onchange="readXML(this)" class="form-control" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Número da Nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-cash"></i></span></div>
                                            <input id="number" type="text" name="number" class="form-control" value="" readonly>
                                            <input type="text" name="account" class="form-control" value="1" hidden>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="emiter" type="text" name="emiter" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="destine" type="text" name="destine" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="payment_method" type="text" name="payment_method" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Parcelas:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div" class="input-group m-b-10">
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Operação: </b> Pagamento</label>
                                        <div class="input-group m-b-10" hidden>
                                            <select class="form-group col-4 desabilitado" name="income" tabindex="-1" aria-disabled="true" style="height:35px;">
                                                <option value="0" selected>Pagamento</option>
                                                <option value="1">Recebimento</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-ret-archive" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo base_url('setting/update_with_ret'); ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for=""><b>Selecionar arquivo .RET:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="xml" type="file" accept=".ret" name="xml_doc" onchange="read_file_RET(this)" class="form-control" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <div id="payment_list">
                                            
                                        </div>
                                    </div><!--/form-group-->
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-add-note-manual">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/insert_manual_note'); ?>">
                                <div class="modal-body">
                                    <h5>Nova nota de pagamento</h5>
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número de identificação:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="" type="text" name="emiter" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="" type="text" name="destine" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento: </label>
                                        <select class="form-control col-4" name="payment_method" style="height:35px;">                                                
                                            <?php $payment_method = $method->getPayment_methods();?>
                                            <?php foreach ($payment_method as $key => $value): ?>
                                                <option value="<?php echo $value->code;?>"><?php echo $value->name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Conta interna: </label>
                                        <select class="form-control col-4" name="account" style="height:35px;">                                                
                                            <?php $account = $method->select_accounts();?>
                                            <?php foreach ($account as $key => $value): ?>
                                                <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Valores/data:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div_add_manual" class="input-group m-b-10">
                                        </div>
                                        <div onclick="change_payment_spaces(1,'payment_div_add_manual')" class="btn-primary btn">+ Adicionar</div>
                                        <div onclick="change_payment_spaces(0,'payment_div_add_manual')" class="btn-warning btn">- Remover</div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group" hidden>
                                        <label for=""><b >Operação:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="" class="form-group col-4" name="income" style="height:35px;">
                                                <option value="0" selected>Pagamento</option>
                                                <option value="1">Recebimento</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-note" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_note'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input onblur="fillModalEditNote('')" id="number_edit" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                            <input id="payment_id_edit" placeholder="Número do pagamento FK" type="text" name="" class="form-control" value="" hidden>
                                            <input id="payment_note_id_edit" placeholder="Número da nota FK" type="text" name="note_id_edit" class="form-control" value="" hidden>
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="emiter_edit" type="text" name="emiter" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="destine_edit" type="text" name="destine" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="payment_method_edit" type="text" name="payment_method" class="form-control" readonly value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Parcelas:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div_edit" class="input-group m-b-10">
                                        </div>
                                        <div id="payment_div_edit_parcel" class="input-group m-b-10">
                                        </div>
                                        <div onclick="change_payment_spaces_edit_form(1,'payment_div_edit_parcel')" class="btn-primary btn">+ Adicionar</div>
                                        <div onclick="change_payment_spaces_edit_form(0,'payment_div_edit_parcel')" class="btn-warning btn">- Remover</div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation_edit" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Operação:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="income_edit" class="form-group col-4" name="income_edit" style="height:35px;">
                                                <option value="0">Pagamento</option>
                                                <option value="1" selected>Recebimento</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-payment" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_payment'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input hidden id="id_edit_payment" type="text" name="id" class="form-control">
                                            <input readonly id="number_edit_payment" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="value_edit_payment" type="text" name="value" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Data:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="date_edit_payment" type="date" name="date" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Estado:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="payment_status_edit_payment" class="form-group col-4" name="status" style="height:35px;">
                                                <option value="0" selected>Aguardando</option>
                                                <option value="1">Pago</option>   
                                                <option value="2">Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('receivements') && (filter_input(INPUT_GET, 'sec')) === ('view')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <!--<div class="col-4">
                                <input class="form-control" type="file" onchange=read(this)>

                                <a href="#modal-message" onclick="fillModalEditUser()" class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>"><i class="ii ios-create"></i>&nbsp;Editar</a>
                            </div> -->
                            <div class="col-12">
                                <a href="#modal-message" data-toggle="modal" class="btn btn-success col-2" >Adicionar nota</a>
                                <a href="#modal-ret-archive" data-toggle="modal" class="btn btn-primary col-2" >Arquivo RET</a>
                                <a href="#modal-edit-note" data-toggle="modal" class="btn btn-warning col-2" >Modificar Nota</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <!--<select class="form-group col-1" onchange="select_income_xml(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled selected>Operação</option>
                                <option value="NULL" <?php echo filter_input(INPUT_GET, 'income')=== 'NULL' ? 'selected': '' ?>>Todos</option>    
                                <option value="1" <?php echo filter_input(INPUT_GET, 'income')=== '1' ? 'selected': '' ?>>Receber</option>    
                                <option value="0" <?php echo filter_input(INPUT_GET, 'income')=== '0' ? 'selected': '' ?>>Pagar</option>    
                            </select>-->
                            <input type="month" class="form-group col-2" onchange="select_date_xml(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'year_mouth')?>">
                            <select class="form-group col-2" onchange="select_client_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'client') ? filter_input(INPUT_GET, 'client'): 'Emissor';?></option>
                                <?php foreach ($method->select_client_payment() AS $key => $value): ?>
                                        <option><?php echo $value->emiter; ?></option>
                                    <?php endforeach; ?>    
                            </select>
                            <select class="form-group col-2" onchange="select_account_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'account') ? filter_input(INPUT_GET, 'account'): 'Destino';?></option>    
                                <?php foreach ($method->select_account_payment() AS $key => $value): ?>
                                    <option><?php echo $value->destine; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-group col-2" onchange="select_status_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'status') ? filter_input(INPUT_GET, 'status'): 'Estado';?></option>    
                                <option value=''>Todos</option>    
                                <?php foreach ($method->select_status_filter() AS $key => $value): ?>
                                    <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <select class="form-group col-1" onchange="select_contas_filter(event)" style="width:200px; height:35px; margin-right:2%;">
                                <option selected="true" disabled="disabled"><?php echo filter_input(INPUT_GET, 'name') ? filter_input(INPUT_GET, 'name'): 'Contas';?></option>    
                                <option value=''>Todos</option>
                                <?php foreach ($method->select_contas_filter() AS $key => $value): ?>
                                    <option><?php echo $value->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="col-1">
                                <a class="btn btn-primary" href="<?php echo base_url('setting?tab=receivements&sec=view&income=1')?>">Limpar</a>
                            </div>
                            <input id="date_init" type="date" class="form-group col-2" onchange="select_date_payments(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'date_init')?>">
                            <input id="date_end" type="date" class="form-group col-2" onchange="select_date_payments(event)"
                            style="width:200px; height:35px; margin-right:2%;" value="<?php echo filter_input(INPUT_GET, 'date_end')?>">
                        </div>
                    </div>
                    <div class="row align-items-end col-12">
                        <?php $total_parcel_value = $method->sum_values(filter_input(INPUT_GET, 'year_mouth'),filter_input(INPUT_GET, 'income'),
                            filter_input(INPUT_GET, 'client'),filter_input(INPUT_GET, 'account'),filter_input(INPUT_GET, 'date_init'), filter_input(INPUT_GET, 'date_end')); ?>
                        <div class="col-7"></div>
                        <div class="col-2">
                            <h5>A receber:
                                <span style="color:green">
                                <?php echo number_format((float)$total_parcel_value['sum_parcel_value'],2,",",".");?>
                                </span>
                            </h5>
                        </div>
                        <div class="col-2">
                            <h5>Aprovado:
                                <span style="color:blue">
                                <?php echo number_format((float)$total_parcel_value['total_parcel_value'],2,",",".");?>
                                </span>
                            </h5>
                        </div>
                        <div class="col-1 ">
                        <a style="color:white" data-toggle="modal" onclick="download_table_to_excel('table_xml_values','Lista_de_recebimentos')"class="btn btn-success" >Baixar xls</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="table_xml_values" class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Número</th>
                                        <th>Emissor</th>
                                        <th>Destino</th>
                                        <th style="text-align: center;">Vencimento</th>
                                        <th style="text-align: center;">Data de Pagamento</th>
                                        <th style="text-align: center;">Método</th>
                                        <th style="text-align: center;">Valor</th>
                                        <!--<th style="text-align: center;">Operação</th>-->
                                        <th style="text-align: center;">Conta</th>
                                        <th style="text-align: center;">Estado</th>
                                        <th>Nota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $table_data = $method->select_payments(
                                        filter_input(INPUT_GET, 'year_mouth'),
                                        filter_input(INPUT_GET, 'income'),
                                        filter_input(INPUT_GET, 'client'),
                                        filter_input(INPUT_GET, 'account'),
                                        filter_input(INPUT_GET, 'status'),
                                        filter_input(INPUT_GET, 'name'),
                                        filter_input(INPUT_GET, 'date_init'),
                                        filter_input(INPUT_GET, 'date_end') );?>
                                     <?php if(!empty($table_data)) : ?>
                                        <?php foreach ($table_data as $key => $value): ?>
                                            <tr class="<?php echo $value->before_today; ?>" id="<?php echo $value->id ?>">
                                                <td></td>
                                                <td><?php echo $value->number; ?></td>
                                                <td><?php echo $value->emiter; ?></td>
                                                <td><?php echo $value->destine; ?></td>
                                                <td><?php echo date("d/m/Y", strtotime($value->parcel_date)); ?></td>
                                                <td><?php echo isset($value->approved_date) ? date("d/m/Y", strtotime($value->approved_date)) : ''; ?></td>
                                                <td style="text-align: center;"><?php echo $value->payment_method; ?></td>
                                                <td style="text-align: center;"><?php echo number_format($value->parcel_value,2,",","."); ?></td>
                                                <!--<td style="text-align: center;"><?php echo $value->income_name; ?></td>-->
                                                <td style="text-align: center;"><?php echo $value->account_name; ?></td>
                                                <td style="text-align: center;"><?php echo $value->status; ?></td>
                                                <td style="text-align: center;"><button class="btn btn-primary" href="#modal-edit-payment" data-toggle="modal" onclick="fillModalEditPayment('<?php echo $value->id_payment; ?>')">Ver</button></td>
                                                <td></td>
                                                <!--<tdclass="with-btn" nowrap=""><a href="#modal-message" onclick="fillModalEditUser()"
                                                class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>">
                                                <i class="ii ios-create"></i>&nbsp;Editar</a></td> -->
                                            </tr>
                                        <?php endforeach; ?> 
                                    <?php endif; ?> 
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-message">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/save_xml'); ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for=""><b>Selecionar arquivo .xml:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="xml" accept=".xml" type="file" name="xml_doc" onchange="readXML(this)" class="form-control" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Número da Nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-cash"></i></span></div>
                                            <input id="number" type="text" name="number" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Conta interna: </label>
                                        <div class="input-group m-b-10">
                                            <select class="form-group col-4" name="account" style="height:35px;">                                                
                                            <?php $account = $method->select_accounts();?>
                                            <?php foreach ($account as $key => $value): ?>
                                                <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                            <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="emiter" type="text" name="emiter" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="destine" type="text" name="destine" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="payment_method" type="text" name="payment_method" class="form-control" value="" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Parcelas:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div" class="input-group m-b-10">
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;" readonly></textarea>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Operação: </b>Recebimento</label>
                                        <div class="input-group m-b-10" hidden>
                                            <select class="form-group col-4 desabilitado" name="income" tabindex="-1" aria-disabled="true" style="height:35px;">
                                                <option value="0" >Pagamento</option>
                                                <option value="1" selected>Recebimento</option>   
                                            </select>
                                        </div>
                                    </div><!--/form-group-->
                                    <!--
                                    <div class="form-group">
                                        <div class="input-group m-b-10">
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" id="showTextAreaMotivoReprovacao" name="status" value="1" <?php echo FALSE == 1 ? 'checked="checked"' : NULL ?>>
                                                <label style="cursor: pointer;" for="showTextAreaMotivoReprovacao"><b >Reprovar</b></label>
                                            </div>
                                            <div class="radio radio-css radio-inline">
                                                <input type="radio" id="hideTextAreaMotivoReprovacao" name="status" value="3" <?php echo FALSE == 1 ? 'checked="checked"' : NULL ?>>
                                                <label style="cursor: pointer;" for="hideTextAreaMotivoReprovacao"><b >Aprovar</b></label>
                                            </div>
                                        </div>
                                    </div> --><!--/form-group-->
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-ret-archive" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo base_url('setting/update_with_ret'); ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for=""><b>Selecionar arquivo .RET:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="xml" type="file" accept=".ret" name="xml_doc" onchange="read_file_RET(this)" class="form-control" readonly>
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <div id="payment_list">
                                            
                                        </div>
                                    </div><!--/form-group-->
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-note">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_note'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input onblur="fillModalEditNote('')" id="number_edit" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="emiter_edit" type="text" name="emiter" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="destine_edit" type="text" name="destine" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Conta Selecionada:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="selected_account_edit" class="form-control col-4" name="selected_account_edit" style="height:35px;">
                                            <option value="">Selecione a Nota</option>
                                            <?php foreach ($method->select_accounts() as $key => $value): ?>
                                                <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                            <?php endforeach; ?>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="payment_method_edit" type="text" name="payment_method" class="form-control" readonly value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Parcelas:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div_edit" class="input-group m-b-10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation_edit" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-payment" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="form_edit_payment_date" action="<?php echo base_url('setting/edit_payment'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input hidden id="id_edit_payment" type="text" name="id" class="form-control">
                                            <input readonly id="number_edit_payment" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="value_edit_payment" type="text" name="value" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Data de vencimento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="date_edit_payment" type="date" name="date" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Data de Pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="date_approved_edit_payment" type="date" name="date_approved" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Estado:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="payment_status_edit_payment" class="form-group col-4" name="status" style="height:35px;" onchange="change_date_payment_required(event)">
                                                <option value="0" selected>Aguardando</option>
                                                <option value="1">Pago</option>   
                                                <option value="2">Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('view_month') && (filter_input(INPUT_GET, 'month'))): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-end col-12">
                        <div class="col-1">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-secondary" onclick="window.location.href = '<?php echo base_url('/setting?tab=demonstrative&year='.filter_input(INPUT_GET, 'year')); ?>' "> < Anterior</button><hr>
                        <div class="table-responsive">
                            <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Dia</th>
                                        <th>Contas a Receber</th>
                                        <th>Contas a Pagar</th>
                                        <th>Resultado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $table_data = $method->select_month_payments(filter_input(INPUT_GET, 'month'), filter_input(INPUT_GET, 'year'));?>
                                     <?php if(!empty($table_data)) : ?>
                                        <?php foreach ($table_data as $key => $value): ?>
                                            <tr>
                                                <td></td>
                                                <td><?php echo date("d/m/Y", strtotime($value->date)); ?></td>
                                                <td><?php echo number_format($value->to_receive,2,",","."); ?></td>
                                                <td><?php echo number_format($value->to_pay,2,",","."); ?></td>
                                                <td class="<?php echo $value->result_status; ?>"><?php echo number_format($value->result,2,",",".");; ?></td>
                                            </tr>
                                        <?php endforeach; ?> 
                                    <?php endif; ?> 
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-note" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_note'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input onblur="fillModalEditNote('')" id="number_edit" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Emissor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="emiter_edit" type="text" name="emiter" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Destino:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="destine_edit" type="text" name="destine" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Forma de pagamento:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="payment_method_edit" type="text" name="payment_method" class="form-control" readonly value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Parcelas:</b> <span class="text-danger">*</span></label>
                                        <div id="payment_div_edit" class="input-group m-b-10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Campo observação</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation_edit" rows="5" type="text" name="observation" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Operação:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="income_edit" class="form-group col-4" name="income_edit" style="height:35px;">
                                                <option value="0">Pagamento</option>
                                                <option value="1" selected>Recebimento</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-payment" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_payment'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input hidden id="id_edit_payment" type="text" name="id" class="form-control">
                                            <input readonly id="number_edit_payment" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="value_edit_payment" type="text" name="value" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Data:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="date_edit_payment" type="date" name="date" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Estado:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="payment_status_edit_payment" class="form-group col-4" name="status" style="height:35px;">
                                                <option value="0" selected>Aguardando</option>
                                                <option value="1">Pago</option>   
                                                <option value="2">Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (filter_input(INPUT_GET, 'tab') === 'expenses' && filter_input(INPUT_GET, 'sec') === 'list'): ?>
                <?php echo("<script type='text/javascript' src='" . base_url('assets/js/setting/expense-list.js?version=002') . "'></script>");?>
                
                
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                    <a href="#modal-add-expense" data-toggle="modal" class="btn btn-success col-2">+Nova Despesa</a>
                    <hr>
                    </div>
                    <div class="row align-items-end col-12">
                        <div class="col-1">
                        </div>
                    </div>
                    <div class="col-11">
                        <div class="table-responsive">
                            <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>Fornecedor</th>
                                        <th>
                                            <div class="dropdown">
                                                <a id="dropdownMenuButton" class="dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Data de vencimento <span style="color:gray; font-size:18px;">v</span> <a>
                                                <div class="dropdown-menu" onchange="select_date_expenses()" aria-labelledby="dropdownMenuButton">
                                                    <form class="px-4 py-3">
                                                    <label for="inputMonth">Mês</label>
                                                    <input id="select_date_expenses" type="month" class="form-control" id="inputMonth" name="inputMonth">
                                                    </form>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            Data de pagamento
                                        </th>
                                        <th>Valor</th>
                                        <th>Filial</th>
                                        <th>Status</th>
                                        <th>
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" type="button" id="dropdownMenuButton" 
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Tipo v <i class="bi bi-1-square"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Pessoal</a>
                                                    <a class="dropdown-item" href="#">Fixa</a>
                                                </div>
                                            </div>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="table_expenses">
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-add-expense">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="form_new_expense" onsubmit="return handle_submit_expense(event)">
                                <div class="modal-body">
                                    <div class="floating-message"></div>
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Fornecedor:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="provider_expense_add" class="form-control">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="value_expense_add" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Data de vencimento:</b></label>
                                        <div class="input-group m-b-4 col-5">
                                            <input type="date" name="date_payment_expense_add" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Data de pagamento:</b></label>
                                        <div class="input-group m-b-4 col-5">
                                            <input type="date" name="approved_date_expense_add" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Descrição:</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea id="observation_edit" rows="5" type="text" name="description_expense_add" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Status:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select class="form-group col-4" name="status_expense_add" style="height:35px;">
                                                <option value="0">Aguardando</option>
                                                <option value="1" selected>Pago</option>   
                                                <option value="2" selected>Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Tipo de despesa:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select class="form-group col-4" name="type_expense_add" style="height:35px;">
                                                <option value="0">Pessoal</option>
                                                <option value="1" selected>Fixa</option>   
                                                <option value="2" selected>Folha</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-expense">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="form_edit_expense" onsubmit="return handle_edit_expense(event)">
                                <div class="modal-body">
                                    <div class="floating-message"></div>
                                    <hr>
                                    <label for=""><b >Fornecedor:</b></label>
                                    <div class="input-group m-b-10">
                                            <input hidden type="text" id="id_expense_edit" name="id_expense_edit" class="form-control">
                                            <input type="text" id="provider_expense_edit" name="provider_expense_edit" class="form-control">
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" id="value_expense_edit" name="value_expense_edit" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Data de vencimento:</b></label>
                                        <div class="input-group m-b-4 col-5">
                                            <input type="date" id="date_payment_expense_edit" name="date_payment_expense_edit" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b>Data de pagamento:</b></label>
                                        <div class="input-group m-b-4 col-5">
                                            <input type="date" id="approved_date_expense_edit" name="approved_date_expense_edit" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Descrição:</b></label>
                                        <div class="input-group m-b-10">
                                            <textarea rows="5" type="text" id="description_expense_edit" name="description_expense_edit" class="form-control" style="font-size: 14px;"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Status:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select class="form-group col-4" id="staus_expense_edit" name="staus_expense_edit" style="height:35px;">
                                                <option value="0">Aguardando</option>
                                                <option value="1" selected>Pago</option>   
                                                <option value="2" selected>Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Tipo de despesa:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select class="form-group col-4" id="type_expense_edit" name="type_expense_edit" style="height:35px;">
                                                <option value="0">Pessoal</option>
                                                <option value="1" selected>Fixa</option>   
                                                <option value="2" selected>Folha</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-delete-expense" >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="form_delete_expense" onsubmit="return handle_delete_expense(event)">
                                <div class="modal-header"><h4>Confirmação:</h4></div>
                                <div class="modal-body" style="margin-bottom:5px;">
                                    <p id="id_expense_delete_info"></p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger"><i class="ii ios-paper-plane"></i>&nbsp;Excluir</button>
                                    <a href="javascript:;" class="btn btn-success" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-payment">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/edit_payment'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Número da nota:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input hidden id="id_edit_payment" type="text" name="id" class="form-control">
                                            <input readonly id="number_edit_payment" placeholder="Número da nota" type="text" name="number" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Valor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="value_edit_payment" type="text" name="value" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Data:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <input id="date_edit_payment" type="date" name="date" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Estado:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <select id="payment_status_edit_payment" class="form-group col-4" name="status" style="height:35px;">
                                                <option value="0" selected>Aguardando</option>
                                                <option value="1">Pago</option>   
                                                <option value="2">Cancelado</option>   
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="floating-message"></div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('bank_values')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-end col-12">
                        <div class="col-1">
                        </div>
                    </div>
                    <div class="col-12" id="account_values_list">
                        <h4>Saldos Bancários</h4>
                        <hr>
                        <div class="row" stye>
                            <div class="col-2"><h6 style="margin-left:10px;">Conta</h6></div>
                            <div class="col-2"><h6 style="margin-left:20px;">Valor Atual</h6></div>
                            <div class="col-2"><h6>Somatório: <span id="sum_bank_values">-</span></h6></div>
                            <div class="col-2"><h6>Último registro: <?php echo isset($method->get_history_account_values()[0]->date) ? date("d/m/Y H:i", strtotime($method->get_history_account_values()[0]->date)) : '-';?></h6></div>
                            <div class="col-2"><h6>Somatório: <span id="sum_bank_values_history"><?php echo number_format($method->get_sum_historic_acconts_today(),2,",",".");?> </span></h6></div>
                        </div>
                        <hr style="margin-top: 0; width:100%; margin-left: 0;">
                        <div class="row">
                            <div class="col-6">
                                <form method="POST" action="<?php echo base_url('setting/post_account_values'); ?>">
                                    <?php foreach ($method->account_values() as $key => $value) : ?>
                                    <div id="<?php echo $value->id; ?>" class="row" style="margin:2px;">
                                        <input class="checkbox_selected" style="margin-bottom:7px;" type="checkbox" checked>
                                        <div class="col-4"> <p style="margin-left:10px; margin-top:5px;"> <?php echo $value->name; ?></p></div>
                                        <div hidden><input type="text" class="form-control" name="account_id[]" value="<?php echo $value->id; ?>"></div>
                                        <div class="col-3"><input type="text" class="form-control value_to_sum checkbox_selected" name="account_value[]" value="0"></div>
                                    </div>
                                    <?php endforeach; ?>
                                    <hr style="margin-top: 0; width:50%; margin-left: 0;">
                                    <div class="row" style="margin:2px;">
                                        <input class="checkbox_selected" style="margin-bottom:7px;" type="checkbox" checked>
                                        <div class="col-4"> <p style="margin-left:10px; margin-top:5px;">Cartão Antecipação</p></div>
                                        <div class="col-3"><input type="text" name="antecipation_card" class="form-control value_to_sum checkbox_selected" value="0"></div>
                                    </div>
                                    <div class="row" style="margin:2px;">
                                        <input class="checkbox_selected" style="margin-bottom:7px;" type="checkbox" checked>
                                        <div class="col-4"> <p style="margin-left:10px; margin-top:5px;">Saldo em mãos </p></div>
                                        <div class="col-3"><input name="hands_value" type="text" class="form-control value_to_sum checkbox_selected" value="0"></div>
                                    </div>
                                    <br>
                                    <div class="row justify-content-md-center">
                                        <button class="btn btn-success col-3">Salvar Valores</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-6">
                                <?php foreach ($method->get_history_account_values() as $key => $value) : ?>
                                <div id="<?php echo $value->id; ?>" class="row" style="margin:2px;">
                                    <input class="checkbox_selected_history" style="margin-bottom:7px;" type="checkbox" checked>
                                    <div class="col-4"> <p style="margin-left:10px; margin-top:5px;"> <?php echo isset($value->name) ? $value->name : ''; ?></p></div>
                                    <div class="col-3"><input readonly type="text" class="form-control value_to_sum" value="<?php echo $value->value; ?>"></div>
                                </div>
                                <?php endforeach; ?>
                                <hr style="margin-top: 0; width:50%; margin-left: 0;">
                                <div class="row" style="margin:2px;">
                                    <input class="checkbox_selected_history" style="margin-bottom:7px;" type="checkbox" checked>
                                    <div class="col-4"> <p style="margin-left:10px; margin-top:5px;">Cartão Antecipação</p></div>
                                    <div class="col-3">
                                        <input readonly type="text" class="form-control value_to_sum" 
                                            value="<?php echo isset($method->get_history_hands_balance('antecipation_card')[0]->value) ? $method->get_history_hands_balance('antecipation_card')[0]->value : ''; ?>">
                                    </div>
                                </div>
                                <div class="row" style="margin:2px;">
                                    <input class="checkbox_selected_history" style="margin-bottom:7px;" type="checkbox" checked>
                                    <div class="col-4"> <p style="margin-left:10px; margin-top:5px;">Saldo em mãos </p></div>
                                    <div class="col-3">
                                        <input readonly type="text" class="form-control value_to_sum" 
                                            value="<?php echo isset($method->get_history_hands_balance('hands_value')[0]->value) ? $method->get_history_hands_balance('hands_value')[0]->value : ''; ?>">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>                
                <div>
                    <h5>Histórico de registros:</h5><br>
                    <div class="row">
                        <input type="date" id="date_see_account_payments" style="margin-left:5px;" class="form-control col-2">
                        <button class="btn btn-primary col-1" onclick="show_history_account_value()" 
                        href="#show-account-values-history_modal" data-toggle="modal" style="margin-left:2%;">Ver</button>
                    </div>
                </div>
                <div class="floating-message"></div>
                <div class="modal modal-message fade" id="show-account-values-history_modal" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div id="list-account-values_history">
                                    
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('demonstrative')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <!--<div class="">
                                !--<select id="select_year" onchange="get_chart_values_to_receive()" class="form-group"  style="width:200px; height:35px;">
                                -- onchange="select_table_state(event)" --
                                    <option disabled>Ano</option>
                                    <?php $year_notes = $method->select_year_notes();?>
                                    <?php foreach ($year_notes as $key => $value): ?>
                                        <option <?php echo $value->year == filter_input(INPUT_GET, 'year') ? 'selected' : '' ?> value="<?php echo $value->year;?>"><?php echo $value->year;?></option>
                                    <?php endforeach; ?>  
                                    !-- <option <?php //echo date('Y') == 2022 ? 'selected' : ''; ?> value="2022">2022</option>
                                    <option <?php //echo date('Y') == 2023 ? 'selected' : ''; ?> value="2023">2023</option> --
                                </select>--
                            </div> -->
                            <div class="col-2">
                                <select id="select_account" onchange="add_account_to_filter(event)" class="form-group" style="width:200px; height:35px;">
                                    <option selected="true" disabled="disabled">Adicionar Conta</option>  
                                    <?php $account = $method->select_accounts();?>
                                    <?php foreach ($account as $key => $value): ?>
                                        <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                                    <?php endforeach; ?>
                                </select>
                                Inadimplência <br>
                                <?php $select_defaulters = $method->select_defaulters();?>
                                    <div id="defaulters_year">
                                        <?php foreach ($select_defaulters as $key => $value): ?>
                                            <span>Ano: <?php echo $value->year;?> - <span class="late"><?php echo number_format($value->total,2,",",".");?></span></span><br>
                                        <?php endforeach; ?>
                                    </div>
                                   
                            </div>
                            <div class="col-10">
                                <div class="col-12" id="selected_accounts" onchange="get_chart_values_to_receive()" style="background-color:white; min-height:70px;">
                                    <?php foreach ($account as $key => $value): ?>
                                        <div onclick="delete_account(event)" class="btn btn-secondary" style=" margin:2px;" value="<?php echo $value->id;?>"><?php echo $value->name;?> X </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                            <h6>Entradas recentes:</h6>
                                <a class="col-2" href="#modal-see-recents" onclick="get_recents_notes(1)" data-toggle="modal">Notas a receber</a>
                                <a class="col-2" href="#modal-see-recents" onclick="get_recents_notes(0)" data-toggle="modal">Notas a pagar</a>
                                <a class="col-2" href="dashboard?tab=entries_historic">Histórico</a>
                            </div>
                            <div class="col-7">
                                <div class="table-responsive" style="min-height:150px;">
                                    <table class="table table-striped m-b-0" >
                                        <thead>
                                            <tr>
                                                <th>Ano/Mês</th>
                                                <th>Contas a Receber<br>(A Realizar)</th>
                                                <th>Previsão <br> (Venda balcão)</th>
                                                <th>Despesa<br>(A Realizar)</th>
                                                <th>Inadimplência</th>
                                                <th>Contas a pagar <br>(A Realizar)</th>
                                                <th>Resultado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_to_receive">
                                            <!--<?php $month_names = $method->month_names(); ?>
                                        <?php //foreach ($method->parcel_values_to_receive(2022, null) as $key => $value): ?>
                                            <tr class="clickable-row" onclick="redirect_payment_details('<?php echo $value->month ?>')">
                                                <td><?php echo $month_names[$value->month];?></td>
                                                <td><?php echo number_format($value->to_receive,2,".",",");?></td>
                                                <td><?php echo number_format($value->to_pay,2,",",".");?></td>
                                                <td><?php echo number_format($value->to_receive - $value->to_pay,2,",",".");?></td>
                                            </tr>
                                        <?php //endforeach; ?>-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-5">
                                <div id="chart_div" style="margin-top:5%;" style="height:300px;" class="col-12"></div>
                            </div>
                            <br>
                            <hr class="col-12">
                            <div class="col-7">
                                
                                <div class="table-responsive" style="min-height:150px;">
                                    <table class="table table-striped m-b-0" >
                                        <thead>
                                            <tr>
                                                <th>Ano/Mês</th>
                                                <th><span style="width:10px;">Contas a Receber <br>(Faturado-Realizado)</span></th>
                                                <th>Venda Balcão <br>(Realizado)</th>
                                                <th>Despesa<br>(Realizado)</th>
                                                <th>Contas a pagar<br>(Fornecedor-Realizado)</th>
                                                <th>Resultado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_received">
                                            <?php //foreach ($method->parcel_values_to_receive(2022, null) as $key => $value): ?>
                                            <!--<?php //$month_names = $method->month_names(); ?>
                                                <tr class="clickable-row" onclick="redirect_payment_details('<?php echo $value->month ?>')">
                                                <td><?php //echo $month_names[$value->month];?></td>
                                                <td><?php //echo number_format($value->to_receive,2,",",".");?></td>
                                                <td><?php //echo number_format($value->to_pay,2,",",".");?></td>
                                                <td><?php //echo number_format($value->to_receive - $value->to_pay,2,",",".");?></td>
                                            </tr>
                                        <?php //endforeach; ?>-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-5">
                                <div id="curve_chart2" style="margin-top:5%;" style="height:300px;" class="col-12" ></div>
                            </div>
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-see-recents">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo base_url('setting/edit_login'); ?>">
                                <div class="modal-body" >
                                <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Valor</th>
                                        <th>Vencimento</th>
                                        <th>Conta</th>
                                        <th>Emissor</th>
                                        <th>Destino</th>
                                        <th>Estado Atual</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-body-see-recents">
                                    
                                </tbody> 
                            </table>
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?> 
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('logins') && (filter_input(INPUT_GET, 'sec')) === ('all')): ?>
                <div class="row">
                    <div class="col-12">
                        <button href="#modal-add-login" data-toggle="modal" class="col-2 btn btn-success">Novo acesso</button>
                    <hr>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped m-b-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Referência</th>
                                        <th>Login</th>
                                        <th>Senha</th>
                                        <th>Sistema</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $table_data = $method->select_accesses() ?>
                                     <?php if(!empty($table_data)) : ?>
                                        <?php foreach ($table_data as $key => $value): ?>
                                            <tr id="<?php echo $value->id ?>">
                                                <td></td>
                                                <td><?php echo $value->name; ?></td>
                                                <td><?php echo $value->user; ?></td>
                                                <td><?php echo $value->password; ?></td>
                                                <td><?php echo $value->sistem; ?></td>
                                                <td><a onclick="fill_modal_edit_login('<?php echo $value->id; ?>', '<?php echo $value->name; ?>', '<?php echo $value->user; ?>'
                                                ,'<?php echo $value->password; ?>','<?php echo $value->sistem; ?>' )" href="#modal-edit-login" data-toggle="modal">Editar</a></td>
                                                <!--<tdclass="with-btn" nowrap=""><a href="#modal-message" onclick="fillModalEditUser()"
                                                class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>">
                                                <i class="ii ios-create"></i>&nbsp;Editar</a></td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?> 
                                </tbody> 
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-edit-login" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo base_url('setting/edit_login'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Nome:</b></label>
                                        <div class="input-group m-b-10">
                                            <input id="edit_login_id" hidden type="text" name="id" class="form-control" value="">
                                            <input id="edit_login_name" type="text" name="name" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Login:</b></label>
                                        <div class="input-group m-b-10">
                                            <input id="edit_login_user" type="text" name="user" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Senha:</b></label>
                                        <div class="input-group m-b-10">
                                            <input id="edit_login_pasword" type="text" name="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Sistema:</b></label>
                                        <div class="input-group m-b-10">
                                            <input id="edit_login_sistem" type="text" name="sistem" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal-message fade" id="modal-add-login" style="padding: 75px 17px 17px 30px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="<?php echo base_url('setting/create_login'); ?>">
                                <div class="modal-body">
                                    <hr>
                                    <div class="form-group">
                                    <label for=""><b >Nome:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="name" class="form-control" value="">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <label for=""><b >Login:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="user" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Senha:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="password" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for=""><b >Sistema:</b></label>
                                        <div class="input-group m-b-10">
                                            <input type="text" name="sistem" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('ebook') && (filter_input(INPUT_GET, 'sec')) === ('all')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ((!empty($method->select_user_ebook()))): ?>
                            <?php foreach ($method->select_user_ebook() as $key => $value): ?>
                                <div class="bg-white p-15">
                                    <table class="table table-bordered widget-table widget-table-rounded" data-id="widget">
                                        <thead>
                                            <tr>
                                                <th width="1%"></th>
                                                <th>Informações</th>
                                                <th>Preço</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <!--<img class="imgNovoEbook" src="<?php //echo $value->photo; ?>" alt="" style="max-height: 140px;">!-->
                                                </td>
                                                <td>
                                                    <label for=""><b >Código:</b> <span class="codeEbookSpan text-danger"><?php echo $value->code; ?></span></label>
                                                    <br/>
                                                    <label for=""><b >Edital:</b></label>
                                                    <span id="" class="tipoCapituloEbook"><?php echo $value->edital; ?></span>
                                                    <br/>
                                                    <label for=""><b >Email Escritor:</b></label>
                                                    <span id="" class="tipoCapituloEbook"><?php echo $value->user_email; ?></span>
                                                    <br/>
                                                    <input type="hidden" class="resumoEbookSettings" value="<?php echo $value->content; ?>">
                                                    <input type="hidden" class="autorEmail" value="<?php echo $value->user_email; ?>">
                                                    <input type="hidden" class="autorName" value="<?php echo $value->display_name; ?>">
                                                    <label ><b >Escritor:</b> <?php echo $value->display_name; ?></label>
                                                    <p class="widget-table-desc m-b-15 descricaoNovoEbook"><?php echo $value->description; ?></p>
                                                    <div class="progress progress-sm rounded-corner m-b-5">
                                                        <?php
                                                        switch ($value->status) {
                                                            case 1:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger f-s-10 f-w-600" style="width: 0%;">0%</div>';
                                                                break;
                                                            case 2:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning f-s-10 f-w-600" style="width: 0%;">0%</div>';
                                                                break;
                                                            case 3:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success f-s-10 f-w-600" style="width: 20%;">20%</div>';
                                                                break;
                                                            case 4:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success f-s-10 f-w-600" style="width: 50%;">50%</div>';
                                                                break;
                                                            case 5:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success f-s-10 f-w-600" style="width: 65%;">65%</div>';
                                                                break;
                                                            case 6:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success f-s-10 f-w-600" style="width: 90%;">90%</div>';
                                                                break;
                                                            case 7:
                                                                echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success f-s-10 f-w-600" style="width: 100%;">100%</div>';
                                                                break;
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="clearfix f-s-10">
                                                        <?php
                                                        switch ($value->status) {
                                                            case 1:
                                                                echo '<b class="text-danger">Resumo Reprovado, Favor Revisar</b>';
                                                                break;
                                                            case 2:
                                                                echo '<b class="text-warning">Aguardando Aprovação do Resumo</b>';
                                                                break;
                                                            case 3:
                                                                echo empty($value->proof_payment)? '<b class="text-success">Resumo Aprovado / Aguardando Pagamento</b>': '<b class="text-warning">Aguardando Avaliação do comprovante de Pagamento</b>';
                                                                break;
                                                            case 4:
                                                                echo '<b class="text-success">Aguardando Edição do Capítulo</b>';
                                                                break;
                                                            case 5:
                                                                echo '<b class="text-success">Aguardando Aprovação do Editor</b>';
                                                                break;
                                                            case 6:
                                                                echo '<b class="text-success">Capítulo no Prelo</b>';
                                                                break;
                                                            case 7:
                                                                echo '<b class="text-success">Capítulo Concluído</b>';
                                                                break;
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <b class="text-inverse" data-id="widget-elm" data-light-class="text-inverse" data-dark-class="text-white">R$<?php echo $value->price; ?></b><br>
                                                </td>
                                                <td>R$<?php echo $value->price; ?></td>
                                                <td>
                                                    <?php
                                                    switch ($value->status) {
                                                        case 1:
                                                            echo '<button class="btn btn-default btn-sm width-80 rounded-corner" disabled>Aguardando</button>';
                                                            break;
                                                        case 2:
                                                            echo '<a href="#modal-message" onclick="fillModalEditResumo(`'.$value->title.'`)" data-toggle="modal" class="btn btn-inverse btn-sm width-80 rounded-corner" data-id="widget-elm" data-light-class="btn btn-inverse btn-sm width-80 rounded-corner" data-dark-class="btn btn-default btn-sm width-80 rounded-corner">Avaliar Resumo </a>';
                                                            break;
                                                        case 3:
                                                            echo empty($value->proof_payment)? '<button class="btn btn-default btn-sm rounded-corner" disabled>Aguardando</button>' : '<a href="' . base_url() . 'setting?tab=payment&sec=view" class="btn btn-inverse btn-sm width-80 rounded-corner">Avaliar Pagamento</a>';
                                                            break;
                                                        case 4:
                                                            echo '<button class="btn btn-default btn-sm  rounded-corner" disabled>Aguardando</button>';
                                                            break;
                                                        case 5:
                                                            echo '<button class="btn btn-default btn-sm rounded-corner" disabled>Aguardando</button>';
                                                            break;
                                                        case 6:
                                                            echo '<a href="' . base_url() . 'setting?tab=ebook&sec=edit&code=' . $value->code . '" class="btn btn-inverse btn-sm width-80 rounded-corner">Editar</a>';
                                                            break;
                                                        case 7:
                                                            echo '<a onclick="getDocDownloadFinal(' . $value->code . ')" class="btn btn-success btn-sm width-80 rounded-corner"><i class="ii ios-cloud-download"></i>&nbsp;Download</a>';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div><!--/bg-white p-15-->
                                <br/>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div><!--/col-lg-12-->
                    <div class="modal modal-message fade" id="modal-message" style="padding: 75px 17px 17px 17px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/aprove_ebook?tab=ebook&sec=updt'); ?>">
                                    <div class="modal-header">
                                        <div style="text-align: center; width: 100%;">
                                            <img id="imgEditoraPasteur" src="http://editurapasteur.newtisolucoes.com.br/wp-content/uploads/2020/08/EDITORA-PASTEUR-LOGO-SITE.png" alt="" style="max-width: 130px;">
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for=""><b >Código:</b> <span id="codeEbookSpan" class="text-danger">0000000000</span></label>
                                            <input id="codeEbookHiddenInputText" type="hidden" name="code">
                                        </div><!--/form-group-->
                                        <div class="form-group">
                                            <label for=""><b >Nome do Capítulo</b> <span class="text-danger">*</span></label>
                                            <div class="input-group m-b-10">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-book"></i></span></div>
                                                <input id="nomeEbook" type="text" name="" class="form-control" placeholder="Insira o Nome do capítulo" value="" disabled="disabled">
                                            </div>
                                        </div><!--/form-group-->
                                        <div class="form-group">
                                            <label for=""><b >Resumo do Capítulo</b> <span class="text-danger">*</span></label>
                                            <div class="input-group m-b-10">
                                                <textarea id="textAreaEditResumeSettings" rows="20" type="text" name="abst" class="form-control" style="font-size: 14px;" readonly placeholder="Insira o resumo do capítulo"></textarea>
                                            </div>
                                        </div><!--/form-group-->
                                        
                                        <div class="form-group">
                                            <label for=""><b >Nome do Autor:</b> <span id="nomeAutor" class="text">Nome do autor</span></label>
                                        </div><!--/form-group-->
                                        <div class="form-group">
                                            <label for=""><b >Email do Autor:</b> <span id="emailAutor" class="text">autor@email.com</span></label>
                                        </div><!--/form-group-->

                                        <div class="form-group">
                                            <div class="input-group m-b-10">
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" id="showTextAreaMotivoReprovacao" name="status" value="1" <?php echo FALSE == 1 ? 'checked="checked"' : NULL ?>>
                                                    <label style="cursor: pointer;" for="showTextAreaMotivoReprovacao"><b >Reprovar</b></label>
                                                </div>
                                                <div class="radio radio-css radio-inline">
                                                    <input type="radio" id="hideTextAreaMotivoReprovacao" name="status" value="3" <?php echo FALSE == 1 ? 'checked="checked"' : NULL ?>>
                                                    <label style="cursor: pointer;" for="hideTextAreaMotivoReprovacao"><b >Aprovar</b></label>
                                                </div>
                                            </div>
                                        </div><!--/form-group-->
                                        <div class="form-group showTextMotivoReprovacaoResumo" hidden="hidden">
                                            <label for=""><b >Motivo da Reprovação:</b> <span class="text-danger">*</span></label>
                                            <div class="input-group m-b-10">
                                                <textarea type="text" name="txtdeny" class="form-control" placeholder="Insira o Motivo da Reprovação" style="min-height: 150px; max-height: 150px;" ></textarea>
                                            </div>
                                            <span class="text-danger"><b >O Resumo Rejeitado Voltará Para o Cliente Analisar!</b></span>
                                        </div> 
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!--/row-->
                </div><!--/row-->
            <?php endif; ?>
        
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('user') && (filter_input(INPUT_GET, 'sec')) === ('view')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div >
                            <div class="table-responsive">
                                <table class="table table-striped m-b-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome Completo ou Razão Social</th>
                                            <th>E-mail</th>
                                            <th>Nível de Acesso</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($method->select_user(key($method->select_user())) as $key => $value): ?>
                                            <tr id="<?php echo $value->ID ?>">
                                                <td contenteditable="true" class="idUserList"><?php echo $value->ID; ?></td>
                                                <td class="nomeUserList"><?php echo $value->display_name; ?></td>
                                                <td class="emailUserList"><?php echo $value->user_email; ?></td>
                                                <?php if (($value->access_level) == (1)): ?>
                                                    <td class="acessoUserList">Usuario</td>
                                                <?php endif; ?>
                                                <?php if (($value->access_level) == (2)): ?>
                                                    <td class="acessoUserList">Operador</td>
                                                <?php endif; ?>
                                                <?php if (($value->access_level) == (3)): ?>
                                                    <td class="acessoUserList">Administrador</td>
                                                <?php endif; ?>
                                                <td class="with-btn" nowrap=""><a href="#modal-message" onclick="fillModalEditUser()" class="btn btn-sm btn-yellow" data-toggle="modal" value="<?php echo $value->ID; ?>"><i class="ii ios-create"></i>&nbsp;Editar</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div >
                            <div class="modal modal-message fade" id="modal-message" style="padding: 75px 17px 17px 17px;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="<?php echo base_url('setting/update?tab=user&sec=updt'); ?>">
                                            <div class="modal-header">
                                                <div style="text-align: center; width: 100%;">
                                                    <h4 class="modal-title"><i class="ii ios-person text-blue" style="font-size: 150px"></i></h4>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for=""><b >Nome Completo ou Razão Social</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="min-width: 35px;"><i class="ii md-person"></i></span></div>
                                                        <input id="idModalEditUser" type="hidden" name="usrid" class="form-control">
                                                        <input id="nomeModalEditUser" type="text" name="" class="form-control" disabled="disabled">
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >CPF ou CNPJ</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="min-width: 35px;"><i class="ii md-document"></i></span></div>
                                                        <input id="cpfModalEditUser" type="text" name="docum" class="form-control" placeholder="CPF ou CNPJ">
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >E-mail</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="min-width: 35px;"><i class="ii ios-mail"></i></span></div>
                                                        <input id="emailModalEditUser" type="text" name="email" class="form-control" placeholder="E-mail">
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Telefone</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text" style="min-width: 35px;"><i class="ii md-call"></i></span></div>
                                                        <input id="telefoneModalEditUser" type="text" name="" class="form-control" placeholder="Telefone" disabled="disabled">
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Nível de Acesso</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="aclvl" id="inlineCssRadio1" value="1">
                                                            <label for="inlineCssRadio1">Usuario</label>
                                                        </div>
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="aclvl" id="inlineCssRadio2" value="2">
                                                            <label for="inlineCssRadio2">Operador</label>
                                                        </div>
                                                        <div class="radio radio-css radio-inline">
                                                            <input type="radio" name="aclvl" id="inlineCssRadio2" value="3">
                                                            <label for="inlineCssRadio2">Administrador</label>
                                                        </div>
                                                    </div><!--/input-group m-b-10-->
                                                </div><!--/form-group-->
                                            </div>
                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                                <button class="btn btn-success"><i class="ii ios-checkbox"></i>&nbsp;Salvar Alterações</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('payment') && (filter_input(INPUT_GET, 'sec')) === ('view')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label for="codigoPesquisarPagamento">Buscar comprovante por código: </label>
                            <input id="codigoPesquisarPagamento" type="text" placeholder="0000000000">
                            <button class="btn btn-primary" href="#modal-payment" onclick="buscarComprovante()" data-toggle="modal">Buscar Comprovante</button>
                            <hr>
                        </div>
                        <br>
                        <div >
                            <form >
                                <div class="table-responsive">
                                    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Usuário</th>
                                                <th>Edital</th>
                                                <th>Código</th>
                                                <th>Email</th>
                                                <th>Data de Pagamento</th>
                                                <th>Comprovante</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($method->select_payment() as $key => $value): ?>
                                                <tr>
                                                    <td class="with-img"><i class="ii ios-cash-outline text-green" style="font-size: 250%;"></i></td>
                                                    <td><?php echo $value->display_name; ?></td>
                                                    <td><?php echo $value->ebook_name; ?></td>
                                                    <td><?php echo $value->code; ?></td>
                                                    <td><?php echo $value->user_email; ?></td>
                                                    <td><?php echo $value->date_payment; ?></td>
                                                    <td><a href="#modal-payment" onclick="verPagamento()" data-toggle="modal">Ver Comprovante</a>
                                                        <input class="imgPagamentoComprovante"name="" type="hidden" value="<?php echo $value->proof_payment; ?>"></td>
                                                    <?php if (empty($value->proof_payment)): ?>
                                                        <td>Aguardando Comprovante</td>
                                                    <?php endif; ?>
                                                    <?php if (!empty($value->proof_payment)): ?>
                                                        <?php if (($value->status) == (3)): ?>
                                                            <td>Aguardando Aprovação</td>
                                                        <?php endif; ?>
                                                        <?php if (($value->status) >= (4)): ?>
                                                            <td class="text-success">Pagamento Aprovado</td>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <td class="with-btn" nowrap="">
                                                        <?php if (empty($value->proof_payment)): ?>
                                                            <button class="btn btn-info" disabled><i class="ii ios-cash-outline"></i>&nbsp;Aguardando</button>
                                                        <?php endif; ?>
                                                        <?php if (!empty($value->proof_payment)): ?>
                                                            <?php if (($value->status) == (3)): ?>
                                                                <a href="<?php echo base_url('setting/accept_payment?code=' . $value->code .'&email=' . $value->user_email); ?>" class="btn btn-warning"><i class="ii ios-cash-outline"></i>&nbsp;Aprovar</a>
                                                                <a href="<?php echo base_url('setting/payment_deny?code=' . $value->code); ?>" class="btn btn-danger"><i class="ii ios-cash-outline"></i>&nbsp;Reprovar</a>
                                                            <?php endif; ?>
                                                            <?php if (($value->status) >= (4)): ?>
                                                                <button class="btn btn-success" disabled><i class="ii ios-cash-outline"></i>&nbsp;Aprovado</button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div><!--/col-lg-12-->
                    <div class="modal modal-message fade" id="modal-payment" style="padding: 75px 17px 17px 17px;">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-8">
                                            <label id="notFoundMessage">Carregando...</label>
                                            <img id="imgPagamentoComprovanteModal" style="width: 100%;">
                                        </div>
                                        <div class="col-sm-2"></div>
                                    </div><!--/row-->
                                </div>
                                <div class="modal-footer">
                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                </div>
                            </div><!--modal-content-->
                        </div>
                    </div>
                </div><!--/row-->
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('chapter') && (filter_input(INPUT_GET, 'sec')) === ('list')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-6">
                            <label for="codigoBuscarResumo">Buscar resumo por código: </label>
                            <input id="codigoBuscarResumo" type="text" placeholder="0000000000">
                            <button class="btn btn-primary" href="#modal-ver-resumo" onclick="preencherModalVerResumoPorCodigo()" data-toggle="modal">Buscar resumo</button>
                            <hr>
                        </div>
                        <div >
                            <form >
                                <div class="table-responsive">
                                    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Nome do Escritor</th>
                                                <th>Código Capítulo</th>
                                                <th>Email do Escritor</th>
                                                <th>Editor Responsável</th>
                                                <th>Edital</th>
                                                <th>Resumo</th>
                                                <th>Estado atual</th>
                                                <th>Data de submissão</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($method->list_chapters())): ?>
                                                <?php foreach ($method->list_chapters() as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo '<a href = ' . base_url('setting?tab=user&sec=listchapters&email='. $value->user_email) . '>' . $value->user_nicename . '</a>';?></td>
                                                        <td><?php echo $value->code; ?></td>
                                                        <td><?php echo $value->user_email; ?></td>
                                                        <td><?php echo $value->editor_nicename; ?></td>
                                                        <td><?php echo $value->edital; ?></td>
                                                        <td><a href="#modal-ver-resumo" data-text="<?php echo $value->content; ?>" value="" onclick="preencherModalVerResumo('<?php echo $value->title; ?>')" data-toggle="modal">Visualizar</a></td>
                                                        <td><?php echo $value->status; ?></td>
                                                        <td> - </td>
                                                        <td>
                                                            <a href="#modal-edit-chapter" onclick="fillModalEditChapter('<?php echo $value->code; ?>')" style="font-size: 250%; background-repeat: no-repeat;" data-toggle="modal" class="ii ios-create"></a>
                                                            <a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-trash"></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php elseif (empty($method->list_user_ebook())):?>
                                                <td><?php echo "Resultado vazio"; ?></td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        </div><!--/col-lg-12-->
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-edit-chapter" style="padding: 75px 17px 17px 17px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/update_chapter'); ?>">
                                <div class="modal-header">
                                    <div style="text-align: center; width: 100%;">
                                        <img id="imgEditoraPasteur" src="https://editorapasteur.com.br/wp-content/uploads/2020/08/EDITORA-PASTEUR-LOGO-SITE.png" alt="" style="max-width: 130px;">
                                    </div>
                                </div>
                                <div class="modal-body md-col-8">
                                    <div class="form-group">
                                        <label for=""><b >Código:</b> <span id="codeEbookSpan" class="text-danger"></span></label>
                                        <input class="form-control" type="text" id="codeView" disabled value="">
                                        <input class="form-control" type="text" id="codeEbookHiddenInputText" hidden name="code" value="">
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Escritor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-book"></i></span></div>
                                            <input disabled id="escritorResponsavelEditChapter" value="" type="text" class="form-control">
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Editor Responsável:</label>
                                        <select id="editorResposavelEditChapter" name="editor" class="form-control">
                                        <?php foreach ($method->select_editor() AS $key => $value): ?>
                                            <option value="<?php echo $value->ID; ?>"><?php echo $value->user_email; ?> - <?php echo $value->display_name; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b>Edital:</b> </label>
                                        <select id="editalEditChapter" name="edital" class="form-control">
                                            <?php foreach ($method->select_chapters() AS $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Status atual:</b></label>
                                        <select id="statusEditChapter" name="status" class="form-control">
                                        <?php foreach ($method->select_status() AS $key => $value): ?>
                                                <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-warning" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-ver-resumo" style="padding: 75px 17px 17px 17px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h2>Título:</h2>
                                <input disabled class="form-control" id="modalResumoTitle" ></input>
                                <br>
                                <h3>Resumo:</h3>
                                <br>
                                <textarea disabled class="form-control" id="modalResumoContent" rows="30" ></textarea>
                            </div>
                            <div class="modal-footer">
                                <a href="javascript:;" class="btn btn-warning" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                            </div>
                        </div>
                    </div>
                </div><!--/row-->
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('user') && (filter_input(INPUT_GET, 'sec')) === ('listchapters')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div >
                            <form >
                                <div class="table-responsive">
                                    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nome do Escritor</th>
                                                <th>Email do Escritor</th>
                                                <th>Editor Responsável</th>
                                                <th>Edital</th>
                                                <th>Estado atual</th>
                                                <th>Data de submissão</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($method->list_user_chapters(filter_input(INPUT_GET, 'email')))): ?>
                                                <?php foreach ($method->list_user_chapters(filter_input(INPUT_GET, 'email')) as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value->id; ?></td>
                                                        <td><?php echo $value->user_nicename?></td>
                                                        <td><?php echo $value->user_email; ?></td>
                                                        <td><?php echo $value->editor_nicename; ?></td>
                                                        <td><?php echo $value->edital; ?></td>
                                                        <td><?php echo $value->status; ?></td>
                                                        <td> - </td>
                                                        <!--<td><a href="#modal-payment" onclick="verPagamento()" data-toggle="modal">Ver Comprovante</a>
                                                            <input class="imgPagamentoComprovante"name="" type="hidden" value="<?php// echo $value->proof_payment; ?>"></td> -->
                                                        <td>
                                                            <!--<a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-create"></a>-->
                                                            <a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-trash"></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php elseif (empty($method->list_user_ebook())):?>
                                                <td><?php echo "Resultados não encontrados"; ?></td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('edital') && (filter_input(INPUT_GET, 'sec')) === ('list')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div >
                            <form >
                                <div class="table-responsive">
                                    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nome</th>
                                                <th>Editor Responsável</th>
                                                <th>Link de Pagamento</th>
                                                <th>Preço</th>
                                                <th>Submissões</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($method->list_editais())): ?>
                                                <?php foreach ($method->list_editais() as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value->id; ?></td>
                                                        <td><?php echo $value->nome_edital ?></td>
                                                        <td><?php echo $value->editor_nicename; ?></td>
                                                        <td><?php echo '<a href = ' . $value->linkpay . '>' . $value->linkpay . '</a>'; ?></td>
                                                        <td><?php echo $value->price; ?></td>
                                                        <td><?php echo '<a href = ' . base_url('setting?tab=edital&sec=listchapters&idEbook=' . $value->id) . '>' . $value->qtdCapitulos . '</a>'; ?></td>
                                                        <!--<td><a href="#modal-payment" onclick="verPagamento()" data-toggle="modal">Ver Comprovante</a>
                                                            <input class="imgPagamentoComprovante"name="" type="hidden" value="<?php// echo $value->proof_payment; ?>"></td> -->
                                                        <td>
                                                            <a href="#modal-edit-edital" onclick="preencherModalEditEdital('<?php echo $value->code; ?>')" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-create" data-toggle="modal"></a>
                                                            <a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-trash"></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php elseif (empty($method->list_user_ebook())):?>
                                                <td><?php echo "teste"; ?></td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-edit-edital" style="padding: 75px 17px 17px 17px; margin-top:25px;">
                    <div class="modal-dialog">
                            <div class="modal-content">
                                        <div class="bg-white p-15">
                                        <div class="modal-body">
                                            <form method="post" action="<?php echo base_url('setting/update?tab=ebook&sec=edit'); ?>">
                                                <div class="form-group">
                                                    <ul class="registered-users-list" style="text-align: center;">
                                                        <li id="files" style="width: 100%;">
                                                            <img id="imgEditoraPasteur" src="https://editorapasteur.com.br/wp-content/uploads/2019/08/LOGO_EDITORA_NOVA-1.png" alt="" style="max-height: 140px;">
                                                            <output id="list"></output>
                                                            <br/>
                                                            <br/>
                                                            <label for=""><b >Capa:</b></label>
                                                            <input type="file" name="" accept="image/*" title="test">
                                                        </li>
                                                    </ul>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Alterar editor</b> <span class="text-danger">*</span></label>
                                                    <select id="selectEditorEdital"name="edit" class="form-control" required>
                                                        <option >Selecionar</option>
                                                        <?php foreach ($method->select_editor() AS $key => $value): ?>
                                                            <option value="<?php echo $value->ID; ?>" <?php echo filter_input(INPUT_POST, 'edit') === $value->ID ? 'selected="selected"' : null; ?>><?php echo $value->user_email; ?> - <?php echo $value->display_name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Código</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-book"></i></span></div>
                                                        <input id="codeEdital" type="text" class="form-control" disabled>
                                                        <input id="codeEditalHidden" type="text" name="code" class="form-control" hidden>
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Alterar nome</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-book"></i></span></div>
                                                        <input id="nameEdital" type="text" name="name" class="form-control" placeholder="Novo nome do edital" value="<?php echo filter_input(INPUT_POST, 'name'); ?>" required>
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Alterar preço</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <div class="input-group-prepend"><span class="input-group-text"><i class="ii logo-usd"></i></span></div>
                                                        <input id="priceEdital" type="number" name="pric" min="1" step="any" class="form-control" placeholder="Insira o preço" value="<?php echo filter_input(INPUT_POST, ''); ?>" required>
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Ajustar link</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <input id="linkEdital" type="text" name="link" class="form-control" placeholder="Insira o Link do Produto" value="<?php echo filter_input(INPUT_POST, ''); ?>" required>
                                                    </div>
                                                </div><!--/form-group-->
                                                <div class="form-group">
                                                    <label for=""><b >Nova descrição</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                        <textarea id="descriptionEdital" type="text" name="desc" class="form-control" placeholder=" Tamanho máximo de 255 caracteres." style="height: 150px; resize: none;" maxlength="255" required><?php echo filter_input(INPUT_POST, 'desc'); ?></textarea>
                                                    </div>
                                                </div><!--/form-group-->

                                                <div class="form-group">
                                                    <label for=""><b >Pdf</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                    <input type="file" id="edital" accept=".pdf" title="test">
                                                    </div>
                                                </div><!--/form-group-->
                                                <div id="edital_output">

                                                </div>

                                                <div class="form-group">
                                                    <label for=""><b >Estado</b> <span class="text-danger">*</span></label>
                                                    <div class="input-group m-b-10">
                                                    <select id="estado" name="ativo"class="form-control" required>
                                                        <option >Selecionar</option>
                                                        <option value="0">Fechado</option>
                                                        <option value="1">Ativo</option>
                                                    </select>
                                                    </div>
                                                </div><!--/form-group-->
                                                
                                                <div class="modal-footer">
                                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                                    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                                                </div>
                                                    
                                                </div><!--/form-group-->
                                            </form>
                                            </div>
                                        </div>
                                </div><!--/col-lg-6-->
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ((filter_input(INPUT_GET, 'tab')) === ('edital') && (filter_input(INPUT_GET, 'sec')) === ('listchapters')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div >
                            <form >
                                <div class="table-responsive">
                                    <table class="table table-striped m-b-0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nome do Escritor</th>
                                                <th>Email do Escritor</th>
                                                <th>Editor Responsável</th>
                                                <th>Edital</th>
                                                <th>Resumo</th>
                                                <th>Estado atual</th>
                                                <th>Data de submissão</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($method->list_edital_chapters(filter_input(INPUT_GET, 'idEbook')))): ?>
                                                <?php foreach ($method->list_edital_chapters(filter_input(INPUT_GET, 'idEbook')) as $key => $value): ?>
                                                    <tr>
                                                        <td><?php echo $value->id; ?></td>
                                                        <td><?php echo $value->user_nicename?></td>
                                                        <td><?php echo $value->user_email; ?></td>
                                                        <td><?php echo $value->editor_nicename; ?></td>
                                                        <td><?php echo $value->edital; ?></td>
                                                        <td><a href="#modal-ver-resumo" data-text="<?php echo $value->content; ?>" value="" onclick="preencherModalVerResumoPorCodigo('<?php echo $value->code; ?>')" data-toggle="modal">Visualizar</a></td>
                                                        <td><?php echo $value->status; ?></td>
                                                        <td> - </td>
                                                        <!--<td><a href="#modal-payment" onclick="verPagamento()" data-toggle="modal">Ver Comprovante</a>
                                                            <input class="imgPagamentoComprovante"name="" type="hidden" value="<?php// echo $value->proof_payment; ?>"></td> -->
                                                        <td>
                                                            <!--<a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-create"></a>-->
                                                            <a href="#modal-edit-chapter" onclick="fillModalEditChapter('<?php echo $value->code; ?>')" style="font-size: 250%; background-repeat: no-repeat;" data-toggle="modal" class="ii ios-create"></a>
                                                            <a href="#" style="font-size: 250%; background-repeat: no-repeat;" class="ii ios-trash"></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php elseif (empty($method->list_user_ebook())):?>
                                                <td><?php echo $method->list_user_ebook(); ?></td>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                        <div >
                        </div>
                    </div><!--/col-lg-12-->
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-ver-resumo" style="padding: 75px 17px 17px 17px;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3>Título:</h3>
                            <input disabled class="form-control" id="modalResumoTitle" ></input>
                            <br>
                            <h4>Resumo:</h4>
                            <br>
                            <textarea disabled class="form-control" id="modalResumoContent" rows="30" ></textarea>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-warning" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Sair</a>
                        </div>
                    </div>
                </div>
                </div><!--/row-->
                <div class="modal modal-message fade" id="modal-edit-chapter" style="padding: 75px 17px 17px 17px;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id="formEditBookModal" action="<?php echo base_url('setting/update_chapter'); ?>">
                                <div class="modal-header">
                                    <div style="text-align: center; width: 100%;">
                                        <img id="imgEditoraPasteur" src="https://editorapasteur.com.br/wp-content/uploads/2020/08/EDITORA-PASTEUR-LOGO-SITE.png" alt="" style="max-width: 130px;">
                                    </div>
                                </div>
                                <div class="modal-body md-col-8">
                                    <div class="form-group">
                                        <label for=""><b >Código:</b> <span id="codeEbookSpan" class="text-danger"></span></label>
                                        <input class="form-control" type="text" id="codeView" disabled value="">
                                        <input class="form-control" type="text" id="codeEbookHiddenInputText" hidden name="code" value="">
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Escritor:</b> <span class="text-danger">*</span></label>
                                        <div class="input-group m-b-10">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="ii ios-book"></i></span></div>
                                            <input disabled id="escritorResponsavelEditChapter" value="" type="text" class="form-control">
                                        </div>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Editor Responsável:</label>
                                        <select id="editorResposavelEditChapter" name="editor" class="form-control">
                                        <?php foreach ($method->select_editor() AS $key => $value): ?>
                                            <option value="<?php echo $value->ID; ?>"><?php echo $value->user_email; ?> - <?php echo $value->display_name; ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b>Edital:</b> </label>
                                        <select id="editalEditChapter" name="edital" class="form-control">
                                            <?php foreach ($method->select_chapters() AS $key => $value): ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                    <div class="form-group">
                                        <label for=""><b >Status atual:</b></label>
                                        <select id="statusEditChapter" name="status" class="form-control">
                                        <?php foreach ($method->select_status() AS $key => $value): ?>
                                                <option value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div><!--/form-group-->
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success"><i class="ii ios-paper-plane"></i>&nbsp;Salvar</button>
                                    <a href="javascript:;" class="btn btn-warning" data-dismiss="modal"><i class="ii ios-exit"></i>&nbsp;Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>