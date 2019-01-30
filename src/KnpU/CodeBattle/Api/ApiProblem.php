<?php

namespace KnpU\CodeBattle\Api;


use Symfony\Component\HttpFoundation\Response;

class ApiProblem
{
    const TYPE_VALIDATION_ERROR = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

    private static $titles = [
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent'
    ];

    private $statusCode;

    private $type;

    private $title;

    private $extraData = [];

    public function __construct($statusCode, $type = null)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;

        if (null === $type) {
            $this->type = 'about:blank';
            $this->title = isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : 'Unknown status code :(';
        } else {
            if (!isset(self::$titles[$type])) {
                throw new \Exception(sprintf(
                    'No title for type "%s". Did you make it up?', $type
                ));
            }

            $this->title = self::$titles[$type];
        }
    }

    public function toArray()
    {
        return array_merge($this->extraData, [
            'status' => $this->statusCode,
            'type' => $this->type,
            'title' => $this->title
        ]);
    }

    public function set($name, $value)
    {
        $this->extraData[$name] = $value;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
