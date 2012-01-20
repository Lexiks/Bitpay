<?php
$lang = $_REQUEST['lang'];
  if (isset($_GET['lang'])) $lang = $_GET['lang'];
  if (!preg_match('/^(en|ru)$/', $lang)) $lang = 'ru';
  
  switch ($lang) {
   case 'ru' : include_once ("lang/ru.inc");break;
   case 'en' : include_once ("lang/en.inc");break;
   default : include_once ("lang/ru.inc");break;
}
?>