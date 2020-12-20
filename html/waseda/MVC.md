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
詳しくはdetailsをみるべし
~~~
Model(Model/User.php) - mysql table users
Model(Model/Department.php) - mysql table departments
Model(Model/Course.php) - mysql table courses
Model(Model/CourseSelection.php) - mysql table courseSelections
~~~

## Controller
- Controller(Controller/MypagesController.php)
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

- Controller(Controller/RankingsController.php)
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
| id | int | primary, auto increment| ユーザID
| name      | varchar(8)  |            | ユーザネーム
| password  | varchar(32) |            | パスワード
| created   | datetime | CURRENT_TIMESTAMP now()      | 作成日時
| modified  | datetime | CURRENT_TIMESTAMP now()      | 更新日時


- Model(Model/Grade.php)
    - mysql table grades

| name | type   | options | description |
---|---|---|--
| user_id | int | primary| ユーザID
| enter_year      | YEAR     | null       | 入学年度
|department_id| int     | null       | 学部ID（e.g. 基幹理工学部)
| course_id  | int     | null       | 学科ID (e.g. 学系○, 〇〇学科)
| gpa       | decimal   | null       | 平均GPA 
| comment   | text | null       | プロフィールコメント(e.g. こんにちは)
| image     | blob    | null       | profile image
| modified  | datetime | CURRENT_TIMESTAMP now()      | 更新日時

- Model(Model/Department.php)
    - mysql table departments

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学部ID
| department| varchar(255)  |            | e.g. 基幹理工学部

- Model(Model/Course.php)
    - mysql table courses

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学科ID
| course    | varchar(255)  |            | e.g. 学系○、　〇〇学科

- Model(Model/CourseSelection.php)
    - mysql table course_selections

| name | type | options | description |
--|--|--|--
| id   | int  | primary, auto increment|
| department_id | int     |            | 学部ID
|now_course_id| int     |            | 学科ID (now)
|next_course_id| int     |            | 学科ID (can select)
| max_num    | int     |            | 人数


