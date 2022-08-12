<?php

namespace Dedoc\Documentor\Support\Generator;

class Response
{
    public ?int $code = null;

    /** @var array<string, Schema|Reference> */
    private array $content;

    private string $description = '';

    public function __construct(?int $code)
    {
        $this->code = $code;
    }

    public static function make(?int $code)
    {
        return new self($code);
    }

    /**
     * @param  Schema|Reference  $schema
     */
    public function setContent(string $type, $schema)
    {
        $this->content[$type] = $schema;

        return $this;
    }

    public function toArray()
    {
        $result = array_filter([
            'description' => $this->description,
        ]);

        $content = [];
        foreach ($this->content as $mediaType => $schema) {
            $content[$mediaType] = [
                'schema' => $schema->toArray(),
            ];
        }

        $result['content'] = $content;

        return $result;
    }

    public function getContent(string $mediaType)
    {
        return $this->content[$mediaType];
    }

    public function description(string $string)
    {
        $this->description = $string;

        return $this;
    }
}
