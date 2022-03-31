<?php 

namespace src\Translate;

/**
 * Implementation storage.
 */
class FileStorage implements StorageInterface
{
	protected $filename;

	public function __construct($filename)
	{
		$this->filename = $filename;
	}

	public function write($data): bool
	{
		$result = file_put_contents($this->filename, $data);

		return $result !== false;
	}

	public function read()
	{
		return file_get_contents($this->filename);
	}
}