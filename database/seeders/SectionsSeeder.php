<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class SectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'key' => 'about_us',
                'title' => 'За нас',
                'data' => [
                    'title' => 'Вашето здравје е наш приоритет',
                    'lead_text' => 'ПЗУ Медика е формирана во 1993 година, како прва приватна здравствена установа во општина Струмица.',
                    'description' => 'Цели 30 години "ПЗУ Медика" работи во голем за зачувување и унапредување на здравјето на своите пациенти. Започна како Ординација по Општа Медицина се развиваше постепено зголемувајќи го својот број на вработени и соделници на стручност.',
                    'additional_text' => 'ПЗУ Медика располага со две ординации по Општа Медицина, Психијатриска ординација, Гинеколошко акушерска ординација, ординација по Трудова медицина и биохемиска лабораторија.',
                ],
                'is_active' => true,
            ],
            [
                'key' => 'stats',
                'title' => 'Статистики',
                'data' => [
                    'stats' => [
                        ['number' => '30+', 'label' => 'Години искуство'],
                        ['number' => '40k+', 'label' => 'Задоволни пациенти'],
                        ['number' => '15+', 'label' => 'Специјалисти'],
                        ['number' => '5', 'label' => 'Ординации'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'key' => 'working_hours',
                'title' => 'Работно време',
                'data' => [
                    'locations' => [
                        ['department' => 'Општа и Психијатриска Ординација', 'hours' => 'Пон до Петок 08:00 - 15:00', 'address' => 'Ванчо Китанов бр. 19', 'phone' => '034-360-444', 'doctor' => ''],
                        ['department' => 'Општа, Семејна и Трудова Ординација', 'hours' => 'Пон до Петок 08:00 - 20:00', 'address' => 'Панче Пешев', 'phone' => '034-326-301', 'doctor' => ''],
                        ['department' => 'Гинеколошка Ординација', 'hours' => 'Пон до Петок 09:00 - 16:00', 'address' => 'Благој Јанков Мучето бр. 56', 'phone' => '034-322-991', 'doctor' => ''],
                        ['department' => 'Лабораторија', 'hours' => 'Пон до Петок 08:00 - 16:00', 'address' => 'Братство Единство бр. 41', 'phone' => '034-323-444', 'doctor' => ''],
                        ['department' => 'Ординација по Естетска Медицина', 'hours' => 'Пон до Петок 08:00 - 16:00', 'address' => 'Братство Единство бр. 41', 'phone' => '034-320-444', 'doctor' => ''],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'key' => 'contact',
                'title' => 'Контакт информации',
                'data' => [
                    'phone' => '034-360-444',
                    'email' => 'info@medica.mk',
                    'address' => 'ул. Вањо Китанов бр. 19, Струмица',
                    'facebook' => 'https://www.facebook.com/poliklinikamedika',
                    'instagram' => 'https://www.instagram.com/poliklinika_medika',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($sections as $sectionData) {
            Section::firstOrCreate(
                ['key' => $sectionData['key']],
                $sectionData
            );
        }

        // English translations for sections (by key, not by ID)
        $sectionEnTranslations = [
            'about_us' => [
                'title' => 'About Us',
                'data.title' => 'Your Health is Our Priority',
                'data.lead_text' => 'PZU Medica was founded in 1993 as the first private healthcare institution in the municipality of Strumica.',
                'data.description' => 'For 30 years "PZU Medica" has been working to preserve and improve the health of its patients. It started as a General Medicine Clinic and gradually developed, increasing its number of employees and areas of expertise.',
                'data.additional_text' => 'PZU Medica has two General Medicine clinics, a Psychiatric clinic, a Gynecological-obstetric clinic, an Occupational Medicine clinic, and a biochemical laboratory.',
            ],
            'stats' => [
                'title' => 'Statistics',
            ],
            'working_hours' => [
                'title' => 'Working Hours',
            ],
            'contact' => [
                'title' => 'Contact Information',
            ],
        ];

        foreach ($sectionEnTranslations as $key => $fields) {
            $section = Section::where('key', $key)->first();
            if (!$section) continue;

            foreach ($fields as $field => $value) {
                Translation::firstOrCreate(
                    [
                        'translatable_type' => 'App\\Models\\Section',
                        'translatable_id' => $section->id,
                        'locale' => 'en',
                        'field' => $field,
                    ],
                    ['value' => $value]
                );
            }
        }

        $this->command->info('Sections seeded successfully (skipped existing records).');
    }
}
