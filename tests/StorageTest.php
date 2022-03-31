<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use src\Translate\Storage;
use src\Translate\FileStorage;

final class StorageTest extends TestCase
{
    /**
     * @var array fixture.
     */    
    protected $initialTranslateData = [];

    /**
     * @var string fixture.
     */    
    // protected $jsonInitialTranslatePath = '';

    /**
     * @var string $filename
     */
    protected $filename;

    /**
     * @var Storage $storage
     */
    protected $storage;

    public function setUp(): void
    {
        $this->initialTranslateData = require('fixtures/initial_translate_data.php');
        // $this->jsonInitialTranslatePath = 'fixtures/json_initial_translate.php';


        $this->filename = 'runtime/filestorage.json';

        $fileStorage = new FileStorage($this->filename);
        $this->storage = new Storage($fileStorage);
    }

    public function testCanBeWritingAndRead(): void
    {
        $filename = $this->filename;

        // delete file
        @unlink($filename);
        $this->assertFalse(file_exists($filename));

        $storage = $this->storage;

        $data = $this->initialTranslateData;
        $jsonData = json_encode($data);

        $storage->write($jsonData);

        $this->assertFileExists($filename);

        $storedJsonData = $storage->read();
        $storedData = json_decode($storedJsonData, true);
        $this->assertEquals($data, $storedData);
    }
}
