<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UserEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $available_joined_date = Carbon::parse($this->date_of_birth)
            ->addYears(18)
            ->subDays(1);
        $isWeekend = Carbon::parse($this->joined_date)->isWeekend();
        return [
            //

            "first_name" => "required|max:128",
            "last_name" => 'required|regex:/^[a-zA-Z\s]*$/|max:128',
            "date_of_birth" => 'required|date_format:"Y-m-d"|before:-18 years',
            "gender" => "required",
            "is_admin" => "required",
            "password" => "required",
            'email' => 'required|email|unique:users',
        ];
    }
    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "required" => ":Attribute is required!",
            "date_of_birth.date_format" => "Invalid date",
            "date_of_birth.before:-18 years" => "User must be >= 18 years old",
        ];
    }
}
