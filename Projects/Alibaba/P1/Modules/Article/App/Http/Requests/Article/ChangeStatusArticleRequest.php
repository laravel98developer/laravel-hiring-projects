<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Article\App\Models\Article;

class ChangeStatusArticleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'publication_status' => 'required|in:draft,publish'
        ];
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
