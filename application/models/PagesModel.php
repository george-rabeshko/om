<?php
  /**
   * Загальна модель для всіх записів
   */
  class Pages extends Model
  {
    private static $instance;
  	private $dbh;
    private $users;

  	// Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Pages;

  		return self::$instance;
  	}

  	// Конструктор
  	public function __construct()
  	{
  		$this->dbh = Database::instance();
      $this->users = Users::instance();
  	}

    // Видобування сторінки з бази данних
    public function getPage($id)
    {
      $sql = 'SELECT * FROM pages WHERE id = ' . $id;
      return $this->dbh->select($sql);
    }
  }
