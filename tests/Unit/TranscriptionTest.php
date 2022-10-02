<?php

namespace Tests\Unit;

use App\Line;
use App\Transcription;
use PHPUnit\Framework\TestCase;

class TranscriptionTest extends TestCase
{
    protected $transcription;

    public function setUp(): void
    {
        $this->transcription = Transcription::load(
            __DIR__ . "/../stubs/basic-example.vtt"
        );
    }

    public function test_it_loads_a_vtt_file() {
        $this->assertStringContainsString('Here is', $this->transcription);
        $this->assertStringContainsString('Example VTT file', $this->transcription);
    }

    public function test_it_can_convert_to_an_array_of_lines() {
        $lines = $this->transcription->lines();

        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    public function test_it_discards_irrelevant_lines_from_the_vtt_file()
    {
        $this->assertStringNotContainsString("WEBVTT", $this->transcription);
        $this->assertCount(2, $this->transcription->lines());
    }

    public function test_it_renders_the_lines_as_html()
    {
        $expected = <<<EOT
        <a href="?time=00:03">Here is</a>
        <a href="?time=00:04">Example VTT file</a>
        EOT;

        $this->assertEquals($expected, $this->transcription->lines()->asHtml());
    }
}