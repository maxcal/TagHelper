<?php

namespace Maxcal\TagHelper;

use Symfony\Component\Templating\Helper\Helper;

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
}