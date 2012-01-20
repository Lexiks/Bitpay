<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="css/main.css" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
{include file='topbar.tpl' page_name='' }
<div class="container">
   <div class="content" style="margin:30 0 5;">
        <div class="page-header" style="height:22px;!important">
          <h3>{$smarty.const.SM_ENTER_YOUR_NAME}</h3>
        </div>
          
          <form method="get" action="index.php">
            <input  name="user_name" size="40" value="tester" class="input-small" type="text" placeholder="{$smarty.const.SM_ACCOUNT}" >
            <button type="submit" class="btn success">Enter</button>
          </form>

      </div>
{include file='footer.tpl'}   
    </div>

</body>
</html>
