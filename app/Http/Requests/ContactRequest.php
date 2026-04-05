<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả users gửi form liên hệ
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|min:10|max:11|regex:/^[0-9]{10,11}$/',
            'subject' => 'required|string|max:255|min:3',
            'message' => 'required|string|min:5|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'name.min' => 'Họ và tên phải có ít nhất 2 ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.max' => 'Địa chỉ email không được vượt quá 255 ký tự.',
            
            'phone.min' => 'Số điện thoại phải có ít nhất 10 số.',
            'phone.max' => 'Số điện thoại không được vượt quá 11 số.',
            'phone.regex' => 'Số điện thoại chỉ được chứa các chữ số (0-9).',
            
            'subject.required' => 'Vui lòng nhập chủ đề.',
            'subject.min' => 'Chủ đề phải có ít nhất 3 ký tự.',
            'subject.max' => 'Chủ đề không được vượt quá 255 ký tự.',
            
            'message.required' => 'Vui lòng nhập nội dung tin nhắn.',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 5 ký tự.',
            'message.max' => 'Nội dung tin nhắn không được vượt quá 1000 ký tự.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'họ tên',
            'email' => 'email',
            'phone' => 'số điện thoại',
            'subject' => 'chủ đề',
            'message' => 'tin nhắn',
        ];
    }
}
