<?php
class UserDepartmentSelection extends AppModel{//table department_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'NowDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'now_department_id'
        ),
        'NextDepartment' => array (
            'className' => 'Department',
            'foreignKey' => 'next_department_id'
        ),
        'User' => array (
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
}