# What is this?
- Website using Docker, MYSQL, Apache, PHP, (cakePHP) 
- waseda course survey and free board chatting
- [Details Here](./html/waseda/MVC.md)

# my device
- macOS Catalina

# how to run
- <code>git clone {this repository}</code>
- <code>cp sample.env .env</code>
- write your own .env
- (if you want to add another file published, put the file under /html folder )

# how to run html/waseda/ application(using cakephp v2.10)
- delete the last ".default" of html/waseda/app/Config/database.php.default. Set  host as {MYSQL_CONTAINER_NAME}, login as {MYSQL_USER}, password as {MYSQL_PASSWORD}, database as {MYSQL_DATABASE}, port as {MYSQL_PORT} in html/waseda/app/Config/database.php. {name} is reffering to {name} variable in .env file.
- run docker. access to http://localhost:{SERVER_PORT}/waseda/ and confirm it works well.
- Sorry... Database migration is not available now, so you can't test this application until you create mysql tables by your own. SQL to create my test tables is [here](./TestMysqlTable/test.sql)

# Thanks
- I'm very beginner and wellcome your all help.
- I appreciate it if you improve this,

# contact
- Wellcome your contact to me.
    - github
    - [twitter](https://twitter.com/snakesneaks)