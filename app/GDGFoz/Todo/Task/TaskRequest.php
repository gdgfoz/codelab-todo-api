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
//        if( $this->getMethod() == 'PUT' ){
//            $categoryId = $this->route('id');
//        }else{
//            $categoryId = $this->get('category_id');
//        }

        $categoryId = $this->get('category_id');

        if( $categoryId < 1 ){
            return true;
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
            'name' => 'required',
            'description' => 'max:245',
            'category_id' => 'required',
            'status' => 'boolean',
        ];
    }

    public function all()
    {
        $data = parent::all();
        $data['status'] = boolval($this->get('status'));
        return $data;
    }

    public function save()
    {
        $task = new Task();
        $task->fill($this->all());
        $task->user_id = $this->getAuthUserId();
        $task->finalized_at = ($this->get('status'))? new \DateTime() : null;

        if( ! $task->save() ){
            $this->failedSaveModel();
        }

        return $task;
    }

    public function update(Task $task)
    {
        $task->fill($this->all());
        $task->user_id = $this->getAuthUserId();
        $task->finalized_at = ($this->get('status'))? new \DateTime() : null;

        if( ! $task->update() ){
            $this->failedUpdateModel();
        }

        return $task;
    }

}
