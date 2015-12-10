<?php
namespace GDGFoz\Transformers;

use GDGFoz\Category;
use League\Fractal;

class CategoryTransformer extends Fractal\TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'id'          => (int) $category->id,
            'category'    => $category->category,
            'src'         => $category->path_img,
            'color'       => $category->color,
            'createdAt'   => (string) $category->created_at,
            'updatedAt'   => (string) $category->updated_at
            //'src'         => asset('uploads/categories/' . $category->path_img),
        ];
    }

}