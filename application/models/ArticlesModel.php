<?php
  /**
   * Загальна модель для всіх записів
   */
  class Articles extends Model
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

    // Отримання списку категорій
    public function getAllArticles()
    {
      $sql = 'SELECT * FROM articles';
      return $this->dbh->select($sql);
    }

    // Отримання списку категорій
    public function getCertainArticles($category_uri)
    {
      $sql = "SELECT id FROM categories WHERE uri = :category_uri";
      $tmp_params = array(':category_uri' => $category_uri);
      $category_id = $this->dbh->select($sql);

      $sql = "SELECT * FROM articles WHERE category = $category_id";
      return $this->dbh->select($sql);
    }
  }
