<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $authors = Author::all();
        
        if ($authors->isEmpty()) {
            $this->command->warn('No authors found. Please run AuthorSeeder first.');
            return;
        }
         $books = [
            [
                'title_en' => 'The Alchemist',
                'title_ar' => 'الخيميائي',
                'description_en' => 'A philosophical book that follows a young Andalusian shepherd named Santiago on his journey to the pyramids of Egypt.',
                'description_ar' => 'كتاب فلسفي يتابع رحلة راعي أندلسي شاب يدعى سانتياغو إلى أهرامات مصر.',
                'price' => 89.99,
                'author_id' => $authors->where('email', 'paulo.coelho@example.com')->first()->id,
            ],
            [
                'title_en' => 'The Kite Runner',
                'title_ar' => 'عداء الطائرة الورقية',
                'description_en' => 'A powerful story of friendship, betrayal, and redemption set in Afghanistan.',
                'description_ar' => 'قصة قوية عن الصداقة والخيانة والخلاص تدور أحداثها في أفغانستان.',
                'price' => 75.50,
                'author_id' => $authors->where('email', 'khaled.hosseini@example.com')->first()->id,
            ],
            [
                'title_en' => 'Palace Walk',
                'title_ar' => 'بين القصرين',
                'description_en' => 'The first novel in the Cairo Trilogy, depicting life in Cairo during World War I.',
                'description_ar' => 'الرواية الأولى في الثلاثية القاهرية، تصور الحياة في القاهرة خلال الحرب العالمية الأولى.',
                'price' => 95.00,
                'author_id' => $authors->where('email', 'naguib.mahfouz@example.com')->first()->id,
            ],
            [
                'title_en' => 'Harry Potter and the Philosopher\'s Stone',
                'title_ar' => 'هاري بوتر وحجر الفيلسوف',
                'description_en' => 'The first novel in the Harry Potter series about a young wizard discovering his magical heritage.',
                'description_ar' => 'الرواية الأولى في سلسلة هاري بوتر عن ساحر شاب يكتشف تراثه السحري.',
                'price' => 120.00,
                'author_id' => $authors->where('email', 'j.k.rowling@example.com')->first()->id,
            ],
            [
                'title_en' => 'Women and Sex',
                'title_ar' => 'المرأة والجنس',
                'description_en' => 'A groundbreaking work on women\'s issues in the Arab world.',
                'description_ar' => 'عمل رائد في قضايا المرأة في العالم العربي.',
                'price' => 65.75,
                'author_id' => $authors->where('email', 'nawal.el.saadawi@example.com')->first()->id,
            ],
            [
                'title_en' => 'The Days',
                'title_ar' => 'الأيام',
                'description_en' => 'An autobiographical novel by Taha Hussein about his life and struggles with blindness.',
                'description_ar' => 'رواية سيرة ذاتية لطه حسين عن حياته وصعوباته مع العمى.',
                'price' => 80.25,
                'author_id' => $authors->where('email', 'taha.hussein@example.com')->first()->id,
            ],
            [
                'title_en' => 'Men in the Sun',
                'title_ar' => 'رجال في الشمس',
                'description_en' => 'A powerful novella about Palestinian refugees trying to find work in Kuwait.',
                'description_ar' => 'رواية قوية عن اللاجئين الفلسطينيين الذين يحاولون العثور على عمل في الكويت.',
                'price' => 70.00,
                'author_id' => $authors->where('email', 'ghassan.kanafani@example.com')->first()->id,
            ],
            [
                'title_en' => 'Modern Echoes',
                'title_ar' => 'صدى معاصر',
                'description_en' => 'A collection of contemporary stories exploring modern Arab identity.',
                'description_ar' => 'مجموعة من القصص المعاصرة تستكشف الهوية العربية الحديثة.',
                'price' => 85.50,
                'author_id' => $authors->where('email', 'ahmed.mostafa@example.com')->first()->id,
            ],
            [
                'title_en' => 'The Return',
                'title_ar' => 'العودة',
                'description_en' => 'A novel about displacement and the search for home in the modern world.',
                'description_ar' => 'رواية عن التشرد والبحث عن الوطن في العالم الحديث.',
                'price' => 78.99,
                'author_id' => $authors->where('email', 'ahmed.mostafa@example.com')->first()->id,
            ],
            [
                'title_en' => 'Desert Winds',
                'title_ar' => 'رياح الصحراء',
                'description_en' => 'A story of love and tradition in the Arabian desert.',
                'description_ar' => 'قصة حب وتقاليد في صحراء الجزيرة العربية.',
                'price' => 92.00,
                'author_id' => $authors->where('email', 'ahmed.mostafa@example.com')->first()->id,
            ]
        ];
        
        foreach ($books as $book) {
            Book::create($book);
        }

        $this->command->info('Books seeded successfully!');
        $this->command->info('Total books created: ' . count($books));

    }
}
