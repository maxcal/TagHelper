<?php


namespace Maxcal\TagHelper\Tests;

use Maxcal\TagHelper\TagHelper;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Templating\Helper\AssetsHelper;

class TagHelperTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var TagHelper
     */
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

    public function test_stylesheet_has_rel_attribute(){
        $tag = $this->subject->stylesheet('ugly');
        $crawler = new Crawler($tag);
        $this->assertEquals('stylesheet', $crawler->filter('link')->attr('rel') );
    }

    public function test_stylesheet_has_media_attribute(){
        $tag = $this->subject->stylesheet('ugly', ['screen', 'print']);
        $crawler = new Crawler($tag);
        $this->assertContains('screen', $crawler->filter('link')->attr('media') );
        $this->assertContains('print', $crawler->filter('link')->attr('media') );
    }

    public function test_stylesheet_with_no_assets_helper(){
        $tag = $this->subject->stylesheet('ugly');
        $crawler = new Crawler($tag);
        $this->assertEquals('ugly.css', $crawler->filter('link')->attr('href') );
    }

    public function test_stylesheet_with_assets_helper(){
        $this->subject->setAssetsHelper(new AssetsHelper('/foo/bar'));
        $tag = $this->subject->stylesheet('ugly');
        $crawler = new Crawler($tag);
        $this->assertEquals('/foo/bar/ugly.css', $crawler->filter('link')->attr('href') );
    }

    public function test_script_with_no_assets_helper(){
        $tag = $this->subject->script('test');
        $crawler = new Crawler($tag);
        $this->assertEquals('test.js', $crawler->filter('script')->attr('src') );
    }

    public function test_script_with_assets_helper(){
        $this->subject->setAssetsHelper(new AssetsHelper('/foo/bar'));
        $tag = $this->subject->script('test');
        $crawler = new Crawler($tag);
        $this->assertEquals('/foo/bar/test.js', $crawler->filter('script')->attr('src') );
    }

}