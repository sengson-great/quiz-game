<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Difficulty 1 (very easy)
            [
                'question'   => 'What color is the sky on a clear day?',
                'option_a'   => 'Blue',
                'option_b'   => 'Green',
                'option_c'   => 'Red',
                'option_d'   => 'Yellow',
                'correct'    => 'A',
                'difficulty' => 1,
                'order'      => 1,
            ],
            [
                'question'   => 'How many legs does a spider have?',
                'option_a'   => '6',
                'option_b'   => '8',
                'option_c'   => '10',
                'option_d'   => '4',
                'correct'    => 'B',
                'difficulty' => 2,
                'order'      => 2,
            ],
            [
                'question'   => 'Which planet is known as the Red Planet?',
                'option_a'   => 'Venus',
                'option_b'   => 'Mars',
                'option_c'   => 'Jupiter',
                'option_d'   => 'Saturn',
                'correct'    => 'B',
                'difficulty' => 3,
                'order'      => 3,
            ],

            // Difficulty ~5
            [
                'question'   => 'In which layer of Earth\'s atmosphere does the ozone layer lie?',
                'option_a'   => 'Troposphere',
                'option_b'   => 'Stratosphere',
                'option_c'   => 'Mesosphere',
                'option_d'   => 'Thermosphere',
                'correct'    => 'B',
                'difficulty' => 5,
                'order'      => 5,
            ],
            [
                'question'   => 'Which of these animals is a marsupial?',
                'option_a'   => 'Kangaroo',
                'option_b'   => 'Elephant',
                'option_c'   => 'Giraffe',
                'option_d'   => 'Lion',
                'correct'    => 'A',
                'difficulty' => 5,
                'order'      => 6,
            ],

            // Mid-game (~8–10)
            [
                'question'   => 'Which gas makes up the majority of Earth\'s atmosphere?',
                'option_a'   => 'Oxygen',
                'option_b'   => 'Carbon Dioxide',
                'option_c'   => 'Nitrogen',
                'option_d'   => 'Argon',
                'correct'    => 'C',
                'difficulty' => 8,
                'order'      => 8,
            ],
            [
                'question'   => 'Who painted the Mona Lisa?',
                'option_a'   => 'Vincent van Gogh',
                'option_b'   => 'Pablo Picasso',
                'option_c'   => 'Leonardo da Vinci',
                'option_d'   => 'Michelangelo',
                'correct'    => 'C',
                'difficulty' => 9,
                'order'      => 9,
            ],

            // Harder questions (12–15)
            [
                'question'   => 'The Earth is approximately how many miles away from the Sun?',
                'option_a'   => '9.3 million',
                'option_b'   => '39 million',
                'option_c'   => '93 million',
                'option_d'   => '193 million',
                'correct'    => 'C',
                'difficulty' => 12,
                'order'      => 12,
            ],
            [
                'question'   => 'Which insect shorted out an early supercomputer and inspired the term "computer bug"?',
                'option_a'   => 'Moth',
                'option_b'   => 'Roach',
                'option_c'   => 'Fly',
                'option_d'   => 'Japanese beetle',
                'correct'    => 'A',
                'difficulty' => 13,
                'order'      => 13,
            ],
            [
                'question'   => 'Which landlocked country is entirely contained within another country?',
                'option_a'   => 'Lesotho',
                'option_b'   => 'San Marino',
                'option_c'   => 'Vatican City',
                'option_d'   => 'Both B and C',
                'correct'    => 'A', // Lesotho inside South Africa
                'difficulty' => 14,
                'order'      => 14,
            ],
            [
                'question'   => 'What is the only mammal capable of true flight?',
                'option_a'   => 'Flying squirrel',
                'option_b'   => 'Bat',
                'option_c'   => 'Pterodactyl',
                'option_d'   => 'Colugo',
                'correct'    => 'B',
                'difficulty' => 15,
                'order'      => 15,
            ],
        ];

        foreach ($questions as $q) {
            DB::table('questions')->updateOrInsert(
                ['question' => $q['question']],
                $q
            );
        }

        $this->command->info('Questions seeded successfully! (' . count($questions) . ' questions)');
    }
}