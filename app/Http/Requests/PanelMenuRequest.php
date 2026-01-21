<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelMenuRequest extends FormRequest
{
    /**
     * Yetkilendirme kontrolü (Şu an herkese açık).
     */
    public function authorize()
    {
        return true; // Eğer yetkilendirme gerektiriyorsanız burada kontrol ekleyebilirsiniz.
    }

    /**
     * Form doğrulama kuralları.
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'statu' => 'required|boolean',
            'meta' => 'required|boolean',
            'editor' => 'required|boolean',
            'multiple_image' => 'required|boolean',
            'image' => 'required|boolean',
            'categories' => 'required|boolean',
            'extra' => 'nullable|json'
        ];
    }
}
