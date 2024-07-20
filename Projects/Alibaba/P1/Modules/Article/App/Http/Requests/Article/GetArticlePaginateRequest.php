<?php

namespace Modules\Article\App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class GetArticlePaginateRequest extends FormRequest
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
        $roles = ["administrator", "super_admin"];
        $isAdmin = $this->user()->hasRoleArray($roles);

        return $isAdmin;
    }
}
