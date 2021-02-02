<?php
class Department extends AppModel{//table courses
    public $primaryKey = "id";

    public $validate=array(
        "department"=>[
            "length"=>[
                "rule"=>["maxLength",32],
            ],
            "unique"=>[
                "rule"=>"isUnique",
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
            ],
        ]
    );
}