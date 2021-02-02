<?php
class School extends AppModel{
    public $primaryKey = "id";

    public $validate=array(
        "school"=>[
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