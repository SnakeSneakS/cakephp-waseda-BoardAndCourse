<?php

class RankingsController extends AppController{
    //public $scaffold;//localhost/blog/postsでもう管理画面みたいなのが既にできてる。でもこれだとカスタマイズはできないよね〜〜
    public $helpers = array('Html','Form');//htmlと入力formをこれから扱うZE

    public function index(){
        $params = array(
            'order' => 'modified desc',//ORDER BY 'modified' DESC
            'limit' => 2 //何件検索するか
            //他にもいろいろなパラメータあり https://api.cakephp.org/2.10/class-Model.html#_find
        );
        $this->set('posts',$this->Post->find('all'/*,$params*/));//このコントローラで使っているPostモデルに対しデータを全て取得. htmlファイルでの変数postsに配列でデータをいれる
        //$this->set('title_forlayout','記事一覧');//headerを指定して表示
    }

}

?>