<?php

namespace App\Http\Requests;

class TodoRequest extends ApiRequest
{
    public function authorize()
    {
        if ($this->method() === 'POST') {
            return true;
        }
        $todo = $this->route('todo');
        return auth()->user()->id === $todo->user_id;
    }

    public function rules()
    {
        return [
            'todo' => 'required|string|max:255',
            'label' => 'nullable|string',
            'done' => 'nullable|boolean',
        ];
    }
}
