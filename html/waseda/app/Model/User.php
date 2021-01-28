<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel{
    public $primaryKey = "id";

    public $hasOne = array(
        "Profile" => array(
            "className" => "Profile",
            'foreignKey' => 'user_id',
            'dependent' => true
        ),
    );

    public $hasMany=[
        'UserDepartmentSelection'=>[
            "Classname"=>'UserDepartmentSelection',
            "foreignKey"=>"user_id"
        ]
    ];


    public $validate = array(
        'username' => array(
            'required' => true,
            'rule' => 'notBlank',
            'message' => 'A name is required'
        ),
        'password' => array(
            'required' => true,
            'rule' => 'notBlank',
            'message' => 'A password is required'
        ),
        'role' => array(
            'create-rule' => [
                'rule'=>[ 'inList', ['author'] ],
                'message' => 'Please enter a valid role',
                'allowEmpty' => true
            ],
            'update-rule' => [
                'rule'=>[ 'inList', ['author'/*,'admin'*/] ],
                'message' => 'Please enter a valid role',
                'allowEmpty' => true
            ],
            
        )
    );

    //crypt password (with salt)
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }

}