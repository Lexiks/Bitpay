<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>




{include file='topbar.tpl' page_name='get_accounts'}
<div class="container">
   <div class="content" style="margin:30 0 5;">
        <div class="page-header" style="height:22px;!important">
          <h3>{$smarty.const.SM_ALL_BTC_BALANCE}</h>
        </div>
        
    <table class="bordered-table" width="200px" style="font-size:110%" id="account_list_table">
       <tr>
         <th>{$smarty.const.SM_ACCOUNT}</th>
         <th>{$smarty.const.SM_BALANCE_BTC}</th>
         <th>{$smarty.const.SM_BALANCE_USD}</th>
         <th>{$smarty.const.SM_CONFIRMATIONS}:</th>
         </tr>


    {foreach from=$accounts key=k item=v}
       <tr>
         <td><a href="index.php?user_name={$k}" target="_blank">{$k}</a></td>
         <td align="right"><b>{$v.BTC_sum}</b></td>
         <td align="right"><b>{$v.USD_sum}</b></td>
         <td align="right"><b>{$v.confirmations}</b></td>
       </tr>
    {/foreach}
    </table>
    <br>
    {$smarty.const.SM_ALL_BTC_BALANCE}: <b>{$balance}</b><br>
    <hr>
    <b>{$smarty.const.SM_INFORMATION}:</b><br><br>
    {$smarty.const.SM_BLOCK_COUNT}: <b>{$info.blocks}</b><br>
    {$smarty.const.SM_CURRENT_DIFFICULTY}: <b>{$info.difficulty}</b><br>
    {$smarty.const.SM_CONNECTIONS}: <b>{$info.connections}</b><br>
    {$smarty.const.SM_BITCOIND_VERSION}: <b>{$info.version}</b><br>
    
  </div>
{include file='footer.tpl'}
</div>

</body>
</html>