<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<script type="text/javascript" src="js/jquery.dev.js"></script>
<script type="text/javascript" src="js/jquery.zclip.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
{include file='topbar.tpl' page_name='main'}
{include file='socket.tpl'}
socket.tpl
<br><br><br><br>

<div class="container">

   <div class="content" style="margin:30 0 5;">
         <div style="width:700px;height:30px; float:left;">
           <div style="color:gray;width:215px;float:left;">
             {$smarty.const.SM_YOUR_BITPAY_ADDRES}:
           </div> 
           <div style="color:gray;width:215px;float:left;font-size:110%">
              <b id='pay_address'>{$pay_address}</b>
           </div>    
           <div style="color:gray;width:215px;float:right;text-align:right">
             <a href="#" id="copy_to_clip" title="{$pay_address}"><span style="font-size:90%">{$smarty.const.SM_COPY_TO_CLIPBOARD}</span></a>
            </div>    
        </div>
        <div style="width:200px;height:30px; float:right;font-size:87%; display:none;" id="last_block">
          <div style="width:90px;float:left;">{$smarty.const.SM_LAST_BLOCK_FOUND}:</div><div style="width:110px;float:right;font-weight:bold" id="last_block_time">&nbsp;</div><br>
          <div style="width:90px;float:left;">№</div><div style="width:110px;float:right;font-weight:bold" id="last_block_num">&nbsp;</div><br>
        </div>
    <table cellpadding="0" cellspacing="0" border="0" id="account_table">

        <tr>
           <td class="info_col">
              {$smarty.const.SM_YOUR_CURRENT_BTC_BALANCE} :
           </td> 
           <td width="280px">
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
           <td width="280px">
             <div style="height:20px;">
               <div style="float:left;"></div>
               <div style="float:right;margin-left:10px;">USD</div>
               <div style="float:right;"><b id='current_usd_balance'>{$current_usd_balance}</b></div>
             </div>
           <td class="button_col"> <a href="js_error.html" onclick="refresh_usd_balance();return false" class="btn">{$smarty.const.SM_REFRESH_USD_BALANCE}</a></td> 
        </tr>
        <tr>
           <td class="info_col">{$smarty.const.SM_CURRENT_EX_RATE}: </td>
           <td><div style="height:20px;">
               <div style="float:left;"></div>
               <div style="float:right;margin-left:10px;">USD/BTC</div>
               <div style="float:right;"><b id='ticker_last'>{$mtgox_ticker.ticker.last}</b></div>
             </div>
           </td>
           <td class="button_col"><a href="js_error.html" onclick="DoCheckout();return false" class="btn success" title="{$smarty.const.SM_DO_CHECKOUT_TITLE}">{$smarty.const.SM_DO_CHECKOUT}</a></td>
        </tr>
    </table>
    <div id="statusbox" style="height:20px">&nbsp;</div>
    <br>
    <a href="js_error.html"  onclick="GetTestCoins('internal');return false" class="btn info" title="{$smarty.const.SM_SM_GIVE_ME_TEST_COINS_TITLE}">{$smarty.const.SM_GIVE_ME_TEST_COINS}</a><span style="color:gray;font-size:90%"> {$smarty.const.SM_GIVE_ME_TEST_COINS2}</span><br><br>
    <a href="js_error.html"  onclick="GetTestCoins('external');return false" class="btn primary" title="{$smarty.const.SM_SM_GIVE_ME_TEST_COINS_TITLE}">{$smarty.const.SM_GIVE_ME_EXT_TEST_COINS}</a><span style="color:gray;font-size:90%"> {$smarty.const.SM_GIVE_ME_EXT_TEST_COINS2}</span><br>
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