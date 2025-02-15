<?php

namespace Hfig\MAPI\Mime\Swiftmailer\Adapter;

use Swift_Mime_Headers_UnstructuredHeader;

// this is an UnstructuredHeader that is less zealous about encoding parameters
// to implement this we must build a new factory that can instantiate this class
// and update the DI container to use the factory

class UnstructuredHeader extends Swift_Mime_Headers_UnstructuredHeader
{
    /**
     * Test if a token needs to be encoded or not.
     *
     * @param  string  $token
     * @return bool
     */
    protected function tokenNeedsEncoding($token)
    {
        static $prevToken = '';

        $encode = false;

        // better --
        // any non-printing character
        // any non-ASCII character
        // any \n not preceded by \r
        // any \r\n not proceeded by a space or tab (requires joining the current token with the previous token as \r\n splits tokens)

        if (preg_match('~([\x00-\x08\x10-\x19\x7F-\xFF]|(?<!\r)\n)~', $token)) {
            $encode = true;
        }
        if (substr($token, -2) == "\r\n") {
            $prevToken = $token;
        //$encode = true;
        } else {
            $matchToken = $prevToken.$token;

            if (preg_match('~(\r\n(?![ \t]))~', $matchToken)) {
                $encode = true;
            }

            $prevToken = '';
        }

        return $encode;
    }
}
