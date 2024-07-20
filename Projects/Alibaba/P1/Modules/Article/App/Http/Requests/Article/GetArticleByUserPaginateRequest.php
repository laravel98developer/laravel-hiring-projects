<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class GetArticleByUserPaginateRequest extends FormRequest
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
        $isAdmin = $this->user()->hasRole("client");

        return $isAdmin;
    }
}
