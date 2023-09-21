$(document).ready(function() {
    get_entries_historic();
    get_exit_historic();
  });

function get_entries_historic(){
    $.get({
        url: `dashboard/get_entries_historic`,
        dataType: "text",
        success: function (response) {
            let entriesHistoric = [];
            result = $.parseJSON(response);
            entriesHistoric.push(['Data', 'A Receber']);
            for(let i = result.length - 1; i >= 0; i--){
                data = (result[i].day);
                value = parseInt(result[i].value)
                entriesHistoric.push([data, value]);
            }
            console.log(entriesHistoric);
            drawEntriesHitoric(entriesHistoric);
        }
    })
}

function drawEntriesHitoric(array) {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    hAxis: {title: 'Dias'},
    seriesType: 'bars',
    series: {5: {type: 'line'}},
    colors: ['#008D8C']

    };

    var chart = new google.visualization.ComboChart(document.getElementById('entries_historic'));
    chart.draw(data, options);
}
function get_exit_historic(){
    $.get({
        url: `dashboard/get_exit_historic`,
        dataType: "text",
        success: function (response) {
            let entriesHistoric = [];
            let result = $.parseJSON(response);
            entriesHistoric.push(['Data', 'A pagar']);
            for(let i = result.length - 1; i >= 0; i--){
                data = (result[i].day);
                value = parseInt(result[i].value)
                entriesHistoric.push([data, value]);
            }
            console.log(entriesHistoric);
            drawEntriesHitoricPayment(entriesHistoric);
        }
    })
}

function drawEntriesHitoricPayment(array) {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable(array);
    var options = {
    hAxis: {title: 'Dias'},
    seriesType: 'bars',
    series: {5: {type: 'line'}},
    colors: ['#674846']
    };

    var chart = new google.visualization.ComboChart(document.getElementById('entries_historic_payment'));
    chart.draw(data, options);
}

function formatToPrice(double){
    return Number(double).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})
}

function formatToFloat(real){
    return parseFloat(real.replace(/\./g, '').replace(',', '.'));
}