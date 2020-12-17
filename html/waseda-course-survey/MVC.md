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

# Model

Model(Model/Course.php)
- mysql table User

| name | type   | options |
---|---|---
| id | int32   | primary, auto increment|
| name      | string  |            |
| password  | string  |            |
| GPA       | float   | null       |
| comment   | string  | null       |
| department| int     | null       |
| created   | time    | now()      |
| modified  | time    | now()      |
| (image)   | string  |            |

- mysql table Department (of Fundamental science and engineering)

| name | type | options |
--|--|--
|   学系1    | int32   | primary, auto increment|

| name      | string  |            |
| password  | string  |            |
| GPA       | float   | null       |
| comment   | string  | null       |
| department| id      | null       |
| created   | time    | now()      |
| modified  | time    | now()      |
| (image)   | string  |            |


# Controller
~~~~
Controller(Controller/UsersController.php)
- index - blog/posts/    //橋渡し, this is 一覧を表示する
- view
- add
- edit
- delete
~~~~

# View
~~~~
View(View/Posts/)
- index.ctp --blog/View/Posts/index.ctp   //localhost/blog/posts/indexがurl //html, this is 一覧を表示する 
- view.ctp
- add.ctp
- edit.ctp
- delete.ctpはいらない
~~~~