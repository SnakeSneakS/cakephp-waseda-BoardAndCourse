# Memo
- Github (oss)
- Docker

# Service
- GPA Research
    - average GPA
    - your rank
    - total hierarchy (pyramid graph)
   
- Course Research
    - rank
    - total hierarchy in course (pyramid graph)
- 色々語る掲示板
    - important news
        - Add News From Admin User
        - if not have visited here, notify
    - free chat
    - free chat
    - free chat
    - free chat
- profile

- Total
    - delete
    - add
    - edit
    - view

# Stunctures
## Model
~~~
Model(Model/User.php) - mysql table users
Model(Model/Department.php) - mysql table departments
Model(Model/Course.php) - mysql table courses
Model(Model/CourseSelection.php) - mysql table courseSelections
~~~

## Controller
- Controller(Controller/MypageController.php)
    - in waseda/mypage/

| name | parameter | description
--|--|--
| index |  |自分のプロフィール表示
| login |               | ログイン画面
| add   |               | 新規申請
| edit  |               | プロフィール編集
| delete|               | アカウント削除

<!-- 
~~下のようにcakephpの命名規則に従う場合、色々省略できる。今回はcontrollerを機能ごとに区別したいため、またcakephpが裏でどんな風にmvcを繋げているかを学ぶため、命名規則に従わない。~~

- Controller(Controller/UsersController.php)
    - in waseda/users/

| name | parameter | description
--|--|--
| index |  |自分のプロフィール表示
| login |               | ログイン画面
| add   |               | 新規申請
| edit  |               | プロフィール編集
| delete|               | アカウント削除
| ranking/grade/ | user-id (,department) |gpaでのランキングを表示(学科や学部ごとも？)
| ranking/course/ | user-id , now-course-id , new-course-id |学科選択の人数や自分の順位、行けそうかどうかを表示
-->

- Controller(Controller/RankingController.php)
    - in waseda/ranking/

| name | parameter | description
--|--|--
| index |  | 下のどれを使うか選択。パラメータはセッションキーで？
| grade/ | user-id (,department) |gpaでのランキングを表示(学科や学部ごとも？)
| course/ | user-id , now-course-id , new-course-id |学科選択の人数や自分の順位、行けそうかどうか等グラフ等表示


## View
~~~~
View(View/Posts/)
- index.ctp --blog/View/Posts/index.ctp   //localhost/blog/posts/indexがurl //html, this is 一覧を表示する 
- view.ctp
- add.ctp
- edit.ctp
- delete.ctpはいらない
~~~~

# Details
## Model

- Model(Model/User.php)
    - mysql table users

| name | type   | options | description |
---|---|---|--
| id | int32   | primary, auto increment| ユーザID
| username      | string  |            | ユーザネーム
| password  | string  |            | パスワード
| year      | int     |            | 学年 
| department| int     | null       | 学部ID（e.g. 基幹理工学部)
| course    | int     | null       | 学科ID (e.g. 学系○, 〇〇学科)
| GPA       | float   | null       | 平均GPA 
| comment   | string  | null       | プロフィールコメント(e.g. こんにちは)
| image     | blob    | null       | profile image
| created   | time    | now()      | 作成日時
| modified  | time    | now()      | 更新日時


- Model(Model/Department.php)
    - mysql table departments

 name | type | options | description |
--|--|--|--
| id        | int32   | primary, auto increment| 学部ID
| department| string  |            | e.g. 基幹理工学部

- Model(Model/Course.php)
    - mysql table courses

 name | type | options | description |
--|--|--|--
| id        | int32   | primary, auto increment| 学科ID
| course    | string  |            | e.g. 学系○、　〇〇学科

- Model(Model/CourseSelection.php)
    - mysql table courseSelections

| name | type | options | description |
--|--|--|--
| id          | int32   | primary, auto increment|
| department  | int     |            | 学部ID
| now course  | int     |            | 学科ID (now)
| next course | int     | null       | 学科ID (can select)
| num         | int     | null       | 人数


