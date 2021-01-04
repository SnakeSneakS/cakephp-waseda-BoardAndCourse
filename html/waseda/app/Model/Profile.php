<?php
class Profile extends AppModel{
    public $primaryKey = "user_id"; //これ必要。error: saveAssociated Integrity constraint violation: 1062 Duplicate entry '2' for key 'PRIMARY'
    public $belongsTo = array( 
        'Faculty' => array (
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id'
        ),
        'School' => array (
            'className' => 'School',
            'foreignKey' => 'school_id'
        ),
        'Department' => array(
            'className' => 'Department',
            'foreignKey' => 'department_id'
        ),
        
    );

    public $validate=array(//error check 

    );
}