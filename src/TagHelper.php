<?php

namespace Maxcal\TagHelper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\Asset\PackageInterface;
use \DOMDocument, \DOMElement;

/**
 * A Symfony\Component\Templating compatible view helper which creates HTML elements with no string interpolation required.
 * Inspired by the Rails ActionView helpers.
 */
class TagHelper extends Helper {

    /**
     * @var PackageInterface
     */
    protected $assets;
    protected $js_package;
    protected $css_package;

    /**
     * @param PackageInterface $assets
     */
    public function __construct(PackageInterface $assets = null){
        $this->assets = $assets;
    }

    /**
     * @param PackageInterface $assets
     * @return $this - for fluid chaining
     */
    public function setAssetsHelper(PackageInterface $assets){
        $this->assets = $assets;
        return $this;
    }

    /**
     * @param PackageInterface $pkg
     * @return $this- for fluid chaining
     */
    public function setStylesheetsPackage(PackageInterface $pkg){
        $this->css_package = $pkg;
        return $this;
    }

    /**
     * @param PackageInterface $pkg
     * @return $this- for fluid chaining
     */
    public function setJavascriptPackage(PackageInterface $pkg){
        $this->js_package = $pkg;
        return $this;
    }

    /**
     * Returns the canonical name of this helper.
     *
     * @return string The canonical name
     *
     * @api
     */
    public function getName()
    {
        return 'tag';
    }

    /**
     * Low level method to create generic HTML elements
     * @param $tag_name
     * @param $value string | DOMElement - the node value of the created element
     * @param $attibutes array - (optional) attributes to apply to the node
     * @return string
     * @api
     */
    public function createTag($tag_name, $value, $attributes = array()){
        $doc = new DOMDocument();
        $el = $doc->createElement($tag_name, $value);
        foreach ($attributes as $key => $val) {
            $el->setAttribute($key, $val);
        }
        $doc->appendChild($el);
        return trim($doc->saveHTML());
    }

    /**
     * Creates an anchor element
     * @param $text
     * @param $href
     * @param array $attributes
     * @return string
     * @api
     */
    public function link($text, $href, $attributes = array()){
        $attributes['href'] = $href;
        return $this->createTag('a', $text, $attributes);
    }

    /**
     * Create a link element pointing to a style sheet
     * Will use the AssetsHelper to resolve a url if it has been injected
     * @param $name
     * @param array $media
     * @return string
     * @api
     */
    public function stylesheet($name, $media = array('all')){
        $attributes = array();
        $name .= '.css';
        $attributes['href'] = $name;
        $attributes['rel'] = 'stylesheet';

        if ($this->getStylesheetPackage()) {
            $attributes['href'] = $this->getStylesheetPackage()->getUrl($name);
        }

        if (!empty($media)) $attributes['media'] = implode(' ', $media);

        return $this->createTag('link', null, $attributes);
    }

    /**
     * Creates a "empty" script tag with the src set to the
     * @note Does not support "inline" script tags.
     * @note Does not set a "type" attribute since they are deemed "useless" in HTML5.
     * @param string $src
     * @param array $attributes (optional)
     * @return string
     * @api
     */
    public function script($src, $attributes = array()) {
        $attributes['src'] = "$src.js";

        if ($this->getScriptPackage()) {
            $attributes['src'] = $this->getScriptPackage()->getUrl($attributes['src']);
        }

        return $this->createTag('script', null, $attributes);
    }

    /**
     * @return null|PackageInterface
     */
    protected function getStylesheetPackage(){
        if ($this->assets) return $this->assets->getPackage($this->css_package);
    }

    /**
     * @return null|PackageInterface
     */
    protected function getScriptPackage(){
        if ($this->assets) return $this->assets->getPackage($this->css_package);
    }

}