<?php

namespace Hfig\MAPI\OLE;

// interface to abstract IPersistStorage/IPersistStream data
// elements in an OLE Compound Document
// PEAR::OLE refers to these as PPS elements

interface CompoundDocumentElement
{
    const TYPE_ROOT = 5;

    const TYPE_DIRECTORY = 1;

    const TYPE_FILE = 2;

    public function getIndex();

    public function setIndex($index);

    public function getName();

    public function setName($name);

    public function getType();

    public function setType($type);

    public function isFile();

    public function isDirectory();

    public function isRoot();

    public function getPreviousIndex();

    public function setPreviousIndex($index);

    public function getNextIndex();

    public function setNextIndex($index);

    public function getFirstChildIndex();

    public function setFirstChildIndex($index);

    public function getTimeCreated();

    public function setTimeCreated($time);

    public function getTimeModified();

    public function setTimeModified($time);

    // private, so no setter interface
    public function getStartBlock();

    public function getSize();

    public function setSize($size);

    /** @return Pear\DocumentElementCollection */
    public function getChildren();

    public function getData();

    public function saveToStream($stream);
}
