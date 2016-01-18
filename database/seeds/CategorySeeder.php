<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = new DateTime();

        $data = [
            [
                'category' => 'Trabalho',
                'path_icon' => '/uploads/categories/trabalho.jpg',
                'path_thumb' => '/uploads/categories/trabalho-icon.png',
                'color' => '#3F51B5',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'category' => 'Lazer',
                'path_icon' => '/uploads/categories/lazer.jpg',
                'path_thumb' => '/uploads/categories/lazer-icon.png',
                'color' => '#43A047',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'category' => 'Família',
                'path_icon' => '/uploads/categories/familia.jpg',
                'path_thumb' => '/uploads/categories/familia-icon.png',
                'color' => '#E57373',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'category' => 'Estudos',
                'path_icon' => '/uploads/categories/estudos.jpg',
                'path_thumb' => '/uploads/categories/estudos-icon.png',
                'color' => '#9C27B0',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'category' => 'Viagem',
                'path_icon' => '/uploads/categories/viagem.jpg',
                'path_thumb' => '/uploads/categories/viagem-icon.png',
                'color' => '#FFC107',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'category' => 'Projetos pessoais',
                'path_icon' => '/uploads/categories/projetos-pessoais.jpg',
                'path_thumb' => '/uploads/categories/projetos-pessoais-icon.png',
                'color' => '#F06292',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        \GDGFoz\Category::insert($data);
    }
}
