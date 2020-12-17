
# page
- localhost:4000でweb page
- localhost:8000でphpmyadmin

# error: URL rewriting is not properly configured on your server.
- Solution
    - ~~[add rewritebase](https://blue-red.ddo.jp/~ao/wiki/wiki.cgi?page=CakePHP)~~
    - [RUN a2enmod rewrite](https://qiita.com/mochizukikotaro/items/57c429d5fd6ab8725868)

# mysql login
- <code>mysql -u username -p</code>

# connect to mysql
- <del>in php.ini, add <code>extension = php_pdo_mysql.dll </code></del>関係なかった
- dockerではmysqlのコンテナ名でアクセスする？
    - database.phpではhost=${container name}
    - phpmyadminでは環境変数PMA_HOST=${container_name}
- phpmyadminに接続できていれば



# server name resolution
- docker内のCLIでcat /etc/hosts　にある



# 設定
- .env内でパスワードなど
- cakephpのフォルダ/app/Config/database.php でデータベース接続設定
    - host:"mysql". login,password: "test"