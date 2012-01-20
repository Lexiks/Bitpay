<?php
   define(LANG_CANT_GET_ADDRESS,'Не удалось получить адрес, попробуте сгенерировать его еще раз');
   define(LANG_GET_ADDRESS_AGAIN,'Получить адрес для платежа');
   define(LANG_BALANCE_SUCCESS_CHECKOUT,'Баланс успешно пополнен');
   define(LANG_BALANCE_ERROR_CHECKOUT,'Ошибка перевода баланса.');
   define(LANG_BALANCE_NOTHING_CHECKOUT,'Нечего выводить, BTC баланс = 0.');
   define(LANG_CANT_GET_BALANCE,'Не удалось получить баланс, попробуйте обновить баланс позже.');

//Тестовые
   define(LANG_TEST_COINS_OK,'Тестовые монеты зачислены');
   define(LANG_TEST_NOCOINS,'Тестовые монеты закончились');
   define(CANT_USE_MAIN_ACC,'Этот аккаунт использовать нельзя');
   
// Шаблоны

 //index.tpl
 define(SM_YOUR_ACCOUNT,'Ваш аккаунт');
 define(SM_CHANGE_NAME,'Сменить');
 define(SM_YOUR_BITPAY_ADDRES,'Ваш BitCoin адрес для оплаты');
 define(SM_YOUR_CURRENT_BTC_BALANCE,'Ваш текущий BTC баланс');
 define(SM_YOUR_CURRENT_USD_BALANCE,'Ваш текущий USD баланс');
 define(SM_REFRESH_BTC_BALANCE,'Обновить BTC баланс');
 define(SM_REFRESH_BTC_BALANCE_SIGN,'Автобновление 1 раз в мин.');
 
 define(SM_REFRESH_USD_BALANCE,'Обновить USD баланс');
 define(SM_GIVE_ME_TEST_COINS,'Зачислить немного тестовых монет');
 define(SM_GIVE_ME_TEST_COINS2,'(Переводятся внутренним переводом из аккаунта, который находится на этом же кошельке)');
 define(SM_SHOW_ALL_ACCOUNTS,'Просмотреть остатки по всем аккаунтам на кошельке');
 define(SM_REFRESH_TRANSACTIONS,'Обновить транзакции');
 define(SM_TRANSACTIONS_LIST,'Список транзакций:');
 define(SM_DO_CHECKOUT,'Перевести BTC в USD');
 define(SM_DO_CHECKOUT_TITLE,'Обнуляет BTC баланс и конвертирует его в USD баланс по текущему, указанному в настройках, курсу');
 define(SM_SM_GIVE_ME_TEST_COINS_TITLE,'Используется только для демонстрации, переводит немного BTC с основного консолидированного аккаунта на текущий');
 define(SM_CURRENT_EX_RATE,'Текущий обменный курс');
 
 
 
 define(SM_CONFIRMED,'Подтверждено');
 define(SM_UNCONFIRMED,'Ожидает подтверждения');
 
 define(SM_COPY_TO_CLIPBOARD,'Скопировать в буффер обмена');
 
 //user_name.tpl
 define(SM_ENTER_YOUR_NAME,'Введите ваше имя:');
 
 //transactions
 define(SM_DATE,'Дата');
 define(SM_OPERATION,'Операция');
 define(SM_FROM,'От кого');
 define(SM_TO,'Кому');
 define(SM_SUM,'Сумма');
 define(SM_COMMENT,'Комментарий');
 define(SM_CONF,'Подтверждения');
 define(SM_TRANS,'Транзакция');
 define(SM_INTERNAL_MOVE,'Внутренний перевод');
 define(SM_INTERNAL_REFILL,'Внешнее пополнение');
 
 //accounts.tpl
 define(SM_ALL_BTC_BALANCE,'Остатки по всем BTC аккаунтам:');
 define(SM_ACCOUNT,'Аккаунт');
 define(SM_BALANCE_BTC,'Остаток BTC');
 define(SM_BALANCE_USD,'Остаток USD');
 define(SM_CONFIRMATIONS,'Подтверждения');
 define(SM_TOTAL_COINS,'оборотных монет в кошельке');
 define(SM_INFORMATION,'Информация');
 define(SM_BLOCK_COUNT,'Количество блоков');
 define(SM_CURRENT_DIFFICULTY,'Текущая сложность');
 define(SM_CONNECTIONS,'Соединений');
 define(SM_BITCOIND_VERSION,'Версия bitcoind сервера');
 
 //About.tpl
 define(SM_DESCR_AVAIL_HERE,'Описание пока доступно');
 define(SM_HERE,'тут');
 
 //bar
 define(SM_BAR_TITLE,'Пример приема BTC платежей');
 define(SM_BAR_HOME,'Главная');
 define(SM_BAR_ACCOUNT_LIST,'Все аккаунты');
 define(SM_BAR_ABOUT,'Описание');
 define(SM_BAR_CONTACT,'Контакты');
 
 
 define(SM_THIS_IS_SAMPLE,'* Данный сайт bitpay.tk <b>не является рабочим сервисом</b>! Он создан  <b>для демонстрации </b> организации  <b>приема платежей используя Bitcoin </b>. Все исходники можно скачать <a href="https://github.com/Lexiks/Bitpay" target="_blank">тут</a> и совершенно свободно использовать их на своем сайте.<br>Однако весь  <b>функционал является полностью рабочим </b> и вы можете тут  <b>испытать работоспособность </b> скриптов (создавать новые аккаунты или входить в имеющиеся, зачислять на них BTC виртуальным тестовым или реальным переводом, производить зачисление BTC->USD. Приятного тестирования!');
 define(SM_THX_DONATE,'Спасибо за ваше пожертвование!');
 define(SM_THIS_IS_DEMO,'Это демонстрация!');
 
 


?>