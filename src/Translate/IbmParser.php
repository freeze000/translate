<?php

namespace src\Translate;

class IbmParser
{
	/**
	 * Extract translation from ibm response.
	 */
	public function extract(array $data): array
	{
		// $data['translations']
		$data = array_shift($data);

		$returnData = [];
		foreach ($data as $value) {
			// $value['translation'];
			$translatedText = array_shift($value);

			$returnData[] = $translatedText;
		}

		return $returnData;
	}
}
