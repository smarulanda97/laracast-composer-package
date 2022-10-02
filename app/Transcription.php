<?php

namespace App;

class Transcription
{
    /**
     * @param array $lines
     */
    public function __construct(protected array $lines)
    {
        $this->lines = array_values(
            $this->discardInvalidLines($lines)
        );
    }

    public static function load(string $path): self
    {
        return new static(file($path));
    }

    public function lines(): Lines
    {
        return new Lines(array_map(
            fn($line) => new Line(...$line),
            array_chunk($this->lines, 3)
        ));
    }

    protected function discardInvalidLines(array $lines): array
    {
        return array_slice(array_filter(array_map('trim', $lines)), 1);
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }
}