<?php
  /**
   * Контроллер сторінок
   */
  class Page extends Base
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

      // Підключаємо необхідні компоненти
      $p = Pages::instance();

      $page_name = $p->getPageName($_GET['id']);
      $this->title = $page_name[0]['title'] . ' - Наше життя';
    }

    // Віртуальний генератор HTML
    protected function onOutput()
    {
      // Підключаємо необхідні компоненти
      $p = Pages::instance();

      $data = array('page' => $p->getPage($_GET['id']));
      $this->content = $this->setTemplate('application/views/PageView.php', $data);

      parent::onOutput();
    }
  }
