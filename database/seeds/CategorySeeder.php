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
        $data = [
            [
                'category' => 'Trabalho',
                'path_icon' => '/uploads/categories/trabalho.jpg',
                'path_thumb' => '/uploads/categories/trabalho-icon.png',
                'color' => '#3F51B5',
            ],
            [
                'category' => 'Lazer',
                'path_icon' => '/uploads/categories/lazer.jpg',
                'path_thumb' => '/uploads/categories/lazer-icon.png',
                'color' => '#43A047',
            ],
            [
                'category' => 'Família',
                'path_icon' => '/uploads/categories/familia.jpg',
                'path_thumb' => '/uploads/categories/familia-icon.png',
                'color' => '#E57373',
            ],
            [
                'category' => 'Estudos',
                'path_icon' => '/uploads/categories/estudos.jpg',
                'path_thumb' => '/uploads/categories/estudos-icon.png',
                'color' => '#9C27B0',
            ],
            [
                'category' => 'Viagem',
                'path_icon' => '/uploads/categories/viagem.jpg',
                'path_thumb' => '/uploads/categories/viagem-icon.png',
                'color' => '#FFC107',
            ],
            [
                'category' => 'Projetos pessoais',
                'path_icon' => '/uploads/categories/projetos-pessoais.jpg',
                'path_thumb' => '/uploads/categories/projetos-pessoais-icon.png',
                'color' => '#F06292',
            ],
        ];

        \GDGFoz\Category::insert($data);
    }
}
