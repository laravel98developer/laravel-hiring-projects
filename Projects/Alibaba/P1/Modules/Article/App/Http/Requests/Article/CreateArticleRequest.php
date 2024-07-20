<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'content' => 'required|string',
            'title' => 'required|string|max:255',
            'publication_date' => 'required|date_format:Y-m-d H:i:s',
            'publication_status' => 'required|in:draft,publish',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
        $roles=["expert","admin"];
        return $this->user()!=null && $this->user()->id === $request->input('client_id') || $this->user()->hasRoleArray($roles);
    }
}
