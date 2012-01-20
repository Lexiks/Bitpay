<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<script src="js/jquery.dev.js"></script>
<script src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
{include file='topbar.tpl' page_name='main'}
<div class="container">
   <div class="content" style="margin:30 0 5;">
     <br>
    <table cellpadding="0" cellspacing="0" border="0" id="account_table">
        <tr><td class="info_col">{$smarty.const.SM_YOUR_BITPAY_ADDRES}:</td> <td width="200px" colspan="2"><b id='pay_address'>{$pay_address}</b></td></tr>
        <tr>
           <td class="info_col">
              {$smarty.const.SM_YOUR_CURRENT_BTC_BALANCE} :
           </td> 
           <td width="250px">
             <div style="height:20px;">
               <div style="float:left;">{$smarty.const.SM_CONFIRMED}:</div>
               <div style="float:right;margin-left:10px;">BTC</div>
               <div style="float:right;"><b id='current_btc_balance_confirmed'>{$current_btc_balance_confirmed} </b></div>
             </div>
             <div style="color:gray;height:20px;">
               <div style="float:left;">{$smarty.const.SM_UNCONFIRMED}:</div>
               <div style="float:right;margin-left:10px;">BTC</div>
               <div style="float:right;"><b id='current_btc_balance_unconfirmed'>{$current_btc_balance_unconfirmed} </b></div>
             </div>
           </td>
           
           <td class="button_col"> 
               <a href="js_error.html" onclick="refresh_btc_balance();return false" class="btn">{$smarty.const.SM_REFRESH_BTC_BALANCE}</a><br><span style="color:gray;font-size:90%;">({$smarty.const.SM_REFRESH_BTC_BALANCE_SIGN})</span>
           </td> 
        </tr>
        <tr>
           <td class="info_col">{$smarty.const.SM_YOUR_CURRENT_USD_BALANCE} :</td> 
           <td width="250px">
             <div style="height:20px;">
               <div style="float:left;"></div>
               <div style="float:right;margin-left:10px;">USD</div>
               <div style="float:right;"><b id='current_usd_balance'>{$current_usd_balance}</b></div>
             </div>
           <td class="button_col"> <a href="js_error.html" onclick="refresh_usd_balance();return false" class="btn">{$smarty.const.SM_REFRESH_USD_BALANCE}</a></td> 
        </tr>
        <tr>
           <td colspan="2"><span id="checkout">&nbsp;</span></td><td class="button_col"><a href="js_error.html" onclick="DoCheckout();return false" class="btn success" title="{$smarty.const.SM_DO_CHECKOUT_TITLE}">{$smarty.const.SM_DO_CHECKOUT}</a></td>
        </tr>
    </table>
    <div id="statusbox" style="height:20px">&nbsp;</div>
    <br>
    <a href="js_error.html"  onclick="GetTestCoins();return false" class="btn info" title="{$smarty.const.SM_SM_GIVE_ME_TEST_COINS_TITLE}">{$smarty.const.SM_GIVE_ME_TEST_COINS}</a><span style="color:gray;"> {$smarty.const.SM_GIVE_ME_TEST_COINS2}</span><br>
    <br>
      <div>
       <div style="float:left;">{$smarty.const.SM_TRANSACTIONS_LIST}</div> 
       <div style="float:right;"><a  href="js_error.html" onclick="refresh_transactions();return false" class="btn">{$smarty.const.SM_REFRESH_TRANSACTIONS}</a></div>
     </div>
    <br><br>
    <div id="transaction_list">&nbsp;</div>
   </div>    

   {include file='footer.tpl'}
   </div>    
  


</body>
</html>