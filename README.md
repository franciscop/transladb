# Transladb

PHP translation class database-driven. It works in a similar fashion to gettext, just with a database storage and few slick features.

##Main features:

- **Easy** to use.

- **Just code** without worries, the sentences will be automatically added.

- **Secure**. It is properly based on PDO, so you don't need to worry about injections.

- **Lightweight**. This project (class.translatedb.php) is 1.8 KB so far. Last time I checked, gettext was 14.4 MB.

- **DRY** (Don't repeat yourself). This is a biggie in the design. You have to type something only ONCE, no matter what.

- Has **production** and **development** states, being the first one more optimized for speed and the second one more flexible.

##Drawbacks:

- It's *not completely error-safe*. The proper table and proper fields should already exist (see "Requisites" below).

- So far, you need *other tool to translate* to other languages (like phpMyAdmin).

##Requisites:

- PHP 5.3+

- MySQL

- A database with a table named "translations" containing, at least, these columns: "id" (varchar(200)) and "en" (bigtext).

##Install:

- Copy the file somewhere in your filesystem.

- Include it at the beginning of your code in every page.

- Put your PDO object and the user's language (or your page's one) string in: `$_ = new Translate($DB, $Language);`

- Use it. While writing code, just write this where you'd normally write some text: `echo $_("TranslateDB is working!");`

- Check it out. It should print "TranslateDB is working!" in your browser and add a new row in your table with the same text as keyword and English text.

##Warnings

- This class is not XSS safe (that's not the responsability of it). This should be handled afterwards if needed.

- I assume you are working in English and then translating to other languages. Change the prepare statement in the method "add" if this is not the case.
