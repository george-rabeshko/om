<?php
  /**
   * Контроллер сторінки помилки 404
   */
  class Error404 extends Base
  {
    // Конструктор
    function __construct()
    {
      # code...
    }

    // Віртуальний обробник запиту. Задає інформацію для шаблона
    protected function onInput()
    {
      parent::onInput();
      $this->title = 'Сторінка не існує';
    }
  }
