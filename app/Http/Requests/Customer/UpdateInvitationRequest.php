<?php

namespace App\Http\Requests\Customer;

use App\Models\InvitationTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('invitation'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $invitation = $this->route('invitation');

        return [
            // Template
            'template_id' => ['sometimes', 'exists:invitation_templates,id'],

            // Couple Information
            'groom_name' => ['sometimes', 'string', 'max:255'],
            'bride_name' => ['sometimes', 'string', 'max:255'],
            'groom_father' => ['nullable', 'string', 'max:255'],
            'groom_mother' => ['nullable', 'string', 'max:255'],
            'bride_father' => ['nullable', 'string', 'max:255'],
            'bride_mother' => ['nullable', 'string', 'max:255'],
            'groom_instagram' => ['nullable', 'string', 'max:100'],
            'bride_instagram' => ['nullable', 'string', 'max:100'],

            // Event Details
            'event_date' => ['sometimes', 'date'],
            'event_time_start' => ['sometimes'],
            'event_time_end' => ['nullable'],
            'event_venue' => ['sometimes', 'string', 'max:255'],
            'event_address' => ['nullable', 'string', 'max:500'],
            'event_maps_url' => ['nullable', 'url', 'max:500'],

            // Content
            'opening_text' => ['nullable', 'string', 'max:1000'],
            'closing_text' => ['nullable', 'string', 'max:1000'],
            'dress_code' => ['nullable', 'string', 'max:255'],

            // Custom slug
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('invitations', 'slug')->ignore($invitation->id),
            ],

            // Media
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'music_file' => ['nullable', 'file', 'mimes:mp3,wav', 'max:10240'],

            // Gift/Bank Info
            'bank_accounts' => ['nullable', 'array', 'max:5'],
            'bank_accounts.*.bank_name' => ['nullable', 'string', 'max:100'],
            'bank_accounts.*.account_number' => ['nullable', 'string', 'max:50'],
            'bank_accounts.*.account_name' => ['nullable', 'string', 'max:255'],
            'qris_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gift_info' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'template_id.exists' => 'Template tidak ditemukan.',
            'groom_name.max' => 'Nama mempelai pria maksimal 255 karakter.',
            'bride_name.max' => 'Nama mempelai wanita maksimal 255 karakter.',
            'event_date.date' => 'Format tanggal tidak valid.',
            'event_time_start.date_format' => 'Format waktu tidak valid (HH:MM).',
            'event_maps_url.url' => 'URL Google Maps tidak valid.',
            'slug.unique' => 'Slug sudah digunakan oleh undangan lain.',
            'slug.alpha_dash' => 'Slug hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'cover_image.image' => 'Cover harus berupa gambar.',
            'cover_image.max' => 'Ukuran cover maksimal 5MB.',
            'music_file.mimes' => 'File musik harus format MP3 atau WAV.',
            'music_file.max' => 'Ukuran musik maksimal 10MB.',
            'qris_image.max' => 'Ukuran gambar QRIS maksimal 2MB.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->validatePremiumTemplate($validator);
        });
    }

    /**
     * Validate that user can use premium template.
     */
    protected function validatePremiumTemplate($validator): void
    {
        if ($this->template_id) {
            $template = InvitationTemplate::find($this->template_id);

            if ($template && $template->is_premium && !$this->user()->activeSubscription()) {
                $validator->errors()->add(
                    'template_id',
                    'Template premium hanya tersedia untuk pelanggan berbayar. Silakan berlangganan terlebih dahulu.'
                );
            }
        }
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-generate title if both names are provided
        if ($this->has('groom_name') && $this->has('bride_name')) {
            $this->merge([
                'title' => $this->groom_name . ' & ' . $this->bride_name,
            ]);
        }
    }
}
