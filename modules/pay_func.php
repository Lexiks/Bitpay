<?php
  //наследуем основные функции из класса BitcoinClient
  //inheriting the basic functions form the class BitcoinClient
  class BitPay extends BitcoinClient{  
      var $user_name;
      var $CanConnect = true;
      function __construct($user_name) {
          //Конструктор базового класса
          //base class cnstuctor
          parent::__construct('http',RCP_User,RPC_Password,RPC_Host,RPC_Port);
          $this->user_name = $user_name;
          //Проверяем, нет ли флага недоступности сервера при прошлой операции
          //Checking, is there a error flag
          $this->CanConnect = $this->CanConnect();
      }
      
      //Функция проверки и получения адреса в случае его отсутсвия
      function  validate_address($address) {
          $isvalid = $this->validateaddress($address);
          if ((bool)$isvalid['isvalid']) { 
              return  $address;
          }
              
      }
      function GetUserBTCAddress()
           {
               global $BitPay;
               try {
                    if ($this->CanConnect) {
                       //Есть ли уже такой адрес?
                       //Is there such an address
                        $address_array = $this->getaddressesbyaccount($this->user_name);
                        

                    }
               } catch (BitcoinClientException $e) {
                   // Ошибочка, ставим флаг недоступности сервера на
                   //Error, setiing error flag
                     $this->SetServerErrorFlag();
               }
               if ((isset($address_array)) && (count($address_array) > 0))
               //Если у $user_name уже есть адрес, тогда возвращаем его
               //If $user_name already has an address, so return it
               {
                   return $this->validate_address($address_array[0]);
               }
               else 
               //иначе генерим новый
               //else getting a new address
               {
                   try {
                    if ($this->CanConnect) {
                       //Выдать новый адрес для нашего user_name
                       //Get an new address for our username
                        $address = $this->getnewaddress($this->user_name);
                    }
                 
                   } catch (BitcoinClientException $e) {
                          $this->SetServerErrorFlag();
                    }
                   //Если успешно, возвращает адрес
                   //If success , return it
                   if ((isset($address)) && (count($address) > 0)) return $this->validate_address($address);
               }
           }
           
       //Получение баланса в BTC
       //Getting BTC balance
       function GetUserBTCBalance($user_name = NULL, $min_confirmations_count = NULL)
       {
           if (!isset($min_confirmations_count)) {
               $min_confirmations_count = MIN_CONFIRMATIONS_COUNT;
           }
           
           if (!isset($user_name)) {
               $user_name = $this->user_name;
           }
           try {
                    if ($this->CanConnect) {
                       //Получить  баланс, MIN_CONFIRMATIONS_COUNT - число подтвержденных блоков , после которых показывать баланс, задается в config.php
                       //Gett BTC balance, MIN_CONFIRMATIONS_COUNT - mininum confirmations count , you can set it in config.php
                        $balance = $this->getbalance($user_name,$min_confirmations_count);
                    }
               } catch (BitcoinClientException $e) {
                     $this->SetServerErrorFlag();
               }
           return $balance;
       }  
       
       //Получение списка транзакций для аккаунта
       //Getting transaction list for an account
       function GetUserTransactions()
       {
           try {
                    if ($this->CanConnect) {
                       //Получить  баланс, MIN_CONFIRMATIONS_COUNT - число подтвержденных блоков , после которых показывать баланс, задается в config.php
                        $transactions = $this->listtransactions($this->user_name,100);
                    }
               } catch (BitcoinClientException $e) {
                     $this->SetServerErrorFlag();
               }
           return $transactions;
       }  
       
       //Получение баланса в USD , берется из mysql базы
       //getting USD balance, gets from mysql database
       function GetUSDBalance()
        {
            global $db;
            $balance_array = $db->query('SELECT sum FROM balance WHERE account = ?',$this->user_name);
            if (isset($balance_array) && (count($balance_array) > 0)) {
               $balance =  $balance_array[0]['sum'];
            }
            else $balance = 0;
            return $balance;
        }  
       
       //Пополнение USD баланса, если записаи нет в базе, тогда добавляем, иначе добавляем к текущей сумме
       //Recharge USD balance, if no account in base inserting it, else adding to crrent sum
       function AddUSDBalance($sum)
        {
            global $db;
            try {
                 $result = $db->query('INSERT INTO balance (account,sum) VALUES (?,?) ON DUPLICATE KEY UPDATE sum=sum+?',$this->user_name, $sum, $sum);
            }
            catch (Exception $e) {
                $result = -1;
            }    
        
            return (isset($result)) && ($result >= 0) ;
        }    
        
      //Обмен BTC баланса на USD, внутренним переводом btc списываются с адреса, присвоенного клиенту и переводятся на адрес нашего сервиса, баланс адреса клиента обнуляется
      //BTC balance checkout, BTC are moved by internal transfer, they are debited from the address, assigned to the client and moved to our service account, user BTC balance  resets
      function DoCheckOut()
       {
           $balance = $this->GetUserBTCBalance();
           
           //Курс берем из данных, полученных запросом к API MtGox
           //Echange rate getting from MtGox api
           $mtgox_ticker = GetMtGoxTicker();
           
           if ((isset($mtgox_ticker)) && (count($mtgox_ticker) > 0))
           $ex_rate = $mtgox_ticker['ticker']['last'];

           //Если курс не нолевой и не больше установленного потолка (для подстраховки) , присваиваем текущему курсу этот курс.
           //If rate is correct (not zero and no more than limit), using it
           if (($ex_rate == 0) || ($ex_rate > EX_MAX)){
               $ex_rate = EX_RATE;
           }
           
           //Если на счет что-то есть ... 
           //Is there some bitcoins ///
           if ($balance > 0)
               {      
                  try {
                       if ($this->CanConnect) {
                          //Внутренний перевод BTC с аккаунта клиента, на консолидированный аккаунт нашего сервиса
                          //Internal BTC transfer from the address, assigned to the client, into consolidated service account
                           $move_result = $this->move($this->user_name,MAIN_ACC,$balance,MIN_CONFIRMATIONS_COUNT,'Balance checkout at '.$ex_rate.' USD/BTC');
                       }
                  } catch (BitcoinClientException $e) {
                        $this->SetServerErrorFlag();
                        unset($move_result);
                  }
                 //Проверяем, обнулился ли баланс
                 $check_balance = $this->GetUserBTCBalance();
                 
                 if (($check_balance == 0) && $move_result)
                    //баланс Аккаунта обнулился, значит средства списались, можем пополнить USH баланс
                    {            
                        //Получаем сумму к зачислению 
                        //Getting USD sum
                        $sum = $balance*$ex_rate;
                        
                        //Пополняем баланс
                        //Balance checout
                        $add_balance_result = $this->AddUSDBalance($sum);
                        
                        //Проверки успешности
                        //Is success?
                        if ($add_balance_result) 
                        {
                             $res = '<div class="alert-message block-message success">'.LANG_BALANCE_SUCCESS_CHECKOUT.'<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>';
                        }     
                      
                    }  else {
                        $res = '<div class="alert-message block-message error">'.LANG_BALANCE_ERROR_CHECKOUT.'<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>';
                    }
               }  else {
                        $res = '<div class="alert-message block-message warning">'.LANG_BALANCE_NOTHING_CHECKOUT.'<a class="close" onclick="$(this).parent().fadeOut()">×</a></div>';
                    }
           return $res;
       }       
       
       //Проверка можем ли мы коннектится к базе
       //Can we connect to database?
       private function CanConnect()
       {
        //Проверяем наличие закэшированного времени последнего сбооя
        //Is there time to do request again?
        if (file_exists('cache/error_flag.txt'))
         {
           //Если файл есть , значит был сбой, читаем не пора бы нам попробовать еще раз
           //If there is error flag file, so there was an error
           $f = fopen('cache/error_flag.txt','r');    
           $check_time = fread($f,filesize('cache/error_flag.txt'));
           fclose($f);
           //Если прошло время , тогда даем еще один шанс
           if (time() > $check_time)
           {
               unlink('cache/error_flag.txt');
               return true;
           }
           else return false;
         }  
         else return true;
       }
       
       //Устанвока флага , информаирующего о том, что последний доступ к RPC потерпел неудачу, это тормознет все остальные запросы , время блокировки попыток действия задается ERROR_TIMEOUT в config.php
       //Setting an error flag
       private function SetServerErrorFlag()
       {
        if (!file_exists('cache/error_flag.txt'))
        {
          $f = fopen('cache/error_flag.txt','w');    
          //Сохраняем время, до которого RPC вызобы будут заблокированы, это предотвратит проблемы с зависшими php воркерами. 
          $next_check_time = time()+ERROR_TIMEOUT;
          fwrite($f,$next_check_time);
          fclose($f);
          $this->CanConnect = false;
        }
}         
      
  }//class
   

?>
