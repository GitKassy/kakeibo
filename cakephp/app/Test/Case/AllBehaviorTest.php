<?php

class AllBehaviorTest extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $suite = new CakeTestSuite('AllBehaviorTest For Kakeibo');
        $suite->addTestDirectory(dirname( __FILE__) . DS . 'Model' . DS . 'Behavior');
        return $suite;
    }

}
