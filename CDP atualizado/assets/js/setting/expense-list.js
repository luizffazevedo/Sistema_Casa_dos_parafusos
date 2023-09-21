$(document).ready(function () {
   
    get_expenses();

    $('.dropdown-toggle').dropdown();
    
});


function handle_submit_expense(e){
    e.preventDefault();
    provider = $($("[name='provider_expense_add']")[0]).val();
    value = $($("[name='value_expense_add']")[0]).val();
    payment_date = $($("[name='date_payment_expense_add']")[0]).val();
    approved_date = $($("[name='approved_date_expense_add']")[0]).val();
    description = $($("[name='description_expense_add']")[0]).val();
    status_expense = $($("[name='status_expense_add']")[0]).val();
    expense_type = $($("[name='type_expense_add']")[0]).val();
    
    $.post({url:"setting/insert_expense",
    data:{provider,value,payment_date,approved_date,description,status_expense,expense_type}, 
    success: function (r) {
        if(r.status === 'success') {
            display_message("Despesa adicionada com sucesso.", true);
            $('#form_new_expense').trigger("reset");
            $("#modal-add-expense").modal('hide');
            get_expenses();
        } else {
            display_message("Houve algum problema com a insersão da sua despesa.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
}

function get_expenses(){
    year_month = $('#select_date_expenses').val();
    $.get({
        url: 'setting/get_expenses?year_month='+year_month,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response).data;
            $("#table_expenses").html('');
            result.forEach((expense,index) => {
                $("#table_expenses").append(`
                <tr index="${expense.id}">
                    <td>${expense.provider}</td>
                    <td>${expense.payment_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1")}</td>
                    <td>${expense.approved_date ? expense.approved_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1") : '-'}</td>
                    <td>${Number(expense.value).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    <td>${expense.branch_name ? expense.branch_name : '-'}</td>
                    <td>${expense.status_name}</td>
                    <td>${expense.type}</td>
                    <td>
                        <a href="#modal-edit-expense" onclick='fillModal_edit_expense(${JSON.stringify(expense)})' data-toggle="modal" style="font-size: 180%; color:black;" class="ii ios-create"></a>
                        <a href="#modal-delete-expense" onclick='fillModal_delete_expense(${JSON.stringify(expense)})' data-toggle="modal" style="font-size: 180%; color:black;" class="ii ios-trash"></a>
                        <!--<a href="#" style="font-size: 180%; color:black; margin-left:5px;" class="ii ios-trash"></a>-->
                    </td>
                </tr>
                `)
            });
        }
    })
}

function fillModal_edit_expense(expense){
    $("#id_expense_edit").val(expense.id);
    $("#provider_expense_edit").val(expense.provider);
    $("#value_expense_edit").val(expense.value);
    $("#date_payment_expense_edit").val(expense.payment_date);
    $("#approved_date_expense_edit").val(expense.approved_date);
    $("#description_expense_edit").val(expense.description);
    $("#type_expense_edit").val(expense.expense_type);
    $("#staus_expense_edit").val(expense.status_id);
}

function fillModal_delete_expense(expense){
    window.localStorage.setItem("delete_row_info", JSON.stringify(expense))
    $("#id_expense_delete_info").text(`Você realmente deseja excluir a despesa "${expense.provider}" com data de pagamento para ${expense.payment_date.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1")} no valor de ${Number(expense.value).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})}?`);
}

function handle_delete_expense(e){
    e.preventDefault();
    expense_to_delete = ($.parseJSON(window.localStorage.getItem("delete_row_info")));
    id = expense_to_delete.id;
    console.log(id);

    $.post({url:"setting/delete_expense",
    data:{id}, 
    success: function (r) {
        if(r.status === 'success') {
            display_message("Despesa excluída com sucesso.", true);
            $('#form_delete_expense').trigger("reset");
            $("#modal-delete-expense").modal('hide');
            get_expenses();
        } else {
            display_message("Houve algum problema com a exclusão da sua despesa.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('delete_row_info');
}

function handle_edit_expense(e){
    e.preventDefault();
    id = $($("[name='id_expense_edit']")[0]).val();
    provider = $($("[name='provider_expense_edit']")[0]).val();
    value = $($("[name='value_expense_edit']")[0]).val();
    payment_date = $($("[name='date_payment_expense_edit']")[0]).val();
    approved_date = $($("[name='approved_date_expense_edit']")[0]).val();
    description = $($("[name='description_expense_edit']")[0]).val();
    description = $($("[name='description_expense_edit']")[0]).val();
    status_expense = $($("[name='staus_expense_edit']")[0]).val();
    expense_type = $($("[name='type_expense_edit']")[0]).val();

    $.post({url:"setting/update_expense",
    data:{id,provider,value,payment_date,approved_date,description,status_expense,expense_type}, 
    success: function (r) {
        if(r.status === 'success') {
            display_message("Despesa alterada com sucesso.", true);
            $('#form_edit_expense').trigger("reset");
            $("#modal-edit-expense").modal('hide');
            get_expenses();
        } else {
            display_message("Houve algum problema com a insersão da sua despesa.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
}

function display_message(message,isSuccess){
    if (isSuccess){
        $('.floating-message').text(message);
        $('.floating-message').css('color', 'green');
        $('.floating-message').fadeIn(500, function() {
        setTimeout(function() {
        $('.floating-message').fadeOut(500);
      }, 1500)});
      }else{
        $('.floating-message').text(message);
        $('.floating-message').css('color', 'red');
        $('.floating-message').fadeIn(500, function() {
        setTimeout(function() {
        $('.floating-message').fadeOut(500);
      }, 1500)})
    }
}

function select_date_expenses(){
    get_expenses();
    
}