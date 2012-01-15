<?php
  require('smarty/Smarty.class.php');

  $smarty = new Smarty;
  $smarty->debugging = false;
  //Кэш ненужен
  $smarty->caching = false;
  $smarty->cache_lifetime = 120;

  $smarty->template_dir = 'templates';
  $smarty->compile_dir = 'templates_c';
  $smarty->cache_dir = 'cache';
                                                                  
?>