<?php
  session_start();
  error_reporting(4);
  include_once ("include/config.php");  //настройки
  include_once ("include/lang.php");
  include_once ("include/class.curl.php");  
  
  include_once ("include/smarty_init.php");//Инициализация smarty
  
  include_once("include/bitcoin/bitcoin.inc");
  include_once ("modules/pay_func.php");
  include_once ("modules/actions.php");
  
  if (!function_exists('json_encode')) 
      include_once ("include/json.php");
  
  include_once ("include/connect.php");
  
  $action = $_GET["action"];
  $user_name = preg_replace ("/[^a-zA-Z0-9]/","",$_SESSION["user_name"]);
   
  if (isset($_GET['user_name'])) {
      if ((strtolower($_GET['user_name'])) === (strtolower(MAIN_ACC))) {
          echo CANT_USE_MAIN_ACC;
          echo ' <a href="index.php?user_name=" > [Изменить имя]</a>';
          exit;
      }
      $_SESSION["user_name"] = $_GET['user_name'];
  }  
      
  if (empty($_SESSION["user_name"])) {
      ShowUsernamePrompt();
      }
  else {
     $user_name = $_SESSION['user_name']; 
  }    
  
  
  $BitPay = new BitPay($user_name);
  
  switch ($action) {
  
        case 'get_btc_balance' : { 
                              $balance_code_confirmed = GetBTCBalanceCode(1);
                              if (is_numeric($balance_code_confirmed)){
                                  $balance_code_unconfirmed = GetBTCBalanceCode(0);
                                  $balance_code_unconfirmed = $balance_code_unconfirmed-$balance_code_confirmed;
                                  $mtgox_ticker = GetMtGoxTicker();
                                  $balance_code = array('confirmed' => $balance_code_confirmed, 'unconfirmed' => $balance_code_unconfirmed, 'mtgox_ticker' => $mtgox_ticker);
                                  $btc_balance_code = json_encode($balance_code);
                              }
                                 
                              echo $btc_balance_code;
                             } break;
        case 'checkout' : { 
                              $checkout_result = $BitPay->DoCheckOut();
                              echo $checkout_result;
                             } break;
                             
        case 'get_test_coins' : { $test_result = GetTestCoins();
                                 echo $test_result;    
                                 exit;
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
        case 'get_accounts' : ShowAllAccounts();
        
        case 'about' : $smarty->display('about.tpl'); break; 
        case 'contact' : $smarty->display('contact.tpl');  break;
        
        case 'set_lang' : SetLanguage($lang);break;
        
        default : ShowDefaultPage();break;
  }
  

?>


