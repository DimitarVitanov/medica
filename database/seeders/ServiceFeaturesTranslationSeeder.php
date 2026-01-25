<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Translation;

class ServiceFeaturesTranslationSeeder extends Seeder
{
    public function run(): void
    {
        // English translations for service features
        $translations = [
            'opsta-medicina' => [
                'Maintaining health of healthy patients',
                'Maintaining health of sick patients',
                'Prevention of chronic diseases',
                'Prevention of degenerative diseases',
            ],
            'ginekologija' => [
                'Gynecological examination',
                '4D Ultrasound',
                'Vaginal Ultrasound',
                'PAP test',
                'Microbiological swabs',
                'Pregnancy monitoring with 4D Ultrasound',
                'Infertility investigation',
            ],
            'laboratorija' => [
                '24-hour urine collection',
                'Spermogram',
                'Iron level determination',
                'Lipid status determination',
                'Laboratory analysis',
            ],
            'medicina-na-trud' => [
                'Diagnosis of occupational diseases',
                'Spirometry',
                'Peak Flow Meter - flowmetry',
                'Audiometry',
                'Visual acuity testing',
            ],
            'semejna-medicina' => [
                'Preventive examinations',
                'Chronic disease monitoring',
                'Vaccination',
                'Health counseling',
            ],
            'psihijatrija' => [],
            'estetska-medicina' => [],
        ];

        foreach ($translations as $slug => $features) {
            $service = Service::where('slug', $slug)->first();
            if ($service && !empty($features)) {
                Translation::updateOrCreate(
                    [
                        'translatable_type' => 'App\Models\Service',
                        'translatable_id' => $service->id,
                        'locale' => 'en',
                        'field' => 'features',
                    ],
                    ['value' => json_encode($features)]
                );
                $this->command->info("Added EN features for {$slug}");
            }
        }

        $this->command->info('Service features translations completed!');
    }
}
