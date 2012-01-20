$(document).ready(function() {
    //refresh_btc_balance();
    refresh_transactions();
    setInterval(refresh_btc_balance,1000*60);
    setInterval(refresh_transactions,1000*60);
});
function HideStatusBox()
{
    setTimeout("$('#statusbox div').fadeOut()",1700);
}

function DoCheckout()
{
    $('#statusbox').show();
    $('#statusbox').html("<img src='img/ajax-loader.gif'/>");   
    $('#statusbox').load('index.php?action=checkout')
    setTimeout(refresh_btc_balance,500);
    setTimeout(refresh_usd_balance,600);
    setTimeout(refresh_transactions,700);
    HideStatusBox();
}

function GetTestCoins()
{
    $('#statusbox').show();
    $('#statusbox').html("<img src='img/ajax-loader.gif'/>");   
    $('#statusbox').load('index.php?action=get_test_coins')
    setTimeout(refresh_btc_balance,500);
    setTimeout(refresh_transactions,700);
    HideStatusBox();
}

function refresh_usd_balance()
{
    $('#current_usd_balance').html("<img src='img/ajax-loader.gif'/>");   
    $('#current_usd_balance').load('index.php?action=get_usd_balance')
}

function refresh_btc_balance()
{
    $('#current_btc_balance_confirmed').html("<img src='img/ajax-loader.gif'/>");   
    $('#current_btc_balance_unconfirmed').html("<img src='img/ajax-loader.gif'/>");   
    $.getJSON('index.php?action=get_btc_balance')
       .success( function(json_data){
        $('#current_btc_balance_confirmed').text(json_data.confirmed); 
        $('#current_btc_balance_unconfirmed').text(json_data.unconfirmed); 
       })   
       .error( function(json_data, textStatus ){
        $('#statusbox').text(textStatus); 
        $('#current_btc_balance_confirmed').text('?'); 
        $('#current_btc_balance_unconfirmed').text('?'); 
       });    

}

function refresh_transactions()
{
    $('#transaction_list').fadeOut('fast', function () {
      $('#transaction_list').html("<img src='img/ajax-loader.gif'/>");   
      $('#transaction_list').load('index.php?action=get_transactions', function () { $('#transaction_list').fadeIn(); });
    });
    
}



function get_address()
{
    $('#pay_address').html("<img src='img/ajax-loader.gif'/>");   
    $('#pay_address').load('index.php?action=get_address')
}
