<?php

namespace GDGFoz\Todo\Task;

use GDGFoz\Core\Base\BaseRequest;

class TaskRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if( $this->getMethod() == 'PUT' ){
            $categoryId = $this->route('id');
        }else{
            $categoryId = $this->get('category_id');
        }

        if( $categoryId < 1 ){
            return false;
        }

        return \DB::table('categories_users')
                  ->where('category_id', $categoryId)
                  ->where('user_id', $this->getAuthUserId())
                  ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cass' => 'required'
        ];
    }

    public function all()
    {
        $data = parent::all();
        $data['s'] =2;
        $data['s2'] = $this->get('cass');
        return $data;
    }

}
