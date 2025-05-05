<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function wantsJson()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'nurse_id' => 'nullable|exists:users,id',
            'appointment_id' => 'nullable|exists:appointments,id',

            'temperature' => 'nullable|numeric',
            'temperature_unit' => 'nullable|string',

            'blood_pressure' => 'nullable|string',
            'blood_pressure_unit' => 'nullable|string',

            'heart_rate' => 'nullable|integer',
            'heart_rate_unit' => 'nullable|string',

            'respiratory_rate' => 'nullable|integer',
            'respiratory_rate_unit' => 'nullable|string',

            'oxygen_saturation' => 'nullable|integer',
            'oxygen_saturation_unit' => 'nullable|string',

            'height' => 'nullable|numeric',
            'height_unit' => 'nullable|string',

            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string',

            'bmi' => 'nullable|numeric',
            'bmi_unit' => 'nullable|string',

            'blood_sugar' => 'nullable|numeric',
            'blood_sugar_unit' => 'nullable|string',

            'pain_score' => 'nullable|integer|min:0|max:10',
            'notes' => 'nullable|string',

            'tenant_id' => 'nullable|string',
        ];
    }
}
