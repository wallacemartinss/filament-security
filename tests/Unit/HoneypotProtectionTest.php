<?php

declare(strict_types=1);

namespace WallaceMartinss\FilamentSecurity\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Spatie\Honeypot\Honeypot;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use WallaceMartinss\FilamentSecurity\Tests\TestCase;

final class HoneypotProtectionTest extends TestCase
{
    #[Test]
    public function it_can_create_honeypot_data(): void
    {
        $data = new HoneypotData;

        $this->assertInstanceOf(HoneypotData::class, $data);
        $this->assertIsArray($data->toArray());
        $this->assertCount(2, $data->toArray());
    }

    #[Test]
    public function honeypot_data_contains_required_fields(): void
    {
        $data = new HoneypotData;
        $array = $data->toArray();

        $honeypot = app(Honeypot::class);
        $validFromField = $honeypot->validFromFieldName();

        // Name field has a randomized key, so we check valid_from and that one other key exists
        $this->assertArrayHasKey($validFromField, $array);
        $this->assertCount(2, $array);
    }

    #[Test]
    public function honeypot_data_has_empty_name_value(): void
    {
        $data = new HoneypotData;
        $array = $data->toArray();

        $honeypot = app(Honeypot::class);
        $validFromField = $honeypot->validFromFieldName();

        // Remove valid_from to get the name field
        unset($array[$validFromField]);
        $nameValue = array_values($array)[0];

        $this->assertEmpty($nameValue);
    }

    #[Test]
    public function honeypot_data_valid_from_is_encrypted(): void
    {
        $data = new HoneypotData;
        $array = $data->toArray();

        $honeypot = app(Honeypot::class);
        $validFromField = $honeypot->validFromFieldName();

        $this->assertNotEmpty($array[$validFromField]);
        $this->assertIsString($array[$validFromField]);
    }

    #[Test]
    public function honeypot_data_is_wireable(): void
    {
        $data = new HoneypotData;
        $livewireData = $data->toLivewire();

        $this->assertIsArray($livewireData);

        $restored = HoneypotData::fromLivewire($livewireData);
        $this->assertInstanceOf(HoneypotData::class, $restored);
    }

    #[Test]
    public function honeypot_view_exists(): void
    {
        $this->assertTrue(
            view()->exists('filament-security::components.honeypot-fields'),
        );
    }

    #[Test]
    public function honeypot_config_has_enabled_flag(): void
    {
        $this->assertTrue(config('filament-security.honeypot.enabled'));
    }
}
