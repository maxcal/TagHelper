<?php

namespace Maxcal\TagHelper;

use Symfony\Component\Templating\Helper\Helper;

use \DOMDocument, \DOMElement;

/**
 *
 */
class TagHelper extends Helper {

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
     * @api
     * @return string
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



}