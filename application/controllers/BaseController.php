<?php
  /**
   * Базовий контролер сайту
   */
  class Base extends Controller
  {
    protected $title;
    protected $menu;
    protected $categories;
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
      // Очистка старих сесій та визначення поточного користувача
  		$users = Users::instance();
  		$users->clearSessions();
  		$this->user = $users->get();

      // Перенаправлення на сторінку авторизації, якщо це необхідно
  		if ($this->user == null && $this->need_login)
  		{
  			header("Location: index.php?c=login");
  			die();
  		}

      parent::onInput();
      $this->title = 'Назва сайту';
      $this->content = 'Контент';

      // Підключення модулів (віджетів)
      $w = Widgets::instance();

      $this->menu = array(
        array('name' => 'Головна',            'uri' => '?c=home'),
        array('name' => 'Новини',             'uri' => '?c=category&n=news'),
        array('name' => 'Відеогалерея',       'uri' => '?c=page&id=1'),
        array('name' => 'Світлини',           'uri' => '?c=page&id=2'),
        array('name' => 'Історія газети',     'uri' => '?c=page&id=3'),
        array('name' => 'Передплата та ціни', 'uri' => '?c=page&id=4'),
        array('name' => 'Контакти',           'uri' => '?c=page&id=5')
      );

      $categories = $w->getCategories();
      $this->categories = array_splice($categories, 2);
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      $data = array(
        'title' => $this->title,
        'menu' => $this->menu,
        'categories' => $this->categories,
        'content' => $this->content
      );
      echo $this->setTemplate('/application/views/BaseView.php', $data);
    }
  }
