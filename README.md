Transladb
=========

PHP translation class database-driven. It works in a similar fashion to gettext, but with a database storage and few slick features.

Main features:

- Secure. It is based on PDO, so you don't need to worry about injections or other nasty things.

- Doesn't break the workflow. Just code without worries, the sentences will be automatically generated.

- DRY (Don't repeat yourself). This is a biggie in the design. You have to type something only ONCE, no matter what.

- Lightweight. This project -so far- is 1.6 KB. Last time I checked, gettext was 14.4 MB.

- Easy to install and use.


Drawbacks:

- It works better with PHP 5.3.

- So far, you need other tool to complete other languages (like phpMyAdmin).

Requisites:

- A database with a table named "translations" containing, at least, these columns: id, keyword, page, last, en.

- PHP 5.3+ for the best performance. Fallback available but not so nice.

- MySQL

Install:

[In the future: run install.php]

- Copy the file somewhere in your filesystem.

- Include it at the beginning of your code in every page. This might be useful: [link will go here]

- Afterwards, create a class.

  PHP 5.3+ : $_ = new Translate;

  Other: $Translate = new Translate;

- Use it. While writing code, just write this where you'd normally write some text:

  PHP 5.3+ : $_("This_is_a_test_string");

  Other: $Translate->text("This_is_a_test_string");

- Check it out. It should print "This is a test string" in your browser, add a new row in your table with the keyword "This_is_a_test_string" and the text "This is a test string" and a bunch of other features.

NOTE: The keyword (therefore, also the default text inserted) must be in English.