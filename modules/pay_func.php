<?php
  //наследуем основные функции из класса BitcoinClient
  class BitPay extends BitcoinClient{  
      var $user_name;
      var $CanConnect = true;
      function __construct($user_name) {
          //Конструктор базового класса
          parent::__construct('http',RCP_User,RPC_Password,RPC_Host,RPC_Port);
          $this->user_name = $user_name;
          //Проверяем, нет ли флага недоступности сервера при прошлой операции
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
                       //Еслть ли уже такой адрес?
                        $address_array = $this->getaddressesbyaccount($this->user_name);
                        

                    }
               } catch (BitcoinClientException $e) {
                   // Ошибочка, ставим флаг недоступности сервера на
                     $this->SetServerErrorFlag();
               }
               if ((isset($address_array)) && (count($address_array) > 0))
               //Если у $user_name уже есть адрес, тогда возвращаем его
               {
                   return $this->validate_address($address_array[0]);
               }
               else 
               //иначе генерим новый
               {
                   try {
                    if ($this->CanConnect) {
                       //Выдать новый адрес для нашего user_name
                        $address = $this->getnewaddress($this->user_name);
                    }
                 
                   } catch (BitcoinClientException $e) {
                          $this->SetServerErrorFlag();
                    }
                   //Если успешно, возвращает адрес
                   if ((isset($address)) && (count($address) > 0)) return $this->validate_address($address);
               }
           }
           
       //Получение баланса в BTC
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
                        $balance = $this->getbalance($user_name,$min_confirmations_count);
                    }
               } catch (BitcoinClientException $e) {
                     $this->SetServerErrorFlag();
               }
           return $balance;
       }  
       
       //Получение списка транзакций для аккаунта
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
      function DoCheckOut()
       {
           $balance = $this->GetUserBTCBalance();
           //Если на счет что-то есть ... 
           if ($balance > 0)
               {      
                  try {
                       if ($this->CanConnect) {
                          //Внутренний перевод BTC с аккаунта клиента, на консолидированный аккаунт нашего сервиса
                           $move_result = $this->move($this->user_name,MAIN_ACC,$balance,MIN_CONFIRMATIONS_COUNT,'Balance checkout at '.EX_RATE.' USD/BTC');
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
                        $sum = $balance*EX_RATE;
                        
                        //Пополняем баланс
                        $add_balance_result = $this->AddUSDBalance($sum);
                        
                        //Проверки успешности
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
       private function CanConnect()
       {
        //Проверяем наличие закэшированного времени последнего сбооя
        if (file_exists('cache/error_flag.txt'))
         {
           //Если файл есть , значит был сбой, читаем не пора бы нам попробовать еще раз
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
