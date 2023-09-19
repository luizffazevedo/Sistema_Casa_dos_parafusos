$(document).ready(function() {
    get_payments_values();
    get_balcony_values();
    get_atendments();
    get_balcony_payments_chart();
    get_expenses_chart();
  });

function get_payments_values(){
    $.get({
        url: `dashboard/get_payments_values`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            item = result[0];
            $("#to_receive").text("R$"+formatToPrice(item.to_receive));
            $("#to_pay").text("R$"+formatToPrice(item.to_pay));
            $("#received").text("R$"+formatToPrice(item.received));
            $("#payied").text("R$"+formatToPrice(item.payied));
        }
    })
}

function get_balcony_values(){
    $.get({
        url: `dashboard/get_balcony_values_dashboard`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            item = result[0];
            $("#total_balcony").text("R$"+formatToPrice(item.total_balcony));
            $("#to_remove").text("R$"+formatToPrice(item.to_remove));
            $("#removed").text("R$"+formatToPrice(item.removed));
            $("#expense_value").text("R$"+formatToPrice(item.expense_value));
        }
    })
}

function get_atendments(branch_id){
    $.get({
        url: `dashboard/get_atendments?balcony_branch_id=${branch_id}`,
        dataType: "text",
        success: function (response) {
            let presenceArray = [];
            result = $.parseJSON(response);
            for(let i = result.length - 1; i >= 0; i--){
                data = (result[i].date);
                bm = parseInt(result[i].q_bm);
                ap = parseInt(result[i].q_ap);
                ret = parseInt(result[i].q_ret);
                presenceArray.push([data, bm, ap, ret]);
            }
            drawPresenceChart(presenceArray);
        }
    })
}

function drawPresenceChart(array) {
    // Some raw data (not necessarily accurate)
    let data = new google.visualization.DataTable();
      data.addColumn('string', 'X');
      data.addColumn('number', 'Barra Mansa');
      data.addColumn('number', 'Amaral Peixoto');
      data.addColumn('number', 'Retiro');
      data.addRows(array);
      var options = {
        hAxis: {
          title: 'Dia'
        },
        vAxis: {
          title: 'Atendimentos'
        },
        curveType: "function",
        colors: ['#49AF4A', '#008D8C', '#304F51', '#49637B']
      };
    var chart = new google.visualization.LineChart(document.getElementById('presence_chart'));
    chart.draw(data, options);
}

function get_balcony_payments_chart(){
    $.get({
        url: `dashboard/get_balcony_payments`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            let valuesArray = [];

            valuesArray.push(['Data', 'Barra Mansa', 'Amaral Peixoto', 'Retiro', 'Média']);

            for(let i = result.length - 1; i >= 0; i--){
                data = (result[i].date);
                bm = parseFloat(result[i].bm_value);
                ap = parseFloat(result[i].ap_value);
                ret = parseFloat(result[i].ret_value);
                avarage = parseFloat(result[i].avarage);
                valuesArray.push([data, bm, ap, ret,avarage]);
            }
            drawBalconyPayments(valuesArray);
        }
    })
}

function drawBalconyPayments(array) {
    // Format currency values as Brazilian currency
    let formatter = new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });

    // Create data table
    let data = google.visualization.arrayToDataTable(array);

    // Format currency values in data table
    for (let i = 1; i < data.getNumberOfColumns(); i++) {
        for (let j = 0; j < data.getNumberOfRows(); j++) {
            let value = data.getValue(j, i);
            if (typeof value === 'number') {
                data.setFormattedValue(j, i, formatter.format(value));
            }
        }
    }

    // Set chart options
    let options = {
        'height':350,
        vAxis: {
            title: 'Valor Venda',
            format: 'R$ ', // Use Brazilian currency format
        },
        hAxis: {title: 'Dia'},
        seriesType: 'bars',
        series: {3: {type: 'line'}},
        colors: ['#49AF4A', '#008D8C', '#304F51', '#49637B']
    };

    // Create and draw chart
    let chart = new google.visualization.ComboChart(document.getElementById('balony_valyes_chart'));
    chart.draw(data, options);
}

function get_expenses_chart(){
    let expenseArray = [];
    expenseArray.push(['Tipo Despesa', 'Valor'])
    $.get({
        url: `dashboard/get_expenses_chart`,
        dataType: "text",
        success: function (response) {
            result = $.parseJSON(response);
            console.log(result);
            item = result[0];
            expenseArray.push(['Fixa', item.fix_expense ? Number(item.fix_expense) : 0])
            expenseArray.push(['Pessoal', item.personal_expense ? Number(item.personal_expense) : 0])
            expenseArray.push(['Balcão', item.bancony_expense ? Number(item.bancony_expense) : 0])
            expenseArray.push(['Folha', item.bancony_expense ? Number(item.payroll) : 0])
            drawExpenseChart(expenseArray);
        }
    })
}

function drawExpenseChart(array) {
    let data = google.visualization.arrayToDataTable(array);
    let options = {
      title: 'Despesas - Mês',
      colors: ['#49AF4A', '#008D8C', '#304F51', '#55A38B'],
      height: 250,
      vAxis: {
        format: 'currency',
        currencySymbol: 'R$ '
      }
    };
    let chart = new google.visualization.PieChart(document.getElementById('expense_chart'));
    chart.draw(data, options);
  }

function formatToPrice(double){
    return Number(double).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})
}

function formatToFloat(real){
    return parseFloat(real.replace(/\./g, '').replace(',', '.'));
}