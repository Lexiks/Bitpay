<div class="topbar">
      <div class="fill">
        <div class="container">
          <img src = "http://img195.imageshack.us/img195/5449/bitcoinlogo.png" height="20px" class="brand" style="padding-right:5px;padding-top:8px;" />
          <a class="brand" href="#"><span style="font-size:90%">{$smarty.const.SM_BAR_TITLE}</span></a>
          {if $page_name !== ''}
          <ul class="nav">
            <li {if $page_name === "main"}class="active"{/if}><a href="index.php">{$smarty.const.SM_BAR_HOME}</a></li>
            <li {if $page_name === "get_accounts"}class="active"{/if}><a href="index.php?action=get_accounts">{$smarty.const.SM_BAR_ACCOUNT_LIST}</a></li>
            <li {if $page_name === "about"}class="active"{/if}><a href="index.php?action=about">{$smarty.const.SM_BAR_ABOUT}</a></li>            
            <li {if $page_name === "contact"}class="active"{/if}><a href="index.php?action=contact">{$smarty.const.SM_BAR_CONTACT}</a></li>
          </ul>
          {/if}
          {if $user_name !== null}
          <form action="" class="pull-right">
            <span style="color:#DDD;">{$smarty.const.SM_YOUR_ACCOUNT}  : <b style="color:white;margin-right:10px;">{$user_name}</b></span>  
            <a class="btn" href="index.php?user_name=" ><span style="color:#333;">{$smarty.const.SM_CHANGE_NAME}</span></a>
          </form>
          {/if}
          
        </div>
        <div style="float:right;color:red;font-size:13px;">
             {$smarty.const.SM_THIS_IS_DEMO}
          </div>
      </div>
    </div>