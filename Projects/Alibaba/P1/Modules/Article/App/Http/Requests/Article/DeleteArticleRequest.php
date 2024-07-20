<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class DeleteArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $roles=["super_admin","administrator"];
        return $this->user()->hasRoleArray($roles);
    }
}
