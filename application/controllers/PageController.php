<?php
  /**
   * Контроллер сторінок
   */
  class Page extends Base
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
      $this->title = 'Деяка сторінка';
    }
  }
