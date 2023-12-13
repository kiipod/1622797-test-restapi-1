<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Метод определяет имеет ли пользователь право сделать запрос
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Метод проводит валидацию полей при входе на сайт
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'email'
            ],
            'password' => [
                'required',
                'string'
            ]
        ];
    }
}
