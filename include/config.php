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
    DEFINE(MAIN_ACC,'WalletBank');
    
    //Обменый курс
    DEFINE(EX_RATE,7);

    //Ограничение потолока обменного курса для подстраховки
    DEFINE(EX_MAX,8);
    
    //Минимальное число блоков подтверждения, после которых будет виден баланс (0 - сразу)
    DEFINE(MIN_CONFIRMATIONS_COUNT,1);
    
    //Время (сек) на протяжении которого все попытки доступа к RPC будут блокированы после последнего сбоя
    DEFINE(ERROR_TIMEOUT,10);
    
?>
