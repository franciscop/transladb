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

- It's not error-safe. You need to pass the right PDO connection object, the database and table should already exist and the table should contain at least the field of your language and the field "keyword".

- So far, you need other tool to complete other languages (like phpMyAdmin).

Requisites:

- PHP 5.3+

- MySQL

- A database with a table named "translations" containing, at least, these columns: "id" (varchar(200)), "timestamp" (timestamp), "en" (bigtext).

Install:

- Copy the file somewhere in your filesystem.

- Include it at the beginning of your code in every page.

- Put the right name of the PDO object in the "$_ = new Translate($DB, $Language);" statement, it's expecting it, as well as the user's language (or your page one).

- Use it. While writing code, just write this where you'd normally write some text: echo $_("%s is working!", TranslateDB);

- Check it out. It should print "This is a test string" in your browser, add a new row in your table with the keyword "This_is_a_test_string" and the text "This is a test string" and a bunch of other features. NOTE: The keyword (therefore, also the default text inserted) must be in English.

Warning: The file automatically creates the object. Make sure there's no other object with the same name or change it.

Warning 2: If you are trying to use it directly inside a function, remember to pass the object, but also check your code as it's strange.
