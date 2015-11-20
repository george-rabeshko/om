<?php
  /**
   * Контроллер головнії сторінки
   */
  class Home extends Base
  {
    protected $articles;

    // Конструктор
    function __construct()
    {
      parent::__construct();

      // Закриваємо неавторизований доступ до сторінки
    	#$this->need_login = true;
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      parent::onInput();

      // Менеджери
      #$users = Users::instance();
      #$db = Database::instance();

      $a = Articles::instance();
      $this->title = 'Наше життя - любомльська районна газета';
      $this->articles = $a->getAllArticles();
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      $data = array('articles' => $this->articles);
      $this->content = $this->setTemplate('application/views/CategoryView.php', $data);
      parent::onOutput();
    }
  }
