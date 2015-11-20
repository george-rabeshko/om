<?php
  /**
   * Базова модель
   */
  class Model
  {
    private static $instance;
  	private $dbh;
    private $users;

    // Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Articles;

  		return self::$instance;
  	}

    // Конструктор
  	public function __construct()
  	{
  		$this->dbh = Database::instance();
      $this->users = Users::instance();
  	}
  }
