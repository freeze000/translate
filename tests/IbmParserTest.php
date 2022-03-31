<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use src\Translate\IbmParser;

final class IbmParserTest extends TestCase
{
    /**
     * @var array fixture.
     */
    protected $extractedParserIbm = [];
    

    public function setUp(): void
    {
        $this->extractedParserIbm = require('fixtures/extracted_parser_ibm.php');
    }

    public function testCanBePacking(): void
    {
        $responseIbm = [
            'translations' => [
                [
                    'translation' => 'Mail or telephone',
                ],
                [
                    'translation' => 'Password',
                ],
            ],
            'word_count' => 6,
            'character_count' => 23,
        ];

        $ibmParser = new IbmParser;
        $extractedParser = $ibmParser->extract($responseIbm);

        $expectData = $this->extractedParserIbm;

        $this->assertEquals($expectData, $extractedParser);
    }
}
