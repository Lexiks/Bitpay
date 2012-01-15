Список транзакций:

<table cellpadding="0" cellspacing="0" border="1"  id="transactions_table">
   <tr>
     <th>Дата</th>
     <th>Операция</th>
     <th>Аккаунт</th>
     <th>Получатель</th>
     <th>Сумма</th>
     <th>Комментарий</th>
     </tr>

{foreach from=$transactions key=k item=v}
   <tr>
     <td>{$v.time|date_format:"%d.%m.%Y %T"}</td>
     <td>{if $v.category === receive}Внешнее пополнение{elseif $v.category === move}Вывод баланса{else}{$v.category}{/if}</td>
     <td>{$v.account}</td>
     <td>{$v.otheraccount}</td>
     <td class="sum_col">
     <div {if $v.amount < 0}class="minus_sum"{/if}>
      {$v.amount}
     </div> 
      </td>
     <td>{$v.comment}</td>
     </tr>
{/foreach}
</table>