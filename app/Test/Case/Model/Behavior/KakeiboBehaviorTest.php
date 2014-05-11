<?php

App::uses('AppModel', 'Model');
App::uses('Kakeibo', 'Model');

class KakeiboBehaviorTest extends CakeTestCase
{
    //-----------
    //prepare
    //-----------

    public $fixtures = array('app.Kakeibo',);

    //-----------
    //setter
    //-----------

    public function setUp(){
        parent::setUp();
        $this->model = new Kakeibo();
        $this->model->useDbConfig = 'test';
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    //-----------
    //test
    //-----------

    //public function testgetCashMeisaiDefault()
    //{
    //    //月を指定しない場合今月の明細を取得する
    //    $options = array(
    //        'conditions' => array('method' => 'cash'),
    //    );
    //    $actual = $this->model->getMeisai_f($options);
    //    $expected = array(
    //        'Meisai' => array(
    //            '食事' => array( 
    //                array(
    //                    "id" => 4,
    //                    "pay_date" => "2014-04-01",
    //                    "money" => 400,
    //                ),
    //            ),
    //            '交通費' => array(
    //                array(
    //                    "id" => 7,
    //                    "pay_date" => "2014-04-01",
    //                    "money" => 700,
    //                ),
    //            ),
    //        ),
    //    );
    //    $this->assertEquals($expected, $actual, '');
    //}

    public function testgetCashMeisaiByMonth()
    {
        //x月のものを取得
        $options = array(
            'conditions' => array(
                'pay_date BETWEEN ? AND ?' => array('2014-03-01', '2014-03-31'),
                'method' => 'cash',
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '食事' => array( 
                    array(
                        "id" => 3,
                        "pay_date" => "2014-03-01",
                        "money" => 300,
                    ),
                ),
             ),
        );
        $this->assertEquals($expected, $actual, '');

        //x~y月の明細を取得
        $options = array(
            'conditions' => array(
                'pay_date BETWEEN ? AND ?' => array('2014-03-01', '2014-04-30'),
                'method' => 'cash',
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '食事' => array( 
                    array(
                        "id" => 3,
                        "pay_date" => "2014-03-01",
                        "money" => 300,
                    ),
                    array(
                        "id" => 4,
                        "pay_date" => "2014-04-01",
                        "money" => 400,
                    ),
                ),
                '交通費' => array(
                    array(
                        "id" => 7,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    public function testgetCashMeisaiByCategory()
    {
        //categoryを指定
        $options = array(
            'conditions' => array(
                'category' => array('交通費'),
                'method' => 'cash',
                'pay_date BETWEEN ? AND ?' => array('2014-04-01', '2014-04-30'),
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '交通費' => array(
                    array(
                        "id" => 7,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    public function testgetCashMeisaiIgnoreFields()
    {
        $options = array(
            'conditions' => array(
                'method' => 'cash',
                'pay_date BETWEEN ? AND ?' => array('2014-04-01', '2014-04-30'),
            ),
            'fields' => 'category',
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '食事' => array(
                    array(
                        "id" => 4,
                        "pay_date" => "2014-04-01",
                        "money" => 400,
                    ),
                ),
                '交通費' => array(
                    array(
                        "id" => 7,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    //public function testgetCreditMeisaiDefault()
    //{
    //    //月を指定しない場合今月の明細を取得する
    //    $options = array(
    //        'conditions' => array(
    //            'method' => 'credit',
    //        ),
    //    );
    //    $actual = $this->model->getMeisai_f($options);
    //    $expected = array(
    //        'Meisai' => array(
    //            '交通費' => array(
    //                array(
    //                    "id" => 6,
    //                    "pay_date" => "2014-04-01",
    //                    "money" => 600,
    //                ),
    //            ),
    //            '服' => array(
    //                array(
    //                    "id" => 9,
    //                    "pay_date" => "2014-04-01",
    //                    "money" => 700,
    //                ),
    //            ),
    //        ),
    //    );
    //    $this->assertEquals($expected, $actual, '');
    //}

    public function testgetCreditMeisaiByMonth()
    {
        //x月のものを取得
        $options = array(
            'conditions' => array(
                'pay_date BETWEEN ? AND ?' => array('2014-05-01', '2014-05-31'),
                'method' => 'credit',
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '交通費' => array(
                    array(
                        "id" => 8,
                        "pay_date" => "2014-05-01",
                        "money" => 700,
                    ),
                 ),
             ),
        );
        $this->assertEquals($expected, $actual, '');

        //x~y月の明細を取得
        $options = array(
            'conditions' => array(
                'pay_date BETWEEN ? AND ?' => array('2014-04-01', '2014-05-31'),
                'method' => 'credit',
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '交通費' => array(
                    array(
                        "id" => 6,
                        "pay_date" => "2014-04-01",
                        "money" => 600,
                    ),
                    array(
                        "id" => 8,
                        "pay_date" => "2014-05-01",
                        "money" => 700,
                    ),
                ),
                '服' => array(
                    array(
                        "id" => 9,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    public function testgetCreditMeisaiByCategory()
    {
        //categoryを指定
        $options = array(
            'conditions' => array(
                'category' => '服',
                'method' => 'credit',
                'pay_date BETWEEN ? AND ?' => array('2014-04-01', '2014-04-30'),
            ),
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '服' => array(
                    array(
                        "id" => 9,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    public function testgetCreditMeisaiIgnoreFields()
    {
        $options = array(
            'conditions' => array(
                'method' => 'credit',
                'pay_date BETWEEN ? AND ?' => array('2014-04-01', '2014-04-30'),
            ),
            'fields' => 'category',
        );
        $actual = $this->model->getMeisai_f($options);
        $expected = array(
            'Meisai' => array(
                '交通費' => array(
                    array(
                        "id" => 6,
                        "pay_date" => "2014-04-01",
                        "money" => 600,
                    ),
                ),
                '服' => array(
                    array(
                        "id" => 9,
                        "pay_date" => "2014-04-01",
                        "money" => 700,
                    ),
                ),
            ),
        );
        $this->assertEquals($expected, $actual, '');
    }

    public function testLoginCheck()
    {
        //正しく入力した場合
        $user = "kassy";
        $password = "9608";
        $actual = $this->model->loginCheck($user, $password);
        $expected = true;
        $this->assertEquals($expected, $actual);

        //userが違う
        $user = "detarame";
        $password = "9608";
        $actual = $this->model->loginCheck($user, $password);
        $this->assertNotEmpty($actual);

        //パスワードが違う
        $user = "kassy";
        $password = "detarame";
        $actual = $this->model->loginCheck($user, $password);
        $this->assertNotEmpty($actual);

        //userは合っているがパスワードが違う
        $user = "kassy";
        $password = "detarame";
        $actual = $this->model->loginCheck($user, $password);
        $this->assertNotEmpty($actual);

        //nullが来たとき
        $user = null;
        $password = null;
        $actual = $this->model->loginCheck($user, $password);
        $this->assertNotEmpty($actual);
    }
}
