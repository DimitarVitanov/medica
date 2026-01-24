<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Section;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@medica.mk',
            'password' => Hash::make('TeonixMedika1!@T'),
            'email_verified_at' => now(),
        ]);

        // Services
        $services = [
            [
                'title' => 'Општа Медицина',
                'slug' => 'opsta-medicina',
                'short_description' => 'Примарна здравствена заштита за целото семејство',
                'description' => '',
                'features' => ['Одржување на здравјето на здравите пациенти', 'Одржување на здравјето на болните пациенти', 'Превенција на хронични болести', 'Превенција на дегенеративни болести'],
                'color' => '#6B4C9A',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Психијатрија',
                'slug' => 'psihijatrija',
                'short_description' => 'Ментално здравје и психолошка поддршка',
                'description' => 'Ние во ПЗУ Медика ви нудиме место на ново разбирање и нова надеж. Менталната болест не е судбина, да ја претвориме заедно во шанса за нов, подобар почеток.',
                'features' => [],
                'color' => '#9C27B0',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Гинекологија',
                'slug' => 'ginekologija',
                'short_description' => 'Комплетна грижа за женското здравје',
                'description' => '',
                'features' => ['Гинеколошки преглед', '4D Ултразвук', 'Вагинален Ултразвук', 'ПАП тест', 'Микробиолошки брисеви', 'Надзор и следење на бременоста со 4D Ултразвук', 'Иследување во врска со стерилитет'],
                'color' => '#E91E63',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Лабораторија',
                'slug' => 'laboratorija',
                'short_description' => 'Биохемиски анализи и дијагностика',
                'description' => 'ПЗУ Медика располага со специјалистичка биохемиска лабораторија единствена од таков вид по опременост, кадар и простор во Југоисточниот дел на Македонија.',
                'features' => ['Собирање на 24-часовна урина', 'Спермограм', 'Одредување на железо', 'Одредување на липиден статус', 'Лабораториска анализа'],
                'color' => '#2196F3',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Трудова Медицина',
                'slug' => 'medicina-na-trud',
                'short_description' => 'Здравствени прегледи за вработување',
                'description' => 'Се издаваат Лекарски уверенија за вработување, патување, престој и школување во странство.',
                'features' => ['Дијагностицирање на професионални болести', 'Спирометрија', 'Peak Flow Meter - флоуметрија', 'Аудиометрија', 'Испитување острина на вид'],
                'color' => '#4CAF50',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Семејна Медицина',
                'slug' => 'semejna-medicina',
                'short_description' => 'Комплетна грижа за целото семејство',
                'description' => 'Семејната медицина обезбедува континуирана и сеопфатна здравствена заштита за сите членови на семејството.',
                'features' => ['Превентивни прегледи', 'Следење на хронични болести', 'Вакцинација', 'Здравствено советување'],
                'color' => '#00BCD4',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'Естетска Медицина',
                'slug' => 'estetska-medicina',
                'short_description' => 'Третмани за подмладување и убавина',
                'description' => 'Ви нудиме врвни и единствени третмани со ботокс, хијалуронска киселина и мезотерапија.',
                'features' => [],
                'color' => '#FF5722',
                'order' => 7,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Blogs
        $blogs = [
            [
                'title' => 'Ковид-19',
                'slug' => 'kovid-19',
                'author' => 'Д-р Тони Витанов',
                'category' => 'Здравје',
                'excerpt' => 'Коронавирусна болест (КОВИД-19) е заразна болест предизвикана од новооткриен коронавирус.',
                'content' => '<p>Коронавирусна болест (КОВИД-19) е заразна болест предизвикана од новооткриен коронавирус.</p><p>Повеќето луѓе заразени со вирусот КОВИД-19 ќе доживеат блага до умерена респираторна болест и ќе закрепнат без да бараат посебен третман.</p>',
                'image' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?w=600&h=400&fit=crop',
                'published_at' => '2020-09-07',
                'is_published' => true,
            ],
            [
                'title' => 'Мезотерапија',
                'slug' => 'mezoterapija',
                'author' => 'Д-р Вера Витанова',
                'category' => 'Естетика',
                'excerpt' => 'Мезотерапијата е медицинска техника на уфрлување на различни активни супстанции во слоевите на кожата.',
                'content' => '<p>Мезотерапијата е медицинска техника на уфрлување на различни активни супстанции во слоевите на кожата и поткожното масно ткиво.</p><p>MESOGLOW: 1900 ден. MESOLIFT: 4800 ден.</p>',
                'image' => 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=600&h=400&fit=crop',
                'published_at' => '2021-03-15',
                'is_published' => true,
            ],
            [
                'title' => 'Dexa-scan',
                'slug' => 'dexa-scan',
                'author' => 'Д-р Тони Витанов',
                'category' => 'Дијагностика',
                'excerpt' => 'Скенирање на коскената густина, исто така познатa како DEXA, помагаат да се разреши ризикот од кршење на коска.',
                'content' => '<p>DEXA - scan често се користи за да помогне во дијагностицирање на здравствени проблеми поврзани со коските, како што е остеопорозата.</p>',
                'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?w=600&h=400&fit=crop',
                'published_at' => '2022-05-20',
                'is_published' => true,
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::create($blog);
        }

        // Sliders
        $sliders = [
            [
                'title' => 'УЛТРАЗВУК',
                'subtitle' => 'Прецизна дијагностика за сите возрасти',
                'description' => 'Најсовремена ултразвучна дијагностика со искусен тим на специјалисти',
                'button_text' => 'Закажи термин',
                'button_link' => '/contact',
                'button2_text' => 'Повеќе информации',
                'button2_link' => '/services',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'ЛАБОРАТОРИЈА',
                'subtitle' => 'Брзи и точни резултати',
                'description' => 'Современа биохемиска лабораторија со сертифициран квалитет',
                'button_text' => 'Закажи термин',
                'button_link' => '/contact',
                'button2_text' => 'Повеќе информации',
                'button2_link' => '/services',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        // Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'ПЗУ Медика', 'group' => 'general'],
            ['key' => 'site_phone', 'value' => '034-360-444', 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'info@medica.mk', 'group' => 'general'],
            ['key' => 'site_address', 'value' => 'ул. Вањо Китанов бр. 19, Струмица', 'group' => 'general'],
            ['key' => 'working_hours', 'value' => 'Пон - Пет: 08:00 - 20:00', 'group' => 'general'],
            ['key' => 'facebook_url', 'value' => 'https://www.facebook.com/poliklinikamedika', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://www.instagram.com/poliklinika_medika', 'group' => 'social'],
            ['key' => 'meta_title', 'value' => 'ПЗУ Медика - Приватна Здравствена Установа', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'ПЗУ Медика - Приватна здравствена установа во Струмица. Општа медицина, гинекологија, психијатрија, естетска медицина, лабораторија и медицина на труд.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'медика, струмица, доктор, здравје, гинекологија, лабораторија, психијатрија', 'group' => 'seo'],
            ['key' => 'og_image', 'value' => '/images/logo.png', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        // Sections for homepage
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

        foreach ($sections as $section) {
            Section::create($section);
        }

        // English Translations for Services
        $serviceTranslations = [
            1 => [
                'title' => 'General Medicine',
                'short_description' => 'Primary healthcare for the whole family',
            ],
            2 => [
                'title' => 'Psychiatry',
                'short_description' => 'Mental health and psychological support',
            ],
            3 => [
                'title' => 'Gynecology',
                'short_description' => 'Complete care for women\'s health',
            ],
            4 => [
                'title' => 'Laboratory',
                'short_description' => 'Biochemical analysis and diagnostics',
            ],
            5 => [
                'title' => 'Occupational Medicine',
                'short_description' => 'Health examinations for employment',
            ],
            6 => [
                'title' => 'Family Medicine',
                'short_description' => 'Complete care for the whole family',
            ],
            7 => [
                'title' => 'Aesthetic Medicine',
                'short_description' => 'Rejuvenation and beauty treatments',
            ],
        ];

        foreach ($serviceTranslations as $id => $fields) {
            foreach ($fields as $field => $value) {
                Translation::create([
                    'translatable_type' => 'App\\Models\\Service',
                    'translatable_id' => $id,
                    'locale' => 'en',
                    'field' => $field,
                    'value' => $value,
                ]);
            }
        }

        // English Translations for Sliders
        $sliderTranslations = [
            1 => [
                'title' => 'ULTRASOUND',
                'subtitle' => 'Precise diagnostics for all ages',
                'description' => 'State-of-the-art ultrasound diagnostics with an experienced team of specialists',
                'button_text' => 'Book Appointment',
                'button2_text' => 'More Information',
            ],
            2 => [
                'title' => 'LABORATORY',
                'subtitle' => 'Fast and accurate results',
                'description' => 'Modern biochemical laboratory with certified quality',
                'button_text' => 'Book Appointment',
                'button2_text' => 'More Information',
            ],
        ];

        foreach ($sliderTranslations as $id => $fields) {
            foreach ($fields as $field => $value) {
                Translation::create([
                    'translatable_type' => 'App\\Models\\Slider',
                    'translatable_id' => $id,
                    'locale' => 'en',
                    'field' => $field,
                    'value' => $value,
                ]);
            }
        }

        // English Translations for Blogs
        $blogTranslations = [
            1 => [
                'title' => 'COVID-19',
                'excerpt' => 'Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.',
            ],
            2 => [
                'title' => 'Mesotherapy',
                'excerpt' => 'Mesotherapy is a medical technique of injecting various active substances into the skin layers.',
            ],
            3 => [
                'title' => 'DEXA Scan',
                'excerpt' => 'Bone density scanning, also known as DEXA, helps determine the risk of bone fractures.',
            ],
        ];

        foreach ($blogTranslations as $id => $fields) {
            foreach ($fields as $field => $value) {
                Translation::create([
                    'translatable_type' => 'App\\Models\\Blog',
                    'translatable_id' => $id,
                    'locale' => 'en',
                    'field' => $field,
                    'value' => $value,
                ]);
            }
        }

        // English Translations for Sections
        $sectionTranslations = [
            1 => [
                'title' => 'About Us',
            ],
            2 => [
                'title' => 'Statistics',
            ],
            3 => [
                'title' => 'Working Hours',
            ],
            4 => [
                'title' => 'Contact Information',
            ],
        ];

        foreach ($sectionTranslations as $id => $fields) {
            foreach ($fields as $field => $value) {
                Translation::create([
                    'translatable_type' => 'App\\Models\\Section',
                    'translatable_id' => $id,
                    'locale' => 'en',
                    'field' => $field,
                    'value' => $value,
                ]);
            }
        }
    }
}
