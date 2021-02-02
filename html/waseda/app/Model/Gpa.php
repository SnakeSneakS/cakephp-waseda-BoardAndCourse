<?php
class Gpa extends AppModel{
    public $primaryKey = "id"; 

    

    public $validate=array(//error check 
        "id"=>[
            "rule"=>"notBlank",
        ],
        "gpa"=>[
            "decimal3"=>[
                "rule"=>["decimalPointLength",[0,1,2,3]],
                "message"=>"少数下3桁まで入力してください",
                "last"=>false,
            ], 
            "number"=>[
                "rule"=>["range",-0.001,4.001],
            ],
            "notBlank"=>[
                "rule"=>"notBlank",
            ],
        ],
        "modified"=>[
            "rule"=>"blank",
        ]
    );

    //$checkの小数点以下の桁数がarrayに含まれるかチェック
    function decimalPointLength($check,$array=[0,1,2,3]){
        //debug((string)$check["gpa"]);
        $d=explode(".",(string)$check["gpa"]);
        $r= isset($d[1])?strlen($d[1]):0;
        return in_array($r,$array);
    }
}