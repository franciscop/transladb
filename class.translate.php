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
  
  /* Pass the right parameters or you will burn in hell until the end of time.
  *  Reson for passing $DB instead of extending here: http://stackoverflow.com/q/7827713/938236
  */
  public function __construct ($DB, $Lang)
    {
    $this->DB = $DB;
    $this->Lang = $Lang;
    }

  /* Requires PHP 5.3+. Simplifies the method calling to $_("keyword"); */
  public function __invoke( $keyword)
    {
    return $this->text( $keyword );
    }
  
  /* If the string doesn't exist it creates it. Useful not to break the flow. */
  private function add ( $Id, $Text )
    {
    $STH = $this->DB->prepare("INSERT INTO translations (keyword, en, page, last) VALUES (?, ?, now())");
    $STH->execute(array($Id,$Text));
    }
  
  /* It returns the right cell, however it might be empty. No default language option. */
  private function retrieve ( $Id )
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
    $row = $STH->fetch();
    return $row[$this->Lang];
    }
  
  public function text($Id, $Arg = null)
    {
    $Text = $this->retrieve($Id);
    if (empty($Text))
      {
      $Text = str_replace("_", " ", $Id);  /* If not found, replace all "_" with " " from the input string. */
      $this->add($Id, $Text);              /* Adds the new strings dynamically so it doesn't break the flow. */
      }
    return str_replace("%s", $Arg, $Text);    // Not likely to have more than 2 variables into a single string.
    }
  }
?>
