<?php

namespace Hfig\MAPI\Mime\Swiftmailer\Adapter;

use Swift_DependencyContainer;

class DependencySet
{
    // override the HeaderFactory registration in the DI container
    public static function register($force = false)
    {
        static $registered = false;

        if ($registered && ! $force) {
            return;
        }

        $container = Swift_DependencyContainer::getInstance();
        $container->register('mime.headerfactory')
            ->asNewInstanceOf(HeaderFactory::class)
            ->withDependencies([
                'mime.qpheaderencoder',
                'mime.rfc2231encoder',
                'email.validator',
                'properties.charset',
                'address.idnaddressencoder',
            ]);

        $registered = true;
    }
}
