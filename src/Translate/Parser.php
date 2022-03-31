<?php 

namespace src\Translate;

class Parser
{
    /**
     * @var array $extractedKeys contains aimed body data.
     */
    protected $extractedKeys = [];

    protected function extractFirstArray(&$array)
    {
        $firstKey = array_key_first($array);
        $this->extractedKeys[] = $firstKey;

        return array_shift($array);
    }

    /**
     * Excract concrete data by key (ru, en, it).
     */
    public function extractArray(array $array, string $key): array
    {
        $array = $this->extractFirstArray($array);
        return $array[$key];
    }

    /**
     * To pack extracted array.
     * We take aimed body data (see $extractedKeys) to pack array.
     */
    public function putFirstArray(array $data): array
    {
        $extractedKeys = $this->extractedKeys;
        $result = [];
        $pointer = &$result;
        foreach ($extractedKeys as $keyName) {
            $pointer[$keyName] = [];
            $pointer = &$pointer[$keyName];
        }

        $pointer = $this->putArray($pointer, $data);

        return $result;
    }

    public function putArray(array$array, array$putArray): array
    {
        return array_replace_recursive($array, $putArray);
    }

    /**
     * To wrap array in the key.
     */
    public function wrapArray($array, $key)
    {
        $result[$key] = &$array;

        return $result;
    }

    /**
     * Separate keys and values
     */
    public function disassemble(array $data): array
    {
        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = $value;
        }

        return [
            'keys' => $keys,
            'values' => $values,
        ];
    }

    /**
     * To collect disassemble data.
     * Unite keys with data.
     *
     * @param array $data 
     * @param array $keys keys from dissabelble.
     */
    public function packing(array $data, array $keys): array
    {
        $result = [];
        foreach ($keys as $index => $key) {
            $result[$key] = $data[$index];
        }

        return $result;
    }
}
