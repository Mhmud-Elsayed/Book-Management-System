<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $authors = [
            [
                'email' => 'ahmed.mostafa@example.com',
                'name_en' => 'Ahmed Mostafa',
                'name_ar' => 'أحمد مصطفى',
                'bio_en' => 'Renowned Egyptian author known for his contemporary novels exploring modern Arab society.',
                'bio_ar' => 'كاتب مصري مشهور معروف برواياته المعاصرة التي تستكشف المجتمع العربي الحديث.'
            ],
            [
                'email' => 'naguib.mahfouz@example.com',
                'name_en' => 'Naguib Mahfouz',
                'name_ar' => 'نجيب محفوظ',
                'bio_en' => 'Nobel Prize-winning Egyptian writer, one of the first contemporary writers of Arabic literature.',
                'bio_ar' => 'كاتب مصري حائز على جائزة نوبل، أحد أول الكتاب المعاصرين في الأدب العربي.'
            ],
            [
                'email' => 'khaled.hosseini@example.com',
                'name_en' => 'Khaled Hosseini',
                'name_ar' => 'خالد حسيني',
                'bio_en' => 'Afghan-American novelist and physician, known for "The Kite Runner".',
                'bio_ar' => 'روائي وطبيب أفغاني أمريكي، معروف بروايته "عداء الطائرة الورقية".'
            ],
            [
                'email' => 'paulo.coelho@example.com',
                'name_en' => 'Paulo Coelho',
                'name_ar' => 'باولو كويلو',
                'bio_en' => 'Brazilian lyricist and novelist, author of "The Alchemist".',
                'bio_ar' => 'شاعر وروائي برازيلي، مؤلف كتاب "الخيميائي".'
            ],
            [
                'email' => 'nawal.el.saadawi@example.com',
                'name_en' => 'Nawal El Saadawi',
                'name_ar' => 'نوال السعداوي',
                'bio_en' => 'Egyptian feminist writer, activist and physician.',
                'bio_ar' => 'كاتبة نسوية مصرية، ناشطة وطبيبة.'
            ],
            [
                'email' => 'taha.hussein@example.com',
                'name_en' => 'Taha Hussein',
                'name_ar' => 'طه حسين',
                'bio_en' => 'Egyptian writer and intellectual, known as the "Dean of Arabic Literature".',
                'bio_ar' => 'كاتب ومفكر مصري، معروف باسم "عميد الأدب العربي".'
            ],
            [
                'email' => 'ghassan.kanafani@example.com',
                'name_en' => 'Ghassan Kanafani',
                'name_ar' => 'غسان كنفاني',
                'bio_en' => 'Palestinian author and leading member of the Popular Front for the Liberation of Palestine.',
                'bio_ar' => 'كاتب فلسطيني وعضو قيادي في الجبهة الشعبية لتحرير فلسطين.'
            ],
            [
                'email' => 'j.k.rowling@example.com',
                'name_en' => 'J.K. Rowling',
                'name_ar' => 'ج. ك. رولينج',
                'bio_en' => 'British author, best known for the Harry Potter fantasy series.',
                'bio_ar' => 'كاتبة بريطانية، اشتهرت بسلسلة هاري بوتر الخيالية.'
            ]
        ];
        
        foreach ($authors as $author) {
            Author::create($author);
        }

        $this->command->info('Authors seeded successfully!');

    }
}
