<?php

Class DB
{
  private static $writeDBConnection;
  private static $readDBConnection;

  public static function connectWriteDB()
  {
    if(self::$writeDBConnection === null)
    {
      self::$writeDBConnection = 
        new PDO('mysql:host=db;dbname=member;utf8', 'root','secured.');
      self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return self::$writeDBConnection;
  }

  public static function connectReadDB()
  {
    if(self::$readDBConnection === null)
    {
      self::$readDBConnection = 
        new PDO('mysql:host=db;dbname=member;utf8', 'root','secured.');
      self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return self::$readDBConnection;
  }

}

?>
