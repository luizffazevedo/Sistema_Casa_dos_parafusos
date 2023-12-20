$(document).ready(function() {
    get_balcony_values();
  });

  function get_balcony_values(){
    console.log($.urlParam('balcony'));
    get_today_expenses();
    getsummary();
    //getHeaderValues();
    $.get({
        url: `balcony/get_balcony_values?balcony=${$.urlParam('balcony')}&date=${$.urlParam('date')}`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            $(".table-body-content-editable").html('');
            result.forEach((element,index) => {
                $('tbody[data-seller-id="'+element.user_id+'"]').append(`
                <tr style="cursor:pointer" href="#modal-edit-value" data-id-value="${element.id}" onclick='fillModal_edit_value(${JSON.stringify(element)})' data-toggle="modal">
                    <td class="cash td_content_editable">${formatToPrice(element.cash)}</td>
                    <td class="cash td_content_editable">${formatToPrice(element.card)}</td>
                    <td class="cash td_content_editable">${formatToPrice(element.pix)}</td>
                    <td class="cash td_content_editable">${element.insert_hour}</td>
                </tr>
                `)

                $(`[data-seller-id-row=${element.user_id}]`).html(`
                <p class="col-3"><b>Dinheiro<br>R$${formatToPrice(element.sum_cash)}</b></p>
                <p class="col-3"><b>Cartão<br>R$${formatToPrice(element.sum_card)}</b></p>
                <p class="col-3"><b>Pix<br>R$${formatToPrice(element.sum_pix)}</b></p>
                `);
            });
            get_clousure_values();
        }
    })
}

function add_row(table_id, branchId){
    window.localStorage.setItem("table_info", JSON.stringify(`{"sellerId":${table_id},"branchId":${branchId}}`))
}

function handle_submit_balcony_value(e){
    e.preventDefault();
    rowInfo = $.parseJSON(($.parseJSON(window.localStorage.getItem("table_info"))));
    sellerId = rowInfo.sellerId;
    branchId = rowInfo.branchId;
    cash = formatToFloat($($("[name='balcony_cash_add']")[0]).val());
    card = formatToFloat($($("[name='balcony_card_add']")[0]).val());
    pix = formatToFloat($($("[name='balcony_pix_add']")[0]).val());

    $.post("balcony/add_register",
        {sellerId, branchId, card , cash , pix},
        function(result){
            if(result.status == "success"){
                get_balcony_values();
                $('#form_add_valcony').trigger("reset");
                $("#modal_add_balcony_value").modal('hide');
                display_message("Adicionado com sucesso", true);
            } else {
                display_message("Houve algum problema com esse procedimento.", false);
            }
    })
    window.localStorage.removeItem('table_info');
}

function handle_submit_balcony_expense(e,branch_office_id){
    e.preventDefault();
    provider = $($("[name='balcony_add_expense_provider']")[0]).val();
    value = $($("[name='balcony_add_expense_value']")[0]).val();

    $.post("balcony/add_balcony_expense",
        {provider, value, branch_office_id},
        function(result){
            if(result.status == "success"){
                get_balcony_values();
                $('#form_add_balcony_expense').trigger("reset");
                $("#modal_add_balcony_expense").modal('hide');
                display_message("Adicionado com sucesso", true);
            } else {
                display_message("Houve algum problema com esse procedimento.", false);
            }
    })
}

function fillModal_edit_value(element){
    $("#balcony_cash_edit").val(formatToPrice(element.cash));
    $("#balcony_card_edit").val(formatToPrice(element.card));
    $("#balcony_pix_edit").val(formatToPrice(element.pix));
    window.localStorage.setItem("edit_row_info", JSON.stringify(element))
}

