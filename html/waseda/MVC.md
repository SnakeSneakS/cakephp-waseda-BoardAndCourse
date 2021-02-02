# Memo
- Github (oss)
- Docker container

# Attention Please
- This is just a **MOCK** of this system. Details might be defferent.

# Service
## DONE

- service 

|survice| detail1| detail2 |
-|-|-|-
| Course Survey | which department | hierarchy graph | 
|               | gpa              | hierarchy graph | 
|    Boards     | news from admin  |  watch only     | 
|               |free chat by users|  free chat- write and view | 
|               |incremental search|  ajax | 
|               |  paginating      |  Paginator | 

- what is done (maybe related to survice)

|  survice      |detail1           | detail2         |
-|-|-|-
| User Account  | password         | crypt: blowfish | 
|               | auth login       | by Form(username&password)| 
|               | profile image    |  compress (the size of image) | 
|               |free chat by users|                 | 
|               |realtime department data|  ajax    | 
| Total(for develop)|  use docker container  | use env, etc  |
|                   |  sanitize all htmlcharacters |  in AppController file  |
|                   |  validation and authentication |  in controller & model  |

- please see exsisting files to know another "what is done"

## yet DONE
- optimize model ([faculty,school,department] may be better associated as "OneToMany" than as "ManyToMany )
- Board: notify (might be as email for "admin" user, notify icon for "author" user)
- google Oauth: is is possible to identify Waseda student?
- database migration
- board control for "admin" user
- better output for "course survey result"
- tls/ssl 
- deploy 
- privacy policy
- upgrade design and style of this page (including responsive, animation, etc.)
- (reactJS)
- review and fix bugs if any



# Stunctures
- [Model](##Model)
- [Controller](##Controller)
- [View](##View)

## Model
### AssociatedModels
- Model/User.php ~(recursive=2)~

| model name | association type | options | description |
---|---|---|--
| User | - | PrimaryKey=>id | base user info
| Profile | hasOne  | ForeignKey=>user_id | additional user info
| UserDepartmentSelection | hasMany | ForeignKey=>user_id | course survey



- Model/Profile.php

| model name | association type| options | description |
---|---|---|--
| Profile | - | PrimaryKey=>id | additional user info
| Faculty | belongsTo | ForeignKey=>id | 学術院
| School | belongsTo | ForeignKey=>id | 学部
| Department  | belongsTo | ForeignKey=>id | 学科

- Model/AvailableDepartmentSelection.php

| model name | association type| options | description |
---|---|---|--
| AvailableDepartmentSelection | - | PrimaryKey=>id | 画像学部学科gpaなど
| NowDepartment | belongsTo | ForeignKey=>now_department_id | 元の学科
| NextDepartment | belongsTo | ForeignKey=>next_department_id | 次の学科

- Model/UserDepartmentSelection.php

| model name | association type| options | description |
---|---|---|--
| UserDepartmentSelection | - | PrimaryKey=>id | user's course survey
| NowDepartment | belongsTo | ForeignKey=>now_department_id | 元の学科
| NextDepartment | belongsTo | ForeignKey=>next_department_id | 次の学科
| User | belongsTo | ForeignKey=>user_id | basic user info
| gpa | belongsTo | ForeignKey=>user_id | gpa

- Model/Board.php

| model name | association type| options | description |
---|---|---|--
| Board | - | PrimaryKey=>id | 掲示板
| ToBoard | belongsTo | ForeignKey=>to_board_id | which board this board is linked to
| User | belongsTo | ForeignKey=>user_id | who created this board

- Model/BoardUser.php

| model name | association type| options | description |
---|---|---|--
| BoardUser | - | PrimaryKey=>id | 掲示板のwatchなど
| Board | belongsTo | ForeignKey=>board_id | which board?
| User | belongsTo | ForeignKey=>user_id | who is?

- Model/Comment.php

| model name | association type| options | description |
---|---|---|--
| Comment | - | PrimaryKey=>id | 掲示板でのコメント
| User | belongsTo | ForeignKey=>board_id | who?




### Base Models
- table:names => model:Name

### Tables
- Table users

| name | type   | options | description |
---|---|---|--
| id | int | primary, auto increment| user id
| role      | varchar(20)  | default("author")   | user role: [admin or author]
| username      | varchar(32)  | utf8mb4_unicode_ci   | user name
| password  | varchar(255) |    | password
| created   | datetime | CURRENT_TIMESTAMP now()      | created datestamp
| modified  | datetime | CURRENT_TIMESTAMP now()      | modified datestamp

- Table profiles

| name | type   | options | description |
---|---|---|--
| user_id | int | primary| ユーザID
| enter_year      | YEAR(4)     | null       | enter year
|faculty_id| int | null | faculty (e.g. 理工学術院)
|school_id| int     | null       | school (e.g. 基幹理工学部)
|department_id| int     | null       | department (e.g. 学系○, 〇〇学科)
| comment   | text | null       | profile comment (e.g. hello, )
| image     | blob    | null       | profile image 
| modified  | datetime | CURRENT_TIMESTAMP now()      | modified time

- Table gpas

| name | type   | options | description |
---|---|---|--
| id | int | primary| user id
| gpa | decimal(4,3) | | gpa(0~4.000)
| modified | datetime | CURRENT_TIMESTAMP now() | modified time

- Table user_deparment_selections

| name | type   | options | description |
---|---|---|--
|id    | int | primary | id |
| user_id | int | unique1, unique2 | user id |
| rank | int(4)     | unique1 | 志望順位
|now_department_id| int     | null , unique2      | 現在学科id
|next_department_id| int     | null  , unique2     | 志望学科id
|modified | datetime | CURRENT_TIMESTAMP now() | modified time

- Table faculties

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学術院id
| faculty| varchar(255)  | utf8mb4_unicode_ci | e.g. 理工学術院


- Table schools

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学部ID
| school| varchar(255) | utf8mb4_unicode_ci | e.g. 基幹理工学部


- Table departments

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| 学科ID
| department    | varchar(255)  | utf8mb4_unicode_ci | e.g. 学系○, 〇〇学科, 数学科

- Table available_department_selections

| name | type | options | description |
--|--|--|--
| id   | int  | primary, auto increment|
|now_department_id| int     |    unique1        | 学科ID (now)
|next_department_id| int     |    unique1        | 学科ID (can select)
| max_num    | int     |            | 人数

- Table faculty_schools

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| ID
| faculty_id    | int  | unique1 | 学術院id
| school_id    | int  | unique1 | 学部id


- Table school_departments

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| ID
| school_id    | int  | unique1 | 学部id
| department_id    | int  | unique1 | 学科id


- Table boards

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| ID
| user_id    | int  |  | who create this board
| to_board_id    | int  |  | to which this board is linked to
| title    | varchar(32)  | utf8mb4_general_ci | title
| description    | text  |  | description of this board,
| allow_comment_to    | tinyint(1)  | default(1) |if allow users(role:"author") to comment. (only "admin" role can change this)
| allow_board_to    | tinyint(1)  | default(0) | if allow users(role:"author") to link board to this board (only "admin" role can change this)
| created | datetime | CURRENT_TIMESTAMP now() | when created
| modified | datetime | CURRENT_TIMESTAMP now() | when modified

- Table board_users

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| id
| user_id    | int  | unique1 | user id
| board_id    | int  | unique1 | board id
| type    | varchar(16)  | unique1 | (e.g. watch)


- Table comments

 name | type | options | description |
--|--|--|--
| id | int   | primary, auto increment| id
| user_id    | int  |  | user id
| to_board_id    | int  |  | where to comment on
| to_comment_id    | int  | null | where to comment on (reply) **yet developed this system**
| text | text | utf8mb4_general_ci | content of comment
|created | datetime | | CURRENT_TIMESTAMP now() | when created


## Controller
- Controller(Controller/AdminsController.php)
    - for Administrator (管理者用)

| name | available user | description | 説明 |
--|--|--|--
| index | "admin" only  | links | 各リンク
| user | "admin" only  | show all users | ユーザ一覧 |
| userEdit   | "admin" only  | edit users | ユーザ情報編集 |
| department  | "admin" only  | edit department | 学科情報編集 |
| school      | "admin" only  | edit school | 学部情報編集 |
| faculty     | "admin" only  | edit faculty | 学術院情報編集 |
| availableDepartmentSelection  | "admin" only  | from which department to which department  | どの学科からどの学科へ行けるか |
| schoolDeparment | "admin" only  | associate school&department | 学部学科関連付 |
| facultySchool | "admin" only  | associate faculty&school | 学術院学部関連付 |
|userDepartmentselection| "admin" only   | user's course survey | ユーザの学科選択調査|
|LimitedSchools| "admin" only   | show available schools linked to faculty | 学術院に属する学部を返す|
|LimitedDepartments| "admin" only   | show available departments linked to school | 学部に属する学科を返す|



- Controller(Controller/BoardsController.php)
    - Board Survice (掲示板)

| name | available user | description | 説明 |
--|--|--|--
| index | "all"   | redirect to /view/1 | view/1にリダイレクト
| view/$id | "all"   | show boards and comments | 掲示板やコメント表示 |
| search   | "login:ajax" / "login:get"  | incremental search board by title | タイトルで掲示板をインクリメンタル検索 |
| add/$to_board_id  | "login:post" / "login:get/post"  | add board | 掲示板追加 |


- Controller(Controller/BoardUsersController.php)
    - associate board&user [e.g. watch] (掲示板とユーザの関連付 [例: watch機能])
    - "own" in "available user" means it is owned by the user

| name | available user | description | 説明 |
--|--|--|--
| add | "login&own:post"  | add relationship(e.g. watch) | 関係を追加(例：掲示板のwatch)
| board/$id | "login:get"   | show users watching board($id) | $idの掲示板をwatchしているユーザ表示 |
| user/$id | "login&own:get" / "login:get"  | show boards user($id) is watching | user($id)がwatchしている掲示板表示 |
| delete/  | "login&own:post" / "login:get/post"  | delete relationship | 関係削除(例:掲示板のwatch削除) |


- Controller(Controller/CommentsController.php)
    - add Comment to board (掲示板にコメントを追加する)

| name | available user | description | 説明 |
--|--|--|--
| add/$to_board_id  | "login:get&post" | add comment  | 掲示板にコメントを追加する


- Controller(Controller/DepartmentSelectionsController.php)
    - user's course selection (ユーザの進路調査)

| name | available user | description | 説明 |
--|--|--|--
| index | "all" | links | 各リンク
| result | "all" | result of survey  | 進路選択調査結果
| user_add/$id | "login&own:get" | add user's course choice page | ユーザの進路選択を追加するページ
| selection_add/$id | "login&own:post" | add user's course choice | ユーザの進路選択を追加
| selection_delete_all/$id | "login&own:post" | delete user's course choice | ユーザの進路選択を全消去
| edit_gpa/$id | "login&own:post" | edit user's gpa(neccesary for course survey) | ユーザのgpaを入力(学科選択調査に必要) 
| user_view/$id | "login&own:get" | view user's course choice | ユーザの進路選択を表示


- Controller(Controller/MainsController.php)
    - main page shown first (最初に表示されるメインページ)

| name | available user | description | 説明 |
--|--|--|--
| index | "all" | links | 各リンク


- Controller(Controller/UsersController.php)
    - add user, edit profile, etc. (ユーザの登録やプロフィール変更など)

| name | available user | description | 説明 |
--|--|--|--
| index | "all" | links | 各リンク
| login | "all except login" | login  | ログイン
| logout | "all" | logout | ログアウト
| add | "all except login" | add user account | 新規アカウント登録
| view | "all" | view user profile (e.g. username) | ユーザプロフィール確認(例: ユーザネーム)
| edit | "login&own:post" | edit user profile | ユーザプロフィール変更 
|LimitedSchools| "login:ajax" | show available schools linked to faculty | 学術院に属する学部を返す|
|LimitedDepartments| "login:ajax" | show available departments linked to school | 学部に属する学科を返す|








## View
~~~~
View(View/Admins/)
- index.ctp 

- user.ctp
- user_edit.ctp
- user_department_selection.ctp

- faculty.ctp
- school.ctp
- department.ctp
- faculty_school.cto
- school_department.ctp

- available_department_selections.ctp
~~~~

~~~~
View(View/Boards/)
- add.ctp 
- search.ctp
- view.ctp 
~~~~

~~~~
View(View/BoardUsers/)
- board.ctp 
- user.ctp
~~~~

~~~~
View(View/Comments/)
- add.ctp 
~~~~

~~~~
View(View/DepartmentSelections/)
- index.ctp
- result.ctp 
- user_add.ctp
- user_edit.ctp
- user_view.ctp
~~~~

~~~~
View(View/Mains/)
- index.ctp
~~~~

~~~~
View(View/users/)
- index.ctp
- login.ctp
- view.ctp
- add.ctp 
- edit.ctp
~~~~

