<?php

App::uses('AppController', 'Controller');
App::uses('KakeibosController', 'Controller');

class KakeibosControllerTest extends ControllerTestCase{
    public $fixtures = array('app.Kakeibo');

    public function setUp(){
        parent::setUp();
        $this->KakeibosController = new KakeibosController();
    }

    public function testIndex()
    {
        $result = $this->testAction('/Kakeibos/index');
        debug($result);
    }

}