function handle_edit_balcony_value(e){
    e.preventDefault();
    edit_row_info = ($.parseJSON(window.localStorage.getItem("edit_row_info")));

    id = edit_row_info.id;
    cash = formatToFloat($($("[name='balcony_cash_edit']")[0]).val());
    card = formatToFloat($($("[name='balcony_card_edit']")[0]).val());
    pix = formatToFloat($($("[name='balcony_pix_edit']")[0]).val());

    $.post({url:"balcony/update_balcony_value",
    data:{id, cash, card, pix}, 
    success: function (r) {
        if(r.status === 'success') {
            get_balcony_values();
            $('#form_edit_balcony_value').trigger("reset");
            $("#modal-edit-value").modal('hide');
            display_message("Alterado com sucesso", true);
        } else {
            display_message("Houve algum problema com esse procedimento.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('edit_row_info');
}

function handle_delete_balcony_value(e){
    edit_row_info = $.parseJSON(window.localStorage.getItem("edit_row_info"));
    console.log(edit_row_info);

    id = edit_row_info.id;
    $.post({url:"balcony/delete_balcony_value",
    data:{id}, 
    success: function (r) {
        if(r.status === 'success') {
            get_balcony_values();
            $('#form_edit_balcony_value').trigger("reset");
            $("#modal-edit-value").modal('hide');
            display_message("Removido com sucesso", true);
        } else {
            display_message("Houve algum problema com esse procedimento.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('edit_row_info');
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

function getsummary(){
    $.get({
        url: `balcony/get_sum_balcony_values?balcony=${$.urlParam('balcony')}&date=${$.urlParam('date')}`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response)[0];
            $("#sum_cash").text(formatToPrice(result.sum_cash));
            $("#total_cash").text(formatToPrice(result.sum_cash));
            $("#sum_card").text(formatToPrice(result.sum_card));
            $("#sum_pix").text(formatToPrice(result.sum_pix));
            $("#total").text(formatToPrice(result.total_sum));
            $("#client_number").text(result.client_number);
            $("#total_expense").text(formatToPrice(result.total_expense));
    }
  })
}

function getHeaderValues(){
    $.get({
        url: "balcony/select_user_branch",
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);

            /*result.users.forEach((element,key) => {
                $(`[data-seller-id-row=${element.id}]`).html(`
                <p class="col-3"><b>Dinheiro<br>R$${formatToPrice(result.sums[key].cash)}</b></p>
                <p class="col-3"><b>Cartão<br>R$${formatToPrice(result.sums[key].card)}</b></p>
                <p class="col-3"><b>Pix<br>R$${formatToPrice(result.sums[key].pix)}</b></p>
                `);
            });*/
            
            
            /*$("#sum_cash").text(formatToPrice(result.sum_cash));
            $("#total_cash").text(formatToPrice(result.sum_cash));
            $("#sum_card").text(formatToPrice(result.sum_card));
            $("#sum_pix").text(formatToPrice(result.sum_pix));
            $("#total").text(formatToPrice(result.total_sum));
            $("#client_number").text(result.client_number);
            $("#total_expense").text(formatToPrice(result.total_expense));*/
    }
  })
}

function change_increase(e,field){
    increase = formatToFloat($("#increase_value").text());
    removed = formatToFloat($("#removed_value").text());
    new_value = formatToFloat($(e.target).text());
    $.post({url:"balcony/set_clousure",
    data:{increase,removed},
    success: function (r) {
        get_clousure_values();
        if(r.status === 'success') {
            display_message("Alterado com sucesso", true);
        } else {
            display_message("Houve algum problema com esse procedimento.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) { //Validation error or other reason for Bad Request 400
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('edit_row_info');
   
}

function get_clousure_values(){
    $.get({
        url: `balcony/get_closure_values?balcony=${$.urlParam('balcony')}&date=${$.urlParam('date')}`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response)[0];
            console.log(result);
            $("#increase_value").text(formatToPrice(result.increase));
            $("#removed_value").text(formatToPrice(result.removed));

            removed = $("#removed_value").text();
            total_cash = parseFloat($(($("#total_cash")[0])).text().replace(/\./g, '').replace(',', '.'));

            increase = Number(result.increase);
            to_retrieve = Number($(($("#total_cash")[0])).text().replace(/\./g, '').replace(',', '.'));
            removed = Number(result.removed);
            expense = Number($(($("#total_expense")[0])).text().replace(/\./g, '').replace(',', '.'));

            console.log(increase);
            
            to_retrieve = increase + to_retrieve - removed - expense;
            console.log(to_retrieve);
            $("#to_retrieve").text(formatToPrice(to_retrieve));
        // Acréscimo + venda dinheiro - despesa - retirado
    }
  })
}

function get_today_expenses(){
    $.get({
        url: `balcony/get_today_expenses?balcony=${$.urlParam('balcony')}&date=${$.urlParam('date')}`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            $("#expenses_list").html('');
            if(result.status == 'success'){
                result.data.forEach(element => {
                    $("#expenses_list").append(`<tr style="cursor:pointer" href="#modal-edit-expense-value" onclick='fillModal_edit_expense(${JSON.stringify(element)})' data-toggle="modal">
                    <td>${element.provider}</td>
                    <td>${formatToPrice(element.value)}</td>
                    </tr>`)
                });
            }
    }
  })
}

function fillModal_edit_expense(element){
    console.log(element);
    window.localStorage.setItem("edit_expense_info", JSON.stringify(element))
    $("#balcony_expense_edit_provider").val(element.provider);
    $("#balcony_expense_edit_value").val(formatToPrice(element.value));
}

function handle_edit_expense_value(e){
    edit_expense_info = $.parseJSON(window.localStorage.getItem("edit_expense_info"));

    id = edit_expense_info.id;
    provider = $($("[name='balcony_expense_edit_provider']")[0]).val();
    value = formatToFloat($($("[name='balcony_expense_edit_value']")[0]).val());

    $.post({url:"balcony/edit_expense_value",
    data:{id, provider, value}, 
    success: function (r) {
        if(r.status === 'success') {
            get_balcony_values();
            $('#form_edit_expense_value').trigger("reset");
            $("#modal-edit-expense-value").modal('hide');
            display_message("Alterado com sucesso", true);
        } else {
            display_message("Houve algum problema com esse procedimento.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) {
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('edit_expense_info');
}

function handle_delete_expense(){
    expense_to_delete = ($.parseJSON(window.localStorage.getItem("edit_expense_info")));
    id = expense_to_delete.id;
    console.log(id);

    $.post({url:"balcony/delete_expense",
    data:{id}, 
    success: function (r) {
        if(r.status === 'success') {
            get_balcony_values();
            $('#form_edit_expense_value').trigger("reset");
            $("#modal-edit-expense-value").modal('hide');
            display_message("Despesa excluída com sucesso.", true);
        } else {
            display_message("Houve algum problema com a exclusão da sua despesa.", false);
        }
    },
    error: function( jqXhr ) {
        if( jqXhr.status == 400 ) {
            console.log($.parseJSON( jqXhr.responseText ));
        }
    }})
    window.localStorage.removeItem('edit_expense_info');
}

function select_date(event){
    var href = new URL(window.location.href);
    href.searchParams.set('date', event.target.value);
    window.location.replace(href.toString());
  }

function formatToPrice(double){
    return Number(double).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})
}

function formatToFloat(real){
    return parseFloat(real.replace(/\./g, '').replace(',', '.'));
}

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
       return null;
    }
    return decodeURI(results[1]) || 0;
}