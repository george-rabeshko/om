<?php
  /**
   * Базовий контролер сайту
   */
  class Base extends Controller
  {
    protected $title;
    protected $content;
    protected $need_login;
    protected $user;

    // Конструктор
    function __construct()
    {
      $this->need_login = false;
      $this->user = null;
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      // Підключаємо необхідні компоненти
      $u = Users::instance();

      // Очистка старих сесій та визначення поточного користувача
  		$u->clearSessions();
  		$this->user = $u->get();

      // Перенаправлення на сторінку авторизації, якщо це необхідно
  		if ($this->user == null && $this->need_login)
  		{
  			header("Location: index.php?c=login");
  			die();
  		}

      $this->title = 'Назва сайту (BaseController)';
      $this->content = 'Контент (BaseController)';
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      // Підключаємо необхідні компоненти
      $w = Widgets::instance();

      $data = array(
        'title' => $this->title,
        'menu' => $w->getNavigation('main_menu'),
        'categories' => array_slice($w->getNavigation('categories'), 2),
        'content' => $this->content
      );
      echo $this->setTemplate('application/views/BaseView.php', $data);
    }
  }
