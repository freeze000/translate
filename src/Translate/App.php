<?php

namespace src\Translate;

use Exception;

class App
{
    /**
     * @var array
     */
    protected $config = [];

    function __construct(array $config)
    {
        $this->config = $config;
    }

    public function run($filepath, $translateFrom, $translateTo)
    {
        $apiUri = $this->config['ibm']['apiUri'];
        $apiKey = $this->config['ibm']['apiKey'];
        $ibmHttp = new IbmHttp($apiUri, $apiKey);
        $ibm = new Ibm($ibmHttp);

        $this->fileExists($filepath);
        $fileStorage = new FileStorage($filepath);
        $storage = new Storage($fileStorage);
        $translateDataJson = $storage->read();
        $translateData = json_decode($translateDataJson, true);

        $parser = new Parser;
        $extractedTranslate = $parser->extractArray($translateData, $translateFrom);
        $disassembleExtracted = $parser->disassemble($extractedTranslate);
        $translateTextKeys = $disassembleExtracted['keys'];
        $translateTextFrom = $disassembleExtracted['values'];

        $model = implode('-', [$translateFrom, $translateTo]);
        $postData = [
            'text' => $translateTextFrom, // array
            'model_id' => $model, // 'ru-en'
        ];
        $stringResponseIbm = $ibm->request($postData);
        
        $responseIbm = json_decode($stringResponseIbm, true);

        $ibmParser = new IbmParser;
        $extractedResponseIbm = $ibmParser->extract($responseIbm);
        $responsePaking = $parser->packing($extractedResponseIbm, $translateTextKeys);

        $wrappedResponse = $parser->wrapArray($responsePaking, $translateTo);
        $finalResponse = $parser->putFirstArray($wrappedResponse);

        $finalData = $parser->putArray($translateData, $finalResponse);
        $jsonFinal = json_encode($finalData, JSON_UNESCAPED_UNICODE);

        $fileStorage->write($jsonFinal);
    }

    public function createBackup(string $filename)
    {
        $this->fileExists($filename);
        $backupFilename = $filename . '.bak';
        $copy = copy($filename, $backupFilename);
        if (!$copy) {
            throw new Exception("Error: Can not create backup file", 1);
        }

        return $copy ? $backupFilename : false;
    }

    /**
     * @return Exception if $filepath does not exist.
     */
    protected function fileExists(string $filepath): void
    {
        if (!file_exists($filepath)) {
            throw new Exception("Can not find file $filepath", 1);
        }
    }
}
