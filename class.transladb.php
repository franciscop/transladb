<?php
/*
* Transladb
* @Version  0.8
* @Author   Francisco Presencia Fandos
*/
class Translate
  {
  private $Language;
  private $DB;
  
  /* Pass the right parameters or you will burn in hell until the end of time. */
  public function __construct ($DB, $Language)
    {
    $this->DB = $DB;
    $this->Language = $Language;
    }

  /* Requires PHP 5.3+. Simplifies the calling method to echo $_('keyword'); */
  public function __invoke($Key, $Arg = null)
    {
    $Id = substr($Key, 0, 64);
    /* If there's no text string yet */
    if (!($Text = $this->retrieve($Id)))
      {
      /* Add the string dynamically to database so it doesn't break the coding flow. */
      $Text = $this->add($Id, $Key);
      }
    /* Not likely to have 2 or more variables into a single string. */
    return str_replace("%s", $Arg, $Text);
    }
  
  /* Adds to database a new translation row in English. */
  public function add ($Id, $Text)
    {
    $STH = $this->DB->prepare("INSERT INTO translations (keyword, en) VALUES (?, ?)
                                ON DUPLICATE KEY UPDATE en = ?");
    $STH->execute(array($Id, $Text, $Text));
    return $Text;
    }
  
  /* It returns the right cell, however it might be empty. No default language option. */
  private function retrieve ($Id)
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
      
    /* If you have PHP 5.4+, you could do: "return $STH->fetch()[$this->Lang];" instead of next lines. */
    $row = $STH->fetch();
    return $row[$this->Language];
    }
  }
