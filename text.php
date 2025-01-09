<?php 
    class Care{
        public $prix;
        public $model;

    public function getprix(){
        return $this ->prix;
    }
    public function getmodel(){
        return $this ->model;
    }
    public function setprix($prix){
        $this ->prix =$prix;
    }
    public function setmodil($model){
        $this ->model=$model;
    }
    }


    $resul =new Care();

    $resul ->setprix('12');
    $resul ->setmodil('tayota');

    echo 'prix car : '.$resul->getprix() .'<br>'.'model de care : '.$resul->getmodel();


?>