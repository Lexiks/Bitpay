<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
{include file='topbar.tpl' page_name='about'}
<div class="container">
   <div class="content" style="margin:30 0 5;">
        <div class="page-header" style="height:22px;!important">
          <h3>{$smarty.const.SM_BAR_ABOUT}:</h3>
        </div>
  <h2><b> Example payments implementation, using Bitcoin network instruments.</b></h2>
This is an example  how you can easily customize the reception of BTC in your service.<br>
It is written in php and using the modified <a href="http://github.com/mikegogulski/bitcoin-php" target="_blank"> bitcoin-php</a> library<br>
Source code is totally free and available on <a href="http://github.com/Lexiks/Bitpay" target="_blank"> GitHub </a><br><br>
Bitcoind daemon is hosted on the free <a href="http://aws.amazon.com/free/" target="_blank">Amazon AWS</a> cloud account.<br>
<br>
<h3><b>Description of this demos:</b></h3><br>
<br>
In the first page you will be prompted to enter any nick and then you will get to the <a href="index.php" target="_blank">main page</a>. <br>
If there is first login using this nick, bitcoin address will be generated, if this nick was used earlier, account address, attached to this nick will be displayed 
Address is assigned to the account and will not change. <br>
After BTC transfer to this address, the amount sum first will be displayed in the column <b>"Unconfirmed"</b><br>
After network confirms this payment, the amount will be displayed in the <b>"Confirmed"</b> column.<br>
<br>
Once the payment will be confirmed, you can exchange BTC into USD by clicking the <b>"Checkout BTC to USD” </b> button.<br>
<br>
The <b>"Checkout BTC to USD"</b> button resets the user BTC balance by transferring the entire amount to the consolidated service address (which is in the same purse, so this translation is internal and does not require confirmation by the network), and gives corresponding amount in foreign currency. For simplicity, we captured the balance in USD, but it could be any internal currency of your service.<br>
In most cases you can do payments automatically, but you can provide a choice for your users to spend their coins different ways. For example, In case the game services, it would look like this:<br>
"Enroll Gold" (rate 1 BTC = 7 Gold)<br>
"Enroll Silver" (rate 1 BTC = 100 Silver)<br>
...<br>
<br>
The <b>"Update BTC balance"</b> button checks are any payments were received and displays the total amount. The balance is automatically updated every minute. <br>
<b>"Update USD Balance"</b> displays the value of the dollar balance (stored in a mysql database).<br>
<br>
<b>"Enroll some test coins"</b> - gives some test coins into clients account in order to be able to try how it works. (this is for test only)<br>
<br>
Clicking <a href="index.php?action=get_accounts" target="_blank"> All accounts </a> link you can see the balances of all accounts of this wallet.<br>
<b>WalletBank</b> - main account (you can change this name in config.php).<br> 
<br>
Transaction List shows all BTC transactions for a current account. <br>
<b>External move</b> - means that BTC received from the Bitcoin network <br>
<b>Internal move</b> - means that the BTC was moved from internal account or were exchanged to USD.  <br>
<br>
<h3><b>Script algorithm illustration :</b></h3><br>
<img src= "http://img220.imageshack.us/img220/1373/bitcoinden.png"/>
<h3><b>Notes:</b></h3><br>
<br>
All transactions and balances with all the transactions of BTC are stored / handled directly ins BTC database (which is hosted in Amazon AWS cloud).<br>
Mysql database in used only for storing  USD balances.<br>
You can create new accounts, just follow the link <a href="http://bitpay.tk/index.php?user_name=">[Change]</a>, and enter any other name.<br>
Authorization in this demo mode, if you will use this script at work, of course, use a normal identification method.<br>
<br>
Sources are distributed under free license, anyone is free to copy, modify, publish, use, compile, sell, or distribute this software, either in source code form or as a compiled binary, for any purpose, commercial or non-commercial, and by any means.<br>
 Any suggestions, bugreports and omissions are accepted. You can contact me any  <a href="index.php?action=contact"  target="_blank">way</a>.<br>
<br>
Also it would be great if someone audit the code and point to the weaknesses and errors that can lead to problems in production.<br>
<br>
* Do not berate me for this translation. English is not my native language, so I did it as I can. :) In Russian it sounds better. <br>
    
  </div>
{include file='footer.tpl'}
</div>

</body>
</html>