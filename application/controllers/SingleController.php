<?php
  /**
   * Контролер однієї статті
   */
  class Single extends Base
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
      $this->title = 'Одна стаття';
    }
  }
