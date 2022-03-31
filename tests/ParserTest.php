<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use src\Translate\Parser;

final class ParserTest extends TestCase
{
    /**
     * @var array fixture.
     */    
    protected $initialTranslateData = [];

    /**
     * @var array fixture.
     */
    protected $disassembledData = [];
    
    /**
     * @var array fixture.
     */
    protected $extractedParserIbm = [];

    /**
     * @var array fixture.
     */
    protected $responsePaking = [];
    

    public function setUp(): void
    {
        $this->initialTranslateData = require('fixtures/initial_translate_data.php');
        $this->disassembleData = require('fixtures/disassembled_data.php');
        $this->extractedParserIbm = require('fixtures/extracted_parser_ibm.php');
        $this->responsePaking = require('fixtures/response_paking.php');
    }

    public function testCanBeParsing(): array
    {
        $data = $this->initialTranslateData;
        
        $parser = new Parser;
        $data = $parser->extractArray($data, 'ru');
        $disassembleData = $parser->disassemble($data);

        $expectData = $this->disassembleData;
        $keys = $expectData['keys'];

        $this->assertEquals($expectData, $disassembleData);

        return $keys;
    }

    /**
     * @depends testCanBeParsing
     */
    public function testCanBePaking(array $keys): array
    {
        $extractedParserIbm = $this->extractedParserIbm;
        
        $parser = new Parser;
        $responsePaking = $parser->packing($extractedParserIbm, $keys);

        $expectData = $this->responsePaking;

        $this->assertEquals($expectData, $responsePaking);

        return $responsePaking;
    }

    public function testFinalDataFormat()
    {

        $parser = new Parser;

        $data = $this->initialTranslateData;
        $parser->extractArray($data, 'ru');

        $responsePaking = $this->responsePaking;
        $key = 'en';
        $wrappedResponse = $parser->wrapArray($responsePaking, $key);
        $expectData = [
            'en' => [
                'emailOrPhone' => 'Mail or telephone',
                'password' => 'Password',
            ],
        ];
        $this->assertEquals($expectData, $wrappedResponse);

        $finalResponse = $parser->putFirstArray($wrappedResponse);
        $expectData = [
            'authentication' => [
                'en' => [
                    'emailOrPhone' => 'Mail or telephone',
                    'password' => 'Password',
                ],
            ],
        ];
        $this->assertEquals($expectData, $finalResponse);

        $finalData = $parser->putArray($data, $finalResponse);
        $expectData = [
            'authentication' => [
                'ru' => [
                    'emailOrPhone' => 'Почта или телефон',
                    'password' => 'Пароль',
                ],
                'en' => [
                    'emailOrPhone' => 'Mail or telephone',
                    'password' => 'Password',
                ],
            ],
        ];

        $this->assertEquals($expectData, $finalData);
    }
}
