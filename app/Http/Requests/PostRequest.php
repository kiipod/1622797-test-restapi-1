<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Метод находит нужную новость для удаления и редактирования
     *
     * @return Post|null
     */
    public function findPost(): ?Post
    {
        return Post::find($this->route('id'));
    }

    /**
     * Проверка пользователя на права для удаления и обновления новости
     */
    public function authorize(): bool
    {
        if ($this->isMethod('patch')) {
            $comment = $this->findPost();
            return $this->user()->can('update', $comment);
        }

        if ($this->isMethod('delete')) {
            $comment = $this->findPost();
            return $this->user()->can('destroy', $comment);
        }

        return true;
    }

    /**
     * Правила валидации полей новости
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'between:50,400'
            ],
            'fragment' => [
                'required',
                'string',
                'between:50,100'
            ],
            'content' => [
                'required',
                'string',
                'between:100,10000'
            ]
        ];
    }
}
