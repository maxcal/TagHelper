<?php

namespace Maxcal\TagHelper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Templating\Helper\AssetsHelper;

use \DOMDocument, \DOMElement;

/**
 *
 */
class TagHelper extends Helper {

    /**
     * @var AssetsHelper
     */
    protected $assets;

    /**
     * @param AssetsHelper $assets
     */
    public function __construct($assets = null){
        $this->assets = $assets;
    }

    /**
     * @param AssetsHelper $assets
     */
    public function setAssetsHelper($assets){
        $this->assets = $assets;
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
    public function stylesheet($name, $media = array()){
        $attributes = array();
        $name .= '.css';
        $attributes['href'] = $name;
        $attributes['rel'] = 'stylesheet';

        if ($this->getStylesheetPackage()) {
            $attributes['href'] = $this->getStylesheetPackage()->getUrl($name);
        }

        if (!empty($media)) $attributes['media'] = implode($media);

        return $this->createTag('link', null, $attributes);
    }

    /**
     * @return null|AssetsHelper
     */
    protected function getStylesheetPackage(){
        return $this->assets;
    }
}