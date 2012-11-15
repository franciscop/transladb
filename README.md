Transladb
=========

PHP translation class database-driven. It works in a similar fashion to gettext, but with a database storage and few slick features.

Main features:
- Secure. It is based on PDO, so you don't need to worry about injections or other nasty things.

- Doesn't break the workflow. Just code without worries, the sentences will be automatically generated.

- DRY (Don't repeat yourself). This is a biggie in the design. You have to type something only ONCE, no matter what.

- Easy to install and use.


Drawbacks:
- It works better with PHP 5.3.

- So far, you need other tool to complete other languages (like phpMyAdmin).

Requisites:
- A database.

- For the best performance, PHP 5.3 or above. Fallback available but not so nice.

Install:

[In the future: run install.php]

- Create a table named "translations" with, at least, these columns: id, keyword, page, last, en.

- Copy the file somewhere in your filesystem.

- Include it at the beginning of your code in every page. This might be useful: <link will go here>

- Afterwards, create a class.

  PHP 5.3+ : $_ = new Translate;

  Other: $Translate = new Translate;

- Use it. While writing code, just write this in each text comment:

  PHP 5.3+ : $_("This_is_a_test_string");

  other: $Translate->text("This_is_a_test_string");

- Check it out. It should print "This is a test string" in your browser, add a new row in your table with the keyword "This_is_a_test_string" and the text "This is a test string" and a bunch of other features.
NOTE: If your website main language [and the one passed in the __constructor()] is not in English, make sure your keyword is that same language!
