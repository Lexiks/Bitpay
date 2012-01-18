<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="js/jquery.dev.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
{literal}
<script type="text/javascript">
$(document).ready(function() {
  refresh_transactions();
});

function DoCheckout()
{
    $('#checkout').html("<img src='img/ajax-loader.gif'/>");   
    $('#checkout').load('index.php?action=checkout')
    setTimeout(refresh_btc_balance,500);
    setTimeout(refresh_usd_balance,600);
    setTimeout(refresh_transactions,700);
}

function GetTestCoins()
{
    $('#checkout').html("<img src='img/ajax-loader.gif'/>");   
    $('#checkout').load('index.php?action=get_test_coins')
    setTimeout(refresh_btc_balance,500);
    setTimeout(refresh_transactions,700);
    
}

function refresh_usd_balance()
{
    $('#current_usd_balance').html("<img src='img/ajax-loader.gif'/>");   
    $('#current_usd_balance').load('index.php?action=get_usd_balance')
}

function refresh_btc_balance()
{
    $('#current_btc_balance').html("<img src='img/ajax-loader.gif'/>");   
    $('#current_btc_balance').load('index.php?action=get_btc_balance')
}

function refresh_transactions()
{
    $('#transaction_list').html("<img src='img/ajax-loader.gif'/>");   
    $('#transaction_list').load('index.php?action=get_transactions');
}



function get_address()
{
    $('#pay_address').html("<img src='img/ajax-loader.gif'/>");   
    $('#pay_address').load('index.php?action=get_address')
}
</script>
{/literal}
<body>



{$smarty.const.SM_YOUR_ACCOUNT}  : <b id='account'>{$user_name}</b> <a href="index.php?user_name=" > [{$smarty.const.SM_CHANGE_NAME}]</a> <br>
<table cellpadding="0" cellspacing="0" border="0" id="account_table">
<tr><td class="info_col">{$smarty.const.SM_YOUR_BITPAY_ADDRES}:</td> <td width="200px" colspan="2"><b id='pay_address'>{$pay_address}</b></td></tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr><td class="info_col">{$smarty.const.SM_YOUR_CURRENT_BTC_BALANCE} :</td> <td><b id='current_btc_balance'>{$current_btc_balance} </b> BTC<td class="button_col"> <a href="/jse.html" onclick="refresh_btc_balance();return false">{$smarty.const.SM_REFRESH_BTC_BALANCE}</a></td> </tr>
<tr><td class="info_col">{$smarty.const.SM_YOUR_CURRENT_USD_BALANCE} :</td> <td><b id='current_usd_balance'>{$current_usd_balance}</b> $<td class="button_col"> <a href="/jse.html" onclick="refresh_usd_balance();return false">{$smarty.const.SM_REFRESH_USD_BALANCE}</a></td> </tr>
<tr><td colspan="2"><span id="checkout">&nbsp;</span></td><td class="button_col"><a href="/jse.html" onclick="DoCheckout();return false">Перевести BTC в USD</a></td>  <br></tr>
</table>
<br>
<a href="/jse.html"  onclick="GetTestCoins();return false">{$smarty.const.SM_GIVE_ME_TEST_COINS}</a><br>
<a href="index.php?action=get_accounts" target="_blank">{$smarty.const.SM_SHOW_ALL_ACCOUNTS}</a><br>
<br>
{$smarty.const.SM_TRANSACTIONS_LIST} <a  href="/jse.html" onclick="refresh_transactions();return false">{$smarty.const.SM_REFRESH_TRANSACTIONS}</a>
<div id="transaction_list">&nbsp;</div>

{include file='footer.tpl'}
</body>
</html>