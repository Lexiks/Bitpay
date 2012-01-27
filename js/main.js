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

function GetTestCoins(method)
{
    $('#statusbox').show();
    $('#statusbox').html("<img src='img/ajax-loader.gif'/>");   
    $('#statusbox').load('index.php?action=get_test_coins&method='+method, function() {
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

function show_message(text)
{
    $('#statusbox').html('<div class="alert-message block-message warning">' + text + '<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>');
    HideStatusBox();
}

function new_block_found(block)
{
    var text = 'New block! <b>№</b> ' + block.height  + ' <b>Work:</b> ' + block.work + ' <b>New best:</b> ' + block.best;
    $('#statusbox').html('<div class="alert-message block-message warning">' + text + '<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>');
    $('#statusbox').show();
    
    var d = new Date();
    $('#last_block_time').html(d.toLocaleTimeString());    
    $('#last_block_num').html(block.height);    

    $('#last_block').show();
    refresh_btc_balance(function (){
         HideStatusBox();
    });
    refresh_transactions();
}

function refresh_btc_balance(callback)
{
    $('#current_btc_balance_confirmed').html("<img src='img/ajax-loader.gif'/>");   
    $('#current_btc_balance_unconfirmed').html("<img src='img/ajax-loader.gif'/>");   
    $('#ticker_last').html("<img src='img/ajax-loader.gif'/>");   
    $.getJSON('index.php?action=get_btc_balance')
       .success( function(json_data){
        $('#current_btc_balance_confirmed').text(json_data.confirmed); 
        $('#current_btc_balance_unconfirmed').text(json_data.unconfirmed); 
        $('#ticker_last').text(json_data.mtgox_ticker.ticker.last); 
        if ( callback ){ 
                    callback(); 
                }
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
