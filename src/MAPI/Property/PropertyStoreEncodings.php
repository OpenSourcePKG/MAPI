<?php

namespace Hfig\MAPI\Property;

use Hfig\MAPI\OLE\CompoundDocumentElement as Element;

class PropertyStoreEncodings
{
    const ENCODERS = [
        0x000D => 'decode0x000d',
        0x001F => 'decode0x001f',
        0x001E => 'decode0x001e',
        0x0203 => 'decode0x0102',
    ];

    public static function decode0x000d(Element $e)
    {
        return $e;
    }

    public static function decode0x001f(Element $e)
    {
        return mb_convert_encoding($e->getData(), 'UTF-8', 'UTF-16LE');
    }

    public static function decode0x001e(Element $e)
    {
        return trim($e->getData());
    }

    public static function decode0x0102(Element $e)
    {
        return $e->getData();
    }

    public static function decodeUnknown(Element $e)
    {
        return $e->getData();
    }

    public static function decode($encoding, Element $e)
    {
        if (isset(self::ENCODERS[$encoding])) {
            $fn = self::ENCODERS[$encoding];

            return self::$fn($e);
        }

        return self::decodeUnknown($e);
    }

    public static function getDecoder($encoding)
    {
        if (isset(self::ENCODERS[$encoding])) {
            $fn = self::ENCODERS[$encoding];

            return self::$fn;
        }

        // What does the poet want to tell us by this?
        // return self::decodeUnknown
        // I set the call with zero so that the IDE doesn't throw an error.
        return self::decodeUnknown(null);
    }

    public static function decodeFunction($encoding, Element $e)
    {
        return function () use ($encoding, $e) {
            return PropertyStoreEncodings::decode($encoding, $e);
        };
    }
}
