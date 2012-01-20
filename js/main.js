$(document).ready(function() {
    //refresh_btc_balance();
    refresh_transactions();
    setInterval(refresh_btc_balance,1000*60);
    setInterval(refresh_transactions,1000*60);
    

      $('#copy_to_clip').zclip({
        path:'js/ZeroClipboard.swf',
        copy:function(){
            $(this).text('copied');
            return $(this).attr('title');
            
        }
    });

});

function HideStatusBox()
{
    setTimeout("$('#statusbox div').fadeOut()",5000);
}

function DoCheckout()
{
    $('#statusbox').show();
    $('#statusbox').html("<img src='img/ajax-loader.gif'/>");   
    $('#statusbox').load('index.php?action=checkout', function() {
        refresh_btc_balance();
        refresh_usd_balance();
        refresh_transactions();
        HideStatusBox();
    });
   
}

function GetTestCoins()
{
    $('#statusbox').show();
    $('#statusbox').html("<img src='img/ajax-loader.gif'/>");   
    $('#statusbox').load('index.php?action=get_test_coins' , function() {
        refresh_btc_balance();
        refresh_transactions();
        HideStatusBox();
    });
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
    $('#ticker_last').html("<img src='img/ajax-loader.gif'/>");   
    $.getJSON('index.php?action=get_btc_balance')
       .success( function(json_data){
        $('#current_btc_balance_confirmed').text(json_data.confirmed); 
        $('#current_btc_balance_unconfirmed').text(json_data.unconfirmed); 
        $('#ticker_last').text(json_data.mtgox_ticker.ticker.last); 
       })   
       .error( function(json_data, textStatus ){
        $('#statusbox').text(textStatus); 
        $('#current_btc_balance_confirmed').text('?'); 
        $('#current_btc_balance_unconfirmed').text('?'); 
        $('#ticker_last').text('?'); 
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
