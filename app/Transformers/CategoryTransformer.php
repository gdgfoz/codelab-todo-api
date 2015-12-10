<?php
namespace GDGFoz\Transformers;

use GDGFoz\Category;
use League\Fractal;

class CategoryTransformer extends Fractal\TransformerAbstract
{

    /**
     * @param Category $category
     * @return array
     *
     *  @SWG\Definition(
     *   definition="Category",
     *   required={"category", "src"},
     *   @SWG\Property(
     *             property="id",
     *             type="integer",
     *             format="int32"
     *   ),
     *   @SWG\Property(
     *             property="category",
     *             description="Nome da categoria",
     *             type="string"
     *   ),
     *   @SWG\Property(
     *             property="color",
     *             description="Cor em HEXADECIMAL da categoria",
     *             type="string"
     *   ),
     *   @SWG\Property(
     *             property="createdAt",
     *             description="Data de criação",
     *             type="dateTime"
     *   ),
     *   @SWG\Property(
     *             property="updatedAt",
     *             description="Data da ultima atualização",
     *             type="dateTime"
     *   ),
     *   @SWG\Property(
     *             property="src",
     *             description="URL do caminho absoluto da imagem que representa essa categoria",
     *             type="string"
     *   )
     * )
     */
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