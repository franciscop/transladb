<?php
/*
 * Transladb Production version
 * The only difference with the other version is that this class doesn't add a new row if the keyword doesn't exist
 * @Version   0.8
 * @Author    Francisco Presencia Fandos
 * @Requires  PHP 5.3+
 */
class Translate {
  private $DB;        // The PDO object
  private $Language;  // Stores the language of the translations. Format: "en", "es", "fr", etc
  
  public function __construct (PDO $DB, $Language = "en") {
    $this->DB = $DB;
    $this->Language = $Language;
    }

  // Requires PHP 5.3+. Simplifies the calling method to: echo $_('keyword');
  public function __invoke($Key) {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array(substr($Key, 0, 64)));
    $row = $STH->fetch();
    return $row[$this->Language];
    }
  }
