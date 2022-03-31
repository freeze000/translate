<?php

namespace src\Translate;

class Ibm implements HttpInterface
{
	protected $http;

	public function __construct(HttpInterface $http)
	{
		$this->http = $http;
	}

	/**
     * Send http request.
     * 
     * @param array $postData example
     * [
     *    'text' => ['Почта или телефон', 'Пароль'],
     *    'model_id' => 'ru-en'
     * ]
     */
	public function request(array $postData)
	{
		$body = $this->http->request($postData);

		return $body;
	}
}
