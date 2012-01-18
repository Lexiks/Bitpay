<table cellpadding="0" cellspacing="0" border="1"  id="transactions_table">
   <tr>
     <th>{$smarty.const.SM_DATE}</th>
     <th>{$smarty.const.SM_OPERATION}</th>
     <th>{$smarty.const.SM_FROM}</th>
     <th>{$smarty.const.SM_TO}</th>
     <th>{$smarty.const.SM_SUM}</th>
     <th>{$smarty.const.SM_COMMENT}</th>
     <th>{$smarty.const.SM_CONF}</th>
     <th>{$smarty.const.SM_TRANS}</th>
     </tr>

{foreach from=$transactions key=k item=v}
   <tr>
     <td>{$v.time|date_format:"%d.%m.%Y %T"}</td>
     <td>{if $v.category === receive}{$smarty.const.SM_INTERNAL_REFILL}{elseif $v.category === move}{$smarty.const.SM_INTERNAL_MOVE}{else}{$v.category}{/if}</td>
     <td>{if $v.amount > 0}{$v.otheraccount}{else}{$user_name}{/if}</td>
     <td>{if $v.amount < 0}{$v.otheraccount}{else}{$user_name}{/if}</td>
     <td class="sum_col">
     <div {if $v.amount < 0}class="minus_sum"{/if}>
      {$v.amount}
     </div> 
      </td>
     <td>{$v.comment}</td>
     <td align="center">{$v.confirmations}</td>
     <td style="font-size:12px">{$v.txid}</td>
     
     </tr>
{/foreach}
</table>