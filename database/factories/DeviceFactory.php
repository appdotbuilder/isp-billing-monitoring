<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['router', 'olt', 'tr069', 'ssh', 'snmp'];
        $type = $this->faker->randomElement($types);
        
        $brands = [
            'router' => ['Mikrotik', 'Cisco', 'Ubiquiti', 'TP-Link'],
            'olt' => ['Huawei', 'ZTE', 'Fiberhome', 'Nokia'],
            'tr069' => ['GenieACS', 'FreeACS', 'OpenACS'],
            'ssh' => ['Linux Server', 'Ubuntu Server', 'CentOS'],
            'snmp' => ['Network Switch', 'Access Point', 'Server'],
        ];
        
        return [
            'company_id' => Company::factory(),
            'name' => $this->faker->words(2, true) . ' ' . strtoupper($type),
            'type' => $type,
            'brand' => $this->faker->randomElement($brands[$type]),
            'model' => $this->faker->bothify('##??-####'),
            'ip_address' => $this->faker->localIpv4,
            'port' => $type === 'ssh' ? 22 : ($type === 'snmp' ? 161 : random_int(80, 8080)),
            'username' => $this->faker->userName,
            'password' => 'encrypted_password',
            'community_string' => $type === 'snmp' ? 'public' : null,
            'status' => $this->faker->randomElement(['online', 'offline', 'maintenance']),
            'last_seen' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'description' => $this->faker->sentence,
            'monitoring_config' => [
                'check_interval' => random_int(30, 300),
                'alert_thresholds' => [
                    'cpu' => random_int(80, 95),
                    'memory' => random_int(85, 95),
                    'bandwidth' => random_int(80, 90),
                ],
            ],
            'last_metrics' => [
                'cpu_usage' => random_int(10, 90),
                'memory_usage' => random_int(20, 85),
                'bandwidth_in' => random_int(100, 1000) . ' Mbps',
                'bandwidth_out' => random_int(50, 800) . ' Mbps',
                'uptime' => random_int(1, 365) . ' days',
                'error_count' => random_int(0, 10),
            ],
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the device is online.
     */
    public function online(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'online',
            'last_seen' => now(),
        ]);
    }

    /**
     * Indicate that the device is offline.
     */
    public function offline(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'offline',
            'last_seen' => $this->faker->dateTimeBetween('-1 week', '-1 hour'),
        ]);
    }
}