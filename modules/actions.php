<?php

  //Отображение первоначальнйо страницы index.php
  // Showing main page index.php
  function ShowTransactions()
  {
      global $BitPay,$smarty;
      
      $transactions = $BitPay->GetUserTransactions();
      
      //заполняем переменные шаблонизатора и выводим страницу
      //Declaring variables and showing the page
      $smarty->assign('transactions',$transactions);
      $smarty->caching = false;
      $smarty->display('transactions.tpl');
      exit;
  }
  
  
  // Показывает остатки по всем счетам.
  //Showing all balances for all accounts
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
      $smarty->caching = false;
      $smarty->display('accounts.tpl');
      }
      else echo "No accounts";
      exit;
  }
    
  
  
    function ShowDefaultPage()
  {
      global $BitPay,$smarty;
      
      //Получаем BTC адрес для нашего клиента , если адреса нет, тогда будет сгенерирован и сохранен в файле wallet.dat
      //Getting BTC address for our user, if there is no addres for this user, it will be generated and saved in file wallet.dat
      $user_address_code = GetUserAddressCode();
      
      //Получаем значения балансов BTC и USD счетов
      //Gettings USD and BTC BALANCES
      $balance_code_confirmed = GetBTCBalanceCode(1);
      $balance_code_unconfirmed = GetBTCBalanceCode(0);
      $usd_balance = $BitPay->GetUSDBalance();
      $mtgox_ticker = GetMtGoxTicker();
        
      //заполняем переменные шаблонизатора и выводим страницу
      //Declaring variables and showing the page
      $smarty->assign('mtgox_ticker',$mtgox_ticker);
      $smarty->assign('user_name',$BitPay->user_name);
      $smarty->assign('pay_address',$user_address_code);
      $smarty->assign('current_btc_balance_confirmed',$balance_code_confirmed);
      $smarty->assign('current_btc_balance_unconfirmed',$balance_code_unconfirmed-$balance_code_confirmed);
      $smarty->assign('current_usd_balance',$usd_balance);
      
      $smarty->caching = false;
      $smarty->display('index.tpl');
      exit;
  }
  
  function ShowUsernamePrompt()
  {
      global $smarty;
      $smarty->caching = false;
      $smarty->display('get_username.tpl');
      exit;
  }
  
  //Отображение баланса по запросу, если баланс получить не удалось, выводиться сообщение об ошибке
  //Balance showing by ajax request, if there is an error , message occurs
   function GetBTCBalanceCode($min_confirmations_count = MIN_CONFIRMATIONS_COUNT)
  {
      global $BitPay;
      $balance = $BitPay->GetUserBTCBalance($BitPay->user_name,$min_confirmations_count);
      if (!isset($balance)) {
         $balance = '<span class="error">'.LANG_CANT_GET_BALANCE.'</span>';
      }
      return $balance;
  }
  
   
  //Отображение адреса по запросу, если баланс получить не удалось, выводиться сообщение об ошибке и код кнопки, нажатие на которую повторяет запрос адреса без перегрузки страницы
  //BTC address showing by ajax request, if there is an error , message occurs
  function GetUserAddressCode()
  {
     global $BitPay;
     $user_address = $BitPay->GetUserBTCAddress();
     if (!isset($user_address)) {
         $user_address = sprintf('<span class="error">%s <a href href="/jse.html" target="_blank" onclick="get_address();return false" class="btn">%s</a></span>', LANG_CANT_GET_ADDRESS, LANG_GET_ADDRESS_AGAIN);
     }
     return $user_address;
  }
  
  //Выдает немного тестовых монет. Делает внутренний перевод из общего кошелька на кошелек клиента (только для теста!)
  //Engolls some test coins. Maked internal move from the common wallet into user waller (use only for test!)
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
  
  //Устанавливает язык
  function SetLanguage($lang)
  {
      SetCookie("lang",$lang,time()+60*60*24*30*12);
      header("Location: index.php");
  }
  
  //Получает данные о курсе BTC/USD используя api биржи MtGox . Запрос кэшируется и делается не чаще одного раза в минуту.
  //Gets BTC/USD exchange rate data , using MgGox Api . 
  function GetMtGoxTicker()
  {
      global $smarty;
      $smarty->caching = true;
      $smarty->cache_lifetime = 60;
      $cache_tag = 'mtgox_ticker';
      //$smarty->clear_all_cache();
      $is_cached = $smarty->isCached('mtgox_ticker.tpl',$cache_tag);
      
      
      //Если есть версия в кэше, тогда выводим ее
      //If there is a cached version, no need to do it again
      if (!$is_cached) {
          $c = new curl('https://mtgox.com/api/0/data/ticker.php') ;
          $c->setopt(CURLOPT_TIMEOUT, 10) ;
          $c->setopt(CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MtGox PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
          $c->setopt(CURLOPT_SSL_VERIFYPEER, FALSE) ;
          $c->setopt(CURLOPT_SSL_VERIFYHOST, FALSE) ;      
          $c->setopt(CURLOPT_RETURNTRANSFER, TRUE) ;      

          $json_data =  $c->exec() ;
             if ($theError = $c->hasError())
            { 
              $result = null;
              $smarty->display('mtgox_ticker.tpl',$cache_tag);
            }
            else
            {
                $result = json_encode($json_data);
                $smarty->assign('json_data',$json_data);
            }

            $c->close() ;
      }
      return json_decode($smarty->fetch('mtgox_ticker.tpl',$cache_tag),true);
        
  }
  
  ?>