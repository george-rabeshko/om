<?php
  /**
   * Контроллер головнії сторінки
   */
  class Admin extends Base
  {
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

      // Підключаємо необхідні компоненти
      $a = Articles::instance();

      $this->title = 'Наше життя - любомльська районна газета';
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      $data = array('' => '');
      $this->content = $this->setTemplate('application/views/ArticlesView.php', $data);

      parent::onOutput();
    }
  }
