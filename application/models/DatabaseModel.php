<?php
  /**
   * Модель бази даних
   */
  class Database
  {
    private static $instance;
    private $dbh;

    // Конструктор
    function __construct()
    {
      try {
        $this->dbh = new PDO(DBCP, USER, PASSWORD);
        $this->dbh->exec('SET NAMES utf8 COLLATE utf8_unicode_ci');
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
        exit($e->getMessage());
      }
    }

  	// Отримання єдиного екземпляру класу (singleton)
  	public static function instance()
  	{
  		if (self::$instance == null)
  			self::$instance = new Database;

  		return self::$instance;
  	}

    /**
     * Отримання даних
     * $query     - SQL запит
     * $params    - асоціативний масив з парами виду "мітка запиту - знаяення"
     * результат  - двомірний масив
     */
  	public function select($query, $params = array())
  	{
      try {
        $s = $this->dbh->prepare($query);

        if (!empty($params))
          foreach ($params as $key => $value)
            $s->bindValue($key, $value);

        $s->execute();
      } catch (PDOException $e) {
        exit($e->getMessage());
      }

      while ($row = $s->fetch(PDO::FETCH_ASSOC)) $data[] = $row;

      return (isset($data)) ? $data : false;
  	}

    /**
     * Додавання даних
     * $table     - назва таблиці
     * $object    - асоціативний масив з парами виду "назва стовпця - знаяення"
     * результат  - ідентифікатор нового рядка
     */
  	public function insert($table, $object)
  	{
  		$columns = array();
  		$values = array();

  		foreach ($object as $key => $value) {
  			$key .= '';
  			$columns[] = $key;

  			if ($value === null) {
  				$values[] = 'NULL';
  			} else {
  				$value .= '';
  				$values[] = "'$value'";
  			}
  		}

  		$columns_s = implode(',', $columns);
  		$values_s = implode(',', $values);

  		try {
        $query = "INSERT INTO $table ($columns_s) VALUES ($values_s)";
        $s = $this->dbh->prepare($query);
        $s->execute();
  		} catch (PDOException $e) {
  		  exit($e->getMessage());
  		}

  		return $this->dbh->lastInsertId();
  	}

    /**
     * Редагування даних
     * $table     - назва таблиці
     * $object    - асоціативний масив з парами виду "назва стовпця - знаяення"
     * $where     - умова (частина SQK запиту)
     * результат  - чмисло змінених рядків
     */
  	public function update($table, $object, $where)
  	{
  		$sets = array();

  		foreach ($object as $key => $value) {
  			$key .= '';

  			if ($value === null) {
  				$sets[] = "$key=NULL";
  			} else {
  				$value .= '';
  				$sets[] = "$key='$value'";
  			}
  		}

  		$sets_s = implode(',', $sets);

      try {
        $query = "UPDATE $table SET $sets_s WHERE $where";
        $s = $this->dbh->prepare($query);
        $s->execute();
      } catch (PDOException $e) {
        exit($e->getMessage());
      }

  		return $s->rowCount();
  	}

    /**
     * Видалення даних
     * $table     - назва таблиці
     * $where     - умова (частина SQK запиту)
     * результат  - чмисло видалених рядків
     */
  	public function delete($table, $where)
  	{
      try {
        $query = "DELETE FROM $table WHERE $where";
        $s = $this->dbh->prepare($query);
        $s->execute();
      } catch (PDOException $e) {
        exit($e->getMessage());
      }

  		return $s->rowCount();
  	}
  }
