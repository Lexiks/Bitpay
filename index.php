<?php
  include_once ("include/config.php");  //настройки
  include_once ("lang/ru.inc");
  
  include_once ("include/smarty_init.php");//Инициализация smarty
  
  include_once("include/bitcoin/bitcoin.inc");
  include_once ("modules/pay_func.php");
  include_once ("modules/actions.php");
  
  
  include_once ("include/connect.php");
  $user_name = 'tester';

  $BitPay = new BitPay($user_name);
  $action = $_GET["action"];
  
  switch ($action) {
  
        case 'get_btc_balance' : { 
                              $btc_balance_code = GetBTCBalanceCode();
                              echo $btc_balance_code;
                             } break;
        case 'checkout' : { 
                              $checkout_result = $BitPay->DoCheckOut();
                              echo $checkout_result;
                             } break;
        case 'get_usd_balance' : { 
                              $usd_balance = $BitPay->GetUSDBalance();
                              echo $usd_balance;
                             } break;
                             
        case 'get_address' : { 
                              $user_address_code = GetUserAddressCode();
                              echo $user_address_code;
                             } break;
                             
        case 'get_transactions' : ShowTransactions();
        default : ShowDefaultPage();break;
  }
  

?>


