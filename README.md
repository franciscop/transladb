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

- It only works with PHP 5.3. Since this version is from 2009, I think it's proper to drop support to older versions.

- So far, you need other tool to complete other languages (like phpMyAdmin).

Requisites:

- PHP 5.3+

- MySQL

- A database with a table named "translations" containing, at least, these columns: id, keyword, page, last, en.

Install:

[In the future: run install.php]

- Copy the file somewhere in your filesystem.

- Include it at the beginning of your code in every page. This might be useful: [link will go here]

- Use it. While writing code, just write this where you'd normally write some text: $_("This_is_a_test_string");

- Check it out. It should print "This is a test string" in your browser, add a new row in your table with the keyword "This_is_a_test_string" and the text "This is a test string" and a bunch of other features. NOTE: The keyword (therefore, also the default text inserted) must be in English.

Warning: The file automatically creates the object. Make sure there's no other object with the same name or change it.
Warning 2: If you are trying to use it directly inside a function, your function design might be wrong. Else, remember to pass the object.