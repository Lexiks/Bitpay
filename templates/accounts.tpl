<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>
<body>
Остатки по всем BTC аккаунтам:
<table cellpadding="0" cellspacing="0" border="1"  id="accounts_table">
   <tr>
     <th>Аккаунт</th>
     <th>Остаток BTC</th>
     <th>Остаток USD</th>
     </tr>


{foreach from=$accounts key=k item=v}
   <tr>
     <td><a href="index.php?user_name={$k}" target="_blank">{$k}</a></td>
     <td align="right"><b>{$v.BTC_sum}</b></td>
     <td align="right"><b>{$v.USD_sum}</b></td>
     </tr>
{/foreach}
</table>
<br>
Всего оборотных монет в кошельке: <b>{$balance}</b>

</body>
</html>