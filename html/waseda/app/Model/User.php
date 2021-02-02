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
        "UserDepartmentSelection"=>[
            "Classname"=>"UserDepartmentSelection",
            "foreignKey"=>"user_id"
        ],
        /*
        "BoardUser"=>[
            "Classname"=>"BoardUser",
            "foreignKey"=>"user_id",
        ]
        */
    ];


    public $validate = array(
        "username" => array(
            'rule1' => [
                'rule' => array('lengthBetween', 2, 32),
                'message' => '名前は2文字以上32文字以内で入力してください',
                "required"=>true,
            ],
            "unique"=>[
                "rule"=>"isUnique",
                "message"=>"このユーザネームは既に使われています"
            ]
        ),
        "password" => array(
            "length"=>[
                "rule"=>["lengthBetween", 6, 64],
                'message' => 'パスワードは6文字以上64文字以内で入力してください',
                "required"=>"create",
            ]
        ),
        'role' => array(
            'create-rule' => [
                'rule'=>[ 'inList', ['author'] ],
                'message' => 'Please enter a valid role',
                'allowEmpty' => true,
                "on" => "create"
            ],
            'update-rule' => [
                'rule'=>[ 'inList', ['author','admin'] ],
                'message' => 'Please enter a valid role',
                'allowEmpty' => true,
                "on" => "update"
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