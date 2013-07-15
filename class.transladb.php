<?php
/*
* Transladb
* @Version  0.8
* @Author   Francisco Presencia Fandos
*/
class Translate
  {
  // Automatically add the word if it doesn't exist yet. Recommended: deactivate on production.
  private $AutoAdd = 1;
  
  private $Language;
  private $DB;
  
  public function __construct (PDO $DB, $Language)
    {
    $this->DB = $DB;
    $this->Language = $Language;
    }

  // Requires PHP 5.3+. Simplifies the calling method to echo $_('keyword');
  public function __invoke($Key)
    {
    $Id = substr($Key, 0, 64);
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
    $STH->execute(array($Id, $Text, $Text));
    return $Text;
    }
  
  // It returns the right cell, however it might be empty. No default language option.
  private function retrieve ($Id)
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
      
    // If you have PHP 5.4+, you could do: "return $STH->fetch()[$this->Lang];" instead of next lines.
    $row = $STH->fetch();
    return $row[$this->Language];
    }
  }
