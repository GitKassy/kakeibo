<?php

class AllPluginTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
    
        $suite = new CakeTestSuite('AllPlugin Test For Kakeibo');
        $suite->addTestFile(dirname( __FILE__) . DS . 'AllModelTest.php');
        $suite->addTestFile(dirname( __FILE__) . DS . 'AllBehaviorTest.php');
        $suite->addTestFile(dirname( __FILE__) . DS . 'AllControllerTest.php');
        return $suite;

    }

}
