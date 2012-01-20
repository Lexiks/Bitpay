<?php

  //Отображение первоначальнйо страницы index.php
  function ShowTransactions()
  {
      global $BitPay,$smarty;
      $transactions = $BitPay->GetUserTransactions();
      
      //заполняем переменные шаблонизатора и выводим страницу
      $smarty->assign('transactions',$transactions);
      $smarty->display('transactions.tpl');
      exit;
  }
  
  
  // Показывает остатки по всем счетам.
  function ShowAllAccounts()
  {
      global $BitPay,$smarty,$db;
      $accounts = $BitPay->listaccounts();
      $receivedbyaccount = $BitPay->listreceivedbyaccount(0);
      if (count($accounts) > 0){
          $balance_array = $db->query('SELECT * FROM balance');
          foreach ($accounts as $key => $value){
              $accounts[$key] = array('BTC_sum' => $value,'USD_sum' => 0);
          }
          foreach ($balance_array as $key => $value){
              $account = $value['account'];
              $sum = $value['sum'];
              if (isset($accounts[$account])){
                  $accounts[$account]['USD_sum'] = $sum;
              }
          }
          foreach ($receivedbyaccount as $key => $value){
              $account = $value['account'];
              $confirmations = $value['confirmations'];
              if (isset($accounts[$account])){
                  $accounts[$account]['confirmations'] = $confirmations;
              }
          }
          
          
          
          $balance = $BitPay->getbalance();
          $info = $BitPay->getinfo();

          $smarty->assign('accounts',$accounts);
          $smarty->assign('balance',$balance);
          $smarty->assign('info',$info);
      $smarty->display('accounts.tpl');
      }
      else echo "No accounts";
      exit;
  }
    
  
  
    function ShowDefaultPage()
  {
      global $BitPay,$smarty;
      
      //Получаем BTC адрес для нашего клиента , если адреса нет, тогда будет сгенерирован и сохранен в файле wallet.dat новый
      $user_address_code = GetUserAddressCode();
      
      //Получаем значения балансов BTC и USD счетов
      $balance_code_confirmed = GetBTCBalanceCode(1);
      $balance_code_unconfirmed = GetBTCBalanceCode(0);
      $usd_balance = $BitPay->GetUSDBalance();
      //заполняем переменные шаблонизатора и выводим страницу
      $smarty->assign('page_name','main');
      $smarty->assign('user_name',$BitPay->user_name);
      $smarty->assign('pay_address',$user_address_code);
      $smarty->assign('current_btc_balance_confirmed',$balance_code_confirmed);
      $smarty->assign('current_btc_balance_unconfirmed',$balance_code_unconfirmed-$balance_code_confirmed);
      $smarty->assign('current_usd_balance',$usd_balance);
      $smarty->display('index.tpl');
      exit;
  }
  
  function ShowUsernamePrompt()
  {
      global $smarty;
      $smarty->display('get_username.tpl');
      exit;
  }
  
  //Отображение баланса по запросу, если баланс получить не удалось, выводиться сообщение об ошибке
   function GetBTCBalanceCode($min_confirmations_count = MIN_CONFIRMATIONS_COUNT)
  {
      global $BitPay;
      $balance = $BitPay->GetUserBTCBalance($BitPay->user_name,$min_confirmations_count);
      if (!isset($balance)) {
         $balance = '<span class="error">'.LANG_CANT_GET_BALANCE.'</span>';
      }
      return $balance;
  }
  
   
  //Отображение баланса по запросу, если баланс получить не удалось, выводиться сообщение об ошибке и код кнопки, нажатие на которую повторяет запрос адреса без перегрузки страницы
  function GetUserAddressCode()
  {
     global $BitPay;
     $user_address = $BitPay->GetUserBTCAddress();
     if (!isset($user_address)) {
         $user_address = sprintf('<span class="error">%s <a href href="/jse.html" target="_blank" onclick="get_address();return false" class="btn">%s</a></span>', LANG_CANT_GET_ADDRESS, LANG_GET_ADDRESS_AGAIN);
     }
     return $user_address;
  }
  
  function GetTestCoins()
  {
      global $BitPay;
      $balance = $BitPay->GetUserBTCBalance(MAIN_ACC);
      if ($balance > 0) {
          $sum = $balance/5;
      }
        else {
         $sum = 0;   
      }
      if ($sum > 0) {
          $BitPay->move(MAIN_ACC,$BitPay->user_name,$sum,1,'Test account refill');
          return '<div class="alert-message block-message success">'.LANG_TEST_COINS_OK.'<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>';
      }
      else {
          return '<div class="alert-message block-message error">'.LANG_TEST_NOCOINS.'<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>';
      }
      
  }
  
  function SetLanguage($lang)
  {
      SetCookie("lang",$lang,time()+60*60*24*30*12);
      header("Location: index.php");
  }
  
  ?>