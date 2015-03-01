<?php


namespace Maxcal\TagHelper\Tests;

use Maxcal\TagHelper\TagHelper;

class TagHelperTest extends \PHPUnit_Framework_TestCase {

    protected $subject;

    function setUp(){
        $this->subject = new TagHelper();
    }

    public function test_getName(){
        $this->assertEquals('tag', $this->subject->getName(),
            'TagHelper should implement the getName function so that it can be used with the Symfony Templating Component'
        );
    }

    public function test_createTag(){
        $tag = $this->subject->createTag('p', 'Hello World!');
        $this->assertEquals('<p>Hello World!</p>', $tag,
            'it should create basic html elements'
        );
    }

    public function test_createTag_adds_attributes(){
        $tag = $this->subject->createTag('a', 'Hello World!', ['href' => '#']);
        $this->assertEquals('<a href="#">Hello World!</a>', $tag,
            'it should apply attributes supplied to the element'
        );
    }

    public function test_link(){
        $tag = $this->subject->link('Hello World!', '#');
        $this->assertEquals('<a href="#">Hello World!</a>', $tag,
            'it should create a link with the proper href and value'
        );
    }

}