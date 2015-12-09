<?php
namespace GDGFoz\Transformers;

use League\Fractal;

class CategoryTransformer extends Fractal\TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'id'          => (int) $category->id,
            'name'        => $category->name,
            'description' => $category->description,
            'src'         => asset('uploads/categories/' . $category->path_image),
        ];
    }

}