<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Treatment;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $treatments = [
            [
                'category' => 'Konsultasi',
                'name' => 'Konsultasi / Premedikasi',
                'min_price' => 100000,
                'max_price' => 150000,
            ],
            [
                'category' => 'Pembersihan Gigi',
                'name' => 'Pembersihan Karang Gigi',
                'min_price' => 300000,
                'max_price' => 500000,
            ],
            [
                'category' => 'Penambalan',
                'name' => 'Tambal Sementara',
                'min_price' => 300000,
                'max_price' => 400000,
            ],
            [
                'category' => 'Penambalan',
                'name' => 'Open Bur',
                'min_price' => 100000,
                'max_price' => 200000,
            ],
            [
                'category' => 'Penambalan',
                'name' => 'Pengisian Saluran Akar',
                'min_price' => 100000,
                'max_price' => 150000,
            ],
            [
                'category' => 'Penambalan',
                'name' => 'Tambal Fuji / GIC',
                'min_price' => 300000,
                'max_price' => 450000,
            ],
            [
                'category' => 'Penambalan',
                'name' => 'Tambal Composite / Sinar',
                'min_price' => 300000,
                'max_price' => 500000,
            ],
            [
                'category' => 'Pencabutan',
                'name' => 'Cabut Gigi Susu',
                'min_price' => 100000,
                'max_price' => 150000,
            ],
            [
                'category' => 'Pencabutan',
                'name' => 'Cabut Gigi Permanen Mudah',
                'min_price' => 300000,
                'max_price' => 300000,
            ],
            [
                'category' => 'Pencabutan',
                'name' => 'Cabut Gigi Sulit',
                'min_price' => 400000,
                'max_price' => 500000,
            ],
            [
                'category' => 'Bedah Mulut',
                'name' => 'Odontectomy',
                'min_price' => 1500000,
                'max_price' => 2500000,
            ],
            [
                'category' => 'Gigi Tiruan',
                'name' => 'Plat Akrilik',
                'min_price' => 1400000,
                'max_price' => 1400000,
            ],
            [
                'category' => 'Gigi Tiruan',
                'name' => 'Penambahan Setiap Gigi',
                'min_price' => 200000,
                'max_price' => 250000,
            ],
            [
                'category' => 'Gigi Tiruan',
                'name' => 'Crown Metal Porcelain / Bridge per Gigi',
                'min_price' => 2500000,
                'max_price' => 2500000,
            ],
            [
                'category' => 'Gigi Tiruan',
                'name' => 'Crown E-Max',
                'min_price' => 3000000,
                'max_price' => 3000000,
            ],
            [
                'category' => 'Gigi Tiruan',
                'name' => 'Crown Zirconia',
                'min_price' => 3500000,
                'max_price' => 3500000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Behel Lepasan Satu Rahang',
                'min_price' => 1000000,
                'max_price' => 1000000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Behel Lepasan Dua Rahang',
                'min_price' => 1500000,
                'max_price' => 1500000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Kontrol Behel Lepasan',
                'min_price' => 200000,
                'max_price' => 200000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Behel Metal Satu Rahang',
                'min_price' => 3000000,
                'max_price' => 3000000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Behel Metal Dua Rahang',
                'min_price' => 5000000,
                'max_price' => 6000000,
            ],
            [
                'category' => 'Ortodonti',
                'name' => 'Kontrol Behel Metal',
                'min_price' => 350000,
                'max_price' => 350000,
            ],
        ];

        foreach ($treatments as $item) {
            Treatment::updateOrCreate(
                [
                    'category' => $item['category'],
                    'name' => $item['name'],
                ],
                [
                    'description' => null,
                    'min_price' => $item['min_price'],
                    'max_price' => $item['max_price'],
                    // Menjaga kompatibilitas dengan kolom price yang lama.
                    'price' => $item['min_price'],
                    'is_active' => true,
                ]
            );
        }
    }
}