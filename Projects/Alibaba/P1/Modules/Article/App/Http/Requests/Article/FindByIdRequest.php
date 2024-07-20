<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Article\App\Models\Article;

class FindByIdRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $id = $this->route('id');
        $article = Article::where("id", $id)->where("user_id", $this->user()->id)->exists();
        $roles = ["administrator", "super_admin"];
        $isAdmin = $this->user()->hasRoleArray($roles);
        return $isAdmin || $article;
    }
}
