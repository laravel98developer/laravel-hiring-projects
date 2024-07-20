<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Article\App\Models\Article;

class UpdateArticleRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'content' => 'string',
            'title' => 'string|max:255',
            'publication_date' => 'date_format:Y-m-d H:i:s',
            'publication_status' => 'in:draft,publish'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        $id = $this->route('id');
        $article = Article::where("id", $id)->where("user_id", $this->user()->id)->exists();
        $roles = ["administrator", "super_admin"];
        $isAdmin = $this->user()->hasRoleArray($roles);
        return $isAdmin || $article;
    }
}
