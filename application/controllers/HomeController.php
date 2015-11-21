<?php
  /**
   * Контроллер головнії сторінки
   */
  class Home extends Base
  {
    // Конструктор
    function __construct()
    {
      parent::__construct();

      // Закриваємо неавторизований доступ до сторінки
    	# $this->need_login = true;
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      parent::onInput();

      $this->title = 'Наше життя - любомльська районна газета';
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      // Підключаємо необхідні компоненти
      $a = Articles::instance();

      $current_page = (isset($_GET['p'])) ? $_GET['p'] : 1;
      $data = array(
        'articles' => $a->getAllArticles($current_page),
        'total' => $a->total
      );
      $this->content = $this->setTemplate('application/views/ArticlesView.php', $data);

      parent::onOutput();
    }
  }
