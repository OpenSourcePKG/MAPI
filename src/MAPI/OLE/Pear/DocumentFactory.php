<?php

namespace Hfig\MAPI\OLE\Pear;

use Hfig\MAPI\OLE\CompoundDocumentElement;
use Hfig\MAPI\OLE\CompoundDocumentFactory;
use OLE;

/**
 * MAPI Document factory, result by a source the CompoundDocumentElement.
 */
class DocumentFactory implements CompoundDocumentFactory
{
    /**
     * @param string $file
     * @throws \Exception
     */
    public function createFromFile($file): CompoundDocumentElement
    {
        $ole = new OLE();
        $ole->read($file);

        if ($ole->root === null) {
            throw new \Exception('MAPI->DocumentFactory->createFromFile->OLE->root === null, Can not trasform File to DocumentElement: ' . $file);
        }

        return new DocumentElement($ole, $ole->root);
    }

    /**
     * @param string $stream
     * @throws \Exception
     */
    public function createFromStream($stream): CompoundDocumentElement
    {
        // PHP buffering appears to prevent us using this wrapper - sometimes fseek() is not called
        //$wrappedStreamUrl = StreamWrapper::wrapStream($stream, 'r');

        $ole = new OLE();
        $ole->readStream($stream);

        if ($ole->root === null) {
            throw new \Exception('MAPI->DocumentFactory->createFromStream->OLE->root === null, Can not trasform stream to DocumentElement.');
        }

        return new DocumentElement($ole, $ole->root);
    }
}
