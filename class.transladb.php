<?php
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
  
  /* Pass the right parameters or you will burn in hell until the end of time. */
  public function __construct ($DB, $Lang)
    {
    $this->DB = $DB;
    $this->Lang = $Lang;
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
  private function add ($Id, $Text)
    {
    $STH = $this->DB->prepare("INSERT INTO translations (keyword, en, last) VALUES (?, ?, now())");
    $STH->execute(array($Id,$Text));
    }
  
  /* It returns the right cell, however it might be empty. No default language option. */
  private function retrieve ($Id)
    {
    $STH = $this->DB->prepare("SELECT * FROM translations WHERE keyword=? LIMIT 1");
    $STH->execute(array($Id));
      
    $row = $STH->fetch();
    return $row[$this->Lang];
    }
  }

/* Create the object. You might want to change this line somewhere else. */
$_ = new Translate;
echo $_("This is a test to show how %s works", "TranslateDB");
?>
