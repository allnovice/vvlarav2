<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asset>
 */
class AssetFactory extends Factory
{
    public function definition(): array
    {
        return [

            // Asset Information
            'property_number' => 'NCIP-' . fake()->unique()->numberBetween(1000, 9999),

            'type' => fake()->randomElement([
                'Laptop',
                'Desktop',
                'Monitor',
                'Printer',
                'Scanner',
                'Server',
                'Network Device',
                'UPS',
                'Furniture',
                'Other',
            ]),

            'description' => fake()->sentence(),

            'status' => fake()->randomElement([
                'Active',
                'Under Repair',
                'Borrowed',
                'Archived',
            ]),

            'photo_path' => null,

            // Specifications
            'brand' => fake()->randomElement([
                'Dell',
                'HP',
                'Lenovo',
                'Acer',
                'Asus',
                'Apple',
                'Brother',
                'Epson',
                'Canon',
                'Cisco',
                'TP-Link',
                'APC',
            ]),

            'model' => strtoupper(fake()->bothify('??-###??')),

            'serial_number' => strtoupper(fake()->bothify('SN-########')),

            'manufacturer' => fake()->randomElement([
                'Dell',
                'HP',
                'Lenovo',
                'Acer',
                'Asus',
                'Apple',
                'Brother',
                'Epson',
                'Canon',
                'Cisco',
                'TP-Link',
                'APC',
            ]),

            // Assignment
            'assigned_to' => fake()->name(),

            'department' => fake()->randomElement([
                'Administration',
                'Finance',
                'HR',
                'IT',
                'Engineering',
                'Records',
            ]),

            'location' => 'Room ' . fake()->numberBetween(101, 305),

            // Acquisition
            'acquisition_date' => fake()->dateTimeBetween('-5 years', '-1 month'),

            'acquisition_cost' => fake()->randomFloat(2, 5000, 100000),

            'supplier' => fake()->company(),

            'warranty_expiry' => fake()->dateTimeBetween('now', '+3 years'),

            // Verification
            'verified_at' => null,
            'verified_by' => null,
        ];
    }
}
