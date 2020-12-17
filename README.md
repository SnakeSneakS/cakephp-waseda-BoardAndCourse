[これが全て]](https://yama-itech.net/construct-lamp-with-docker)

# 初めに
- 私は初心者ですので色々分からない場所がたくさんあります
- 改善に協力していただける方いらしたら大変感謝いたします
-  Docker - MYSQL, Apache, PHP を使って早稲田の学科振り分け予想しよう企画です

# 手元で動かす場合
- <code>git clone このレポジトリ</code>
- sample.env の中身を適当に書き換える
- <code>cp sample.env .env</code>
- /htmlのしたに公開ファイルをおく (ルートディレクトリにマウントされる。)

# waseda-course-surveyをいじるのに必要(cakephp v2.10を使用)
- .envの環境変数varの値を${var}で表す
- html/waseda-course-survey/app/Config/database.php.defaultの最後の「.default」を削除した「database.php」の中の、hostを${MYSQL_CONTAINER_NAME}, loginを${MYSQL_USER}, passwordを${MYSQL_PASSWORD}, databaseを${MYSQL_DATABASE},にする。
- dockerを起動して http://localhost:${SERVER_PORT}/waseda-course-survey にアクセスして「DebugKit...」以外が全て緑色か確かめる。他に赤色or黄色があればどこかに設定不十分な場所や設定不具合な場所がある。