<?php
  // Відображення помилок / Режим розробника
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // Файл завантаження програми
  include 'application/bootstrap.php';

  // Перенаправляємо користувача на певний контролер
  if (isset($_GET['c'])) {
    // Розбиття URL адреси на частини
    $i = explode('/', $_GET['c']);

    foreach ($i as $value)
    	if ($value != '') $info[] = $value;

    $c = ucwords($info[0]);
    $id = isset($info[1]);

    // Створення об’єкта класу
    if (empty($c) or !file_exists("application/controllers/{$c}Controller.php"))
      $controller = new Error404;
    else
      $controller = new $c;
  } else {
    $controller = new Home;
  }

  $controller->request();
