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

  /* Requires PHP 5.3+. Simplifies the method calling to $_("keyword"); */
  public function __invoke($Id, $Arg = null)
    {
    $Id = str_replace(" ", "_", $Id);
    if (!($Text = $this->retrieve($Id)))
      {
      /* Adds the string dynamically to database so it doesn't break the flow. */
      $Text = str_replace("_", " ", $Id);
      $this->add($Id, $Text);
      }
    return str_replace("%s", $Arg, $Text);    // Not likely to have more than 2 variables into a single string.
    }
  
  /* If the string doesn't exist it creates it. Useful not to break the flow. */
  public function add ($Id, $Text)
    {
    $q = $this->DB->query("DESCRIBE translations");
    if (in_array ($this->Language, $q->fetchAll(PDO::FETCH_COLUMN)));
      {
      $STH = $this->DB->prepare("INSERT INTO translations (keyword, ".$this->Language.", last) VALUES (?, ?, now())
                                  ON DUPLICATE KEY UPDATE ".$this->Language." = ?");
      return $STH->execute(array($Id, $Text, $Text));
      }
    }
  
  /* It returns the right cell, however it might be empty. No default language option. */
  private function retrieve ($Id)
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
      
    /* If you have PHP 5.4+, you could do: "return $STH->fetch()[$this->Lang];" instead of next lines. Less memory and work involved. */
    $row = $STH->fetch();
    return $row[$this->Language];
    }
  }
