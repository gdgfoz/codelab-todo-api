<?php

namespace GDGFoz\Todo\Category;

use GDGFoz\Core\Base\BaseRequest;

class CategoryRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if( $this->getMethod() == 'PUT' ) {

            $categoryId = $this->route('id');

            return \DB::table('categories_users')
                        ->where('category_id', $categoryId)
                        ->where('user_id', $this->getAuthUserId())
                        ->exists();
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch( $this->getMethod() )
        {
            case 'PUT':
                return [
                    'category' => 'required',
                    'color'    => 'required|html_color'
                ];


            case 'POST':
                return  [
                    'category' => 'required',
                    'color'    => 'required|html_color'
                ];
        }

    }

    public function save()
    {

        $this->validateUniqueNameCategory( $this->get('category') );

        $user = $this->getAuthUser();

        $category = new Category();

        $category->fill($this->all());

        if( ! $user->categories()->save($category) ){
            $this->failedSaveModel();
        }

        return $category;
    }

    public function update(Category $category)
    {

        $this->validateUniqueNameCategory( $this->get('category'), $category->id );

        $category->fill($this->all());

        if( ! $category->update() ){
            $this->failedUpdateModel();
        }

        return $category;
    }

    protected function validateUniqueNameCategory($categoryName, $ignoreId = 0)
    {
        $exists = \DB::table('categories')
                    ->join('categories_users', 'categories_users.category_id', '=', 'categories.id')
                    ->where('categories_users.user_id', $this->getAuthUserId())
                    ->where('categories.id', '<>', $ignoreId)
                    ->where('categories.category', $categoryName)
                    ->exists();

        if($exists)
            $this->failedCustomValidate( ['category' => 'Já existe uma categoria com este nome em sua lista.'] );
    }
}
