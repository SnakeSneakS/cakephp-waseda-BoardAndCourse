<?php
class SchoolDepartment extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        )
    );
}