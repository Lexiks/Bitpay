<?php
    
    //Настройки доступа к базе
    define('DB_Host','localhost');
    define('DB_Databse','bitpay');
    define('DB_User', 'root');
    define('DB_Password','');
    
    //Настройки RPC bitcoind сервера
    define('RPC_Host','192.168.0.32');
    define('RPC_Password','xxx');
    define('RCP_User','xxx');
    define('RPC_Port','8332');
    
    //Основной , консолидированный, аккаунт на который будут переводиться BTC с клиентских счетов
    DEFINE(MAIN_ACC,'BaseAcc');
    
    //Обменый курс
    DEFINE(EX_RATE,7);
    
    //Минимальное число блоков подтверждения, после которых будет виден баланс (0 - сразу)
    DEFINE(MIN_BLOCK_COUNT,0);
    
    //Время (сек) на протяжении которого все попытки доступа к RPC будут блокированы после последнего сбоя
    DEFINE(ERROR_TIMEOUT,10);
    
?>
