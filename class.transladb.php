<?php
/* 
* Transladb
* @Version  0.8
* @Author   Francisco Presencia Fandos
*/
class Translate
  {
  private $Lang;
  private $DB;
  
  /* 
  *  Pass the right parameters. Reason for passing $DB instead of extending the $DB class here: http://stackoverflow.com/q/7827713/938236
  */
  public function __construct ($DB, $Lang)
    {
    $this->DB = $DB;
    $this->Lang = $Lang;
    }

  /*
  *  Simplifies the calling method to $_("keyword");
  *  How it works: http://stackoverflow.com/q/13221863/938236
  */
  public function __invoke( $keyword, $Arg = null )
    {
    $Text = $this->retrieve( $keyword );
    if (empty($Text))
      {
      $Text = str_replace("_", " ", $keyword);  /* If not found, replace all "_" with " " from the input string. */
      $this->add($keyword, $Text);              /* Adds the new strings dynamically so it doesn't break the flow. */
      }
    return str_replace("%s", $Arg, $Text);      /* Not likely to have 2 or more variables into a single string. */
    }
  
  /* It returns the right cell, however it might be empty. No default language option on purpose. */
  private function retrieve ( $Id )
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
    $row = $STH->fetch();
    return $row[$this->Lang];
    }
  
  /* If the string doesn't exist it creates it. Useful not to break the coding flow. */
  private function add ( $Id, $Text )
    {
    $STH = $this->DB->prepare("INSERT INTO translations (keyword, en, last) VALUES (?, ?, now())");
    $STH->execute(array($Id,$Text));
    }
  }

/* Create the object. You might want to change this line somewhere else. */
$_ = new Translate;
?>