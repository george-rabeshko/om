<?php
  // Константи для підключення до бази даних
  define('DBCP', 'mysql: host=localhost; dbname=om;');
  define('USER', 'root');
  define('PASSWORD', '');

  // Префікси до БД та md5 (пароля) користувача
  define('DB_TBL_PREF', 'ins');
  define('PASS_PREF', 'IyrYkWnzfN');

  // Старт сесії
  session_start();

  // Базові контролер, модель та вигляд для сайту
  require_once 'application/core/Controller.php';
  require_once 'application/core/Model.php';
  require_once 'application/core/View.php';

  // Підключення моделей
  require_once 'application/models/DatabaseModel.php';
  require_once 'application/models/WidgetsModel.php';
  require_once 'application/models/UsersModel.php';

  // Автозавантаження файлів
  function autoloader($x)
  {
    $x = ucwords(trim($x));

    $c = "application/controllers/{$x}Controller.php";
    $m = "application/models/{$x}Model.php";

    if (file_exists($c)) require_once $c;
    if (file_exists($m)) require_once $m;

    //if (!class_exists($x, false))
      //exit("Unable to load class: $x");
  }

  spl_autoload_register('autoloader');
