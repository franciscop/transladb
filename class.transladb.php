<?php
/*
 * Transladb
 * @Version   0.8
 * @Author    Francisco Presencia Fandos
 * @Requires  PHP 5.3+
 */
class Translate
  {
  // The PDO object
  private $DB;
  // This stores the language of the translations. Format: "en", "es", "fr", etc
  private $Language;
  // This will add a new translation if the keyword is not in the database yet.
  private $AutoAdd;
  
  public function __construct (PDO $DB, $Language = "en", $AutoAdd = 1)
    {
    $this->DB = $DB;
    $this->Language = $Language;
    $this->AutoAdd = $AutoAdd;
    }

  // Requires PHP 5.3+. Simplifies the calling method to echo $_('keyword');
  public function __invoke($Key)
    {
    $Id = substr($Key, 0, 200);         // A reasonable limit for the keyword. It'll work even if it's longer..
    
    // If there's no text string yet
    if (!($Text = $this->retrieve($Id)) && $AutoAdd)
      {
      // Add the string dynamically to database so it doesn't break the coding flow.
      $Text = $this->add($Id, $Key);
      }
    return $Text;
    }
  
  // Adds to database a new translation row in English. This method is disabled in production (and can be deleted).
  private function add ($Id, $Text)
    {
    // Ignore not to overwrite the old translations.
    $STH = $this->DB->prepare("INSERT IGNORE INTO translate (keyword, en) VALUES (?, ?)");
    $STH->execute(array($Id, $Text));
    return $Text;
    }
  
  // It returns the right cell, however it might be empty.
  private function retrieve ($Id)
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
      
    // If you have PHP 5.4+, you could do: "return $STH->fetch()[$this->Lang];" instead of next lines.
    $row = $STH->fetch();
    return $row[$this->Language];
    }
  }
