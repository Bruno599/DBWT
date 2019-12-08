<?php
namespace Emensa\Controller {

    require_once "vendor/autoload.php";

    require_once "model/zutatenModel.php";

    use eftec\bladeone\BladeOne;

    class ZutatenController
    {
        private $blade;
        public function __construct()
        {
            $views = __DIR__ . '/../views';
            $cache = __DIR__ . '/../cache';
            $this ->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
        }


        public function zutaten()
        {
            $model = new \Emensa\Model\zutatenModel();
            $data = $model->zutaten();
            $count = $model->zutatenanzahl;

            echo $this->blade->run("zutaten",["zutaten"=>$data, "anzahl" => $count]);
        }


    }

}
