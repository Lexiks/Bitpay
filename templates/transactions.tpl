<table id="transactions_table"  class="bordered-table">
   <tr>

     <th></th>
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
   <tr {if $v.confirmations == 0 && $v.confirmations !== null}class="unconfirmed"{/if}>
     <td><img src = "img/{if $v.category === move && $v.amount > 0}testcoins.png
                           {elseif $v.category === move && $v.amount < 0}minus.png
                           {elseif $v.category === receive}plus.png
                         {/if}" height="12px" style="padding-top:1px;" /></td>
     <td class="intext">{$v.time|date_format:"%d.%m.%Y %T"}</td>
     <td class="intext">{if $v.category === receive}{$smarty.const.SM_INTERNAL_REFILL}{elseif $v.category === move}{$smarty.const.SM_INTERNAL_MOVE}{else}{$v.category}{/if}</td>
     <td class="intext">{if $v.amount > 0}{$v.otheraccount}{else}{$user_name}{/if}</td>
     <td class="intext">{if $v.amount < 0}{$v.otheraccount}{else}{$user_name}{/if}</td>
     <td class="sum_col">
     <div {if $v.amount < 0}class="minus_sum"{/if}>
      {$v.amount}
     </div> 
      </td>
     <td class="intext">{$v.comment}</td>
     <td align="center" class="intext">{$v.confirmations} 
         {if $v.confirmations > 0}
             (<span class="confirmed">
                <img src = "img/confirmed.png" height="12px" style="padding-top:2px;"/>{$smarty.const.SM_CONFIRMED}
              </span>)
          {elseif $v.confirmations == 0 && $v.confirmations !== null}
             (<span class="unconfirmed">
                <img src = "img/unconfirmed.png" height="12px" style="padding-top:2px;"/>{$smarty.const.SM_UNCONFIRMED}
             
              </span>)
          {/if}</td>
     <td style="font-size:12px"><a href="http://blockexplorer.com/tx/{$v.txid}" target="_blank">{$v.txid|truncate:10:"..."}</a></td>
     
     </tr>
{/foreach}
</table>
