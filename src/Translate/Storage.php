<?php

namespace src\Translate;

class Storage
{
    protected $storage;

    function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function write($data): bool
    {
        return $this->storage->write($data);
    }

    public function read()
    {
        return $this->storage->read();
    }
}
