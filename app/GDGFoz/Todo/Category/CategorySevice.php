<?php
/**
 * Created by PhpStorm.
 * User: valmir
 * Date: 17/01/16
 * Time: 00:39
 */

namespace GDGFoz\Todo\Category;


class CategorySevice
{

    /**
     * @var Category
     */
    protected $category;

    /**
     * CategorySevice constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function update($data)
    {

    }


}