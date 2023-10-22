<?php

namespace Hfig\MAPI;

use Hfig\MAPI\Mime\ConversionFactory;
use Hfig\MAPI\OLE\CompoundDocumentElement as Element;

class MapiMessageFactory
{
    private $parent = null;

    public function __construct(ConversionFactory $conversionFactory = null)
    {
        $this->parent = $conversionFactory;
    }

    public function parseMessage(Element $root)
    {
        if ($this->parent) {
            return $this->parent->parseMessage($root);
        }

        return new \Hfig\MAPI\Message\Message($root);
    }
}
