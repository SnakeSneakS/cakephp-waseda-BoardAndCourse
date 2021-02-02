<?php
class Faculty extends AppModel{
    public $primaryKey = "id";

    public $validate=array(
        "faculty"=>[
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