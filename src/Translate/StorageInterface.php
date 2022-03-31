<?php

namespace src\Translate;

interface StorageInterface
{
	public function write($data);

	public function read();
}
