<?php
class SchoolDepartment extends AppModel{//table course_selections
    public $primaryKey = "id";
    var $belongsTo = array( 
        'Faculty' => array(
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id'
        ),
        'School' => array(
            'className' => 'School',
            'foreignKey' => 'school_id'
        )
    );
}