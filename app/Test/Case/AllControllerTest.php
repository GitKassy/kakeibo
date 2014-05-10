<?php

class AllControllerTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('AllControllerTest For Kakeibo');
        $suite->addTestDirectory(dirname( __FILE__) . DS . 'Controller');
        return $suite;
    }

}
