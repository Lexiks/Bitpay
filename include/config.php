<?php
    
    //��������� ������� � ����
    define('DB_Host','localhost');
    define('DB_Databse','bitpay');
    define('DB_User', 'root');
    define('DB_Password','');
    
    //��������� RPC bitcoind �������
    define('RPC_Host','192.168.0.32');
    define('RPC_Password','xxx');
    define('RCP_User','xxx');
    define('RPC_Port','8332');
    
    //�������� , �����������������, ������� �� ������� ����� ������������ BTC � ���������� ������
    DEFINE(MAIN_ACC,'BaseAcc');
    
    //������� ����
    DEFINE(EX_RATE,7);
    
    //����������� ����� ������ �������������, ����� ������� ����� ����� ������ (0 - �����)
    DEFINE(MIN_BLOCK_COUNT,0);
    
    //����� (���) �� ���������� �������� ��� ������� ������� � RPC ����� ����������� ����� ���������� ����
    DEFINE(ERROR_TIMEOUT,10);
    
?>
