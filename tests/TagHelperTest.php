<?php


namespace Maxcal\TagHelper\Tests;

use Maxcal\TagHelper\TagHelper;

class TagHelperTest extends \PHPUnit_Framework_TestCase {

    protected $subject;

    function setUp(){
        $this->subject = new TagHelper();
    }

    public function test_getName(){
        $this->assertEquals('tag', $this->subject->getName());
    }

}
 