# Memo
- Github (oss)
- Docker

# Service
- GPA Research
    - average GPA
    - your rank
    - total hierarchy (pyramid graph)
   
- Department Research
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
### AssociatedModels
- Model/User.php ~(recursive=2)~

| model name | association type | options | description |
---|---|---|--
| User | - | PrimaryKey=>id | ユーザ名、パスワードなど最低限
| Profile | hasOne  | ForeignKey=>user_id | 画像学部学科gpaなど
| UserDepartmentSelection | hasMany? | ForeignKey=>user_id |進学希望学科（３つまで）



- Model/Profile.php

| model name | association type| options | description |
---|---|---|--
| Profile | - | PrimaryKey=>id | 画像学部学科gpaなど
| Faculty | belongsTo | ForeignKey=>id | 学術院
| School | belongsTo | ForeignKey=>id | 学部
| Department  | belongsTo | ForeignKey=>id | 学科

- Model/AvailableDepartmentSelection.php

| model name | association type| options | description |
---|---|---|--
| AvailableDepartmentSelection | - | PrimaryKey=>id | 画像学部学科gpaなど
| Faculty | belongsTo | ForeignKey=>id | 学術院
| School | belongsTo | ForeignKey=>id | 学部
| NowDepartment,NextDepartment | belongsTo | ForeignKey=>id | 学科

- Model/UserDepartmentSelection.php

| model name | association type| options | description |
---|---|---|--
| UserDepartmentSelection | - | PrimaryKey=>id | 画像学部学科gpaなど
| Faculty | belongsTo | ForeignKey=>id | 学術院
| School | belongsTo | ForeignKey=>id | 学部
| NowDepartment,NextDepartment | belongsTo | ForeignKey=>id | 学科
| Profile | belongsTo | ForeignKey=>user_id | gpa

### Base Models
- table:names => model:Name

### Tables
- Table users

| name | type   | options | description |
---|---|---|--
| id | int | primary, auto increment| ユーザID
| name      | varchar(8)  | utf8mb4_unicode_ci   | ユーザネーム
| password  | varchar(32) |            | パスワード
| created   | datetime | CURRENT_TIMESTAMP now()      | 作成日時
| modified  | datetime | CURRENT_TIMESTAMP now()      | 更新日時

- Table profiles

| name | type   | options | description |
---|---|---|--
| user_id | int | primary| ユーザID
| enter_year      | YEAR     | null       | 入学年度
|faculty_id| int | null | 学術院ID(e.g. 理工学術院)
|school_id| int     | null       | 学部ID（e.g. 基幹理工学部)
|department_id| int     | null       | 学科ID (e.g. 学系○, 〇〇学科)
| gpa       | decimal   | null       | 平均GPA 
| comment   | text | null       | プロフィールコメント(e.g. こんにちは)
| image     | blob    | null       | profile image
| modified  | datetime | CURRENT_TIMESTAMP now()      | 更新日時

- Table user_deparment_selections

| name | type   | options | description |
---|---|---|--
|id    | int | primary | id |
| user_id | int | unique1 | ユーザID |
| rank | int(2)     | in(1,2,3) unique1 | 志望順位
|now_department_id| int     | null       | 現在学科id
|next_department_id| int     | null       | 志望学科id


- Table schools

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学術院id
| school| varchar(255) | utf8mb4_unicode_ci | e.g. 理工学術院

- Table facultys

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学部ID
| faculty| varchar(255)  | utf8mb4_unicode_ci | e.g. 基幹理工学部

- Table departments

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学科ID
| department    | varchar(255)  | utf8mb4_unicode_ci | e.g. 学系○、　〇〇学科

- Table available_department_selections

| name | type | options | description |
--|--|--|--
| id   | int  | primary, auto increment|
| school_id | int     |            | 学部ID
|now_department_id| int     |            | 学科ID (now)
|next_department_id| int     |            | 学科ID (can select)
| max_num    | int     |            | 人数


## Controller
- Controller(Controller/MypagesController.php)
    - in waseda/mypage/

| name | parameter | description
--|--|--
| index |  |自分のプロフィール表示
| login |               | ログイン画面
| add   |               | 新規申請
| edit  |               | プロフィール編集
|(delete)|               | アカウント削除

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
| new_course/ | user-id , now-course-id , new-course-id |学科選択の人数や自分の順位、行けそうかどうか等グラフ等表示


## View
~~~~
View(View/Posts/)
- index.ctp --blog/View/Posts/index.ctp   //localhost/blog/posts/indexがurl //html, this is 一覧を表示する 
- view.ctp
- add.ctp
- edit.ctp
- delete.ctpはいらない
~~~~




