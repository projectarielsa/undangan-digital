<?php

namespace App\Http\Requests\Customer;

use App\Models\InvitationTemplate;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Template
            'template_id' => ['required', 'exists:invitation_templates,id'],

            // Title (auto-generated from names)
            'title' => ['nullable', 'string', 'max:255'],

            // Couple Information
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'groom_father' => ['nullable', 'string', 'max:255'],
            'groom_mother' => ['nullable', 'string', 'max:255'],
            'bride_father' => ['nullable', 'string', 'max:255'],
            'bride_mother' => ['nullable', 'string', 'max:255'],
            'groom_instagram' => ['nullable', 'string', 'max:100'],
            'bride_instagram' => ['nullable', 'string', 'max:100'],

            // Event Details
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'event_time_start' => ['required'],
            'event_time_end' => ['nullable'],
            'event_venue' => ['required', 'string', 'max:255'],
            'event_address' => ['nullable', 'string', 'max:500'],
            'event_maps_url' => ['nullable', 'url', 'max:500'],

            // Reception (optional second event)
            'reception_date' => ['nullable', 'date', 'after_or_equal:event_date'],
            'reception_time_start' => ['nullable', 'date_format:H:i'],
            'reception_time_end' => ['nullable', 'date_format:H:i'],
            'reception_venue' => ['nullable', 'string', 'max:255'],
            'reception_address' => ['nullable', 'string', 'max:500'],

            // Content
            'opening_text' => ['nullable', 'string', 'max:1000'],
            'closing_text' => ['nullable', 'string', 'max:1000'],
            'dress_code' => ['nullable', 'string', 'max:255'],

            // Media
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'groom_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bride_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'music_file' => ['nullable', 'file', 'mimes:mp3,wav', 'max:10240'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'template_id.required' => 'Pilih template undangan.',
            'template_id.exists' => 'Template tidak ditemukan.',
            'groom_name.required' => 'Nama mempelai pria wajib diisi.',
            'bride_name.required' => 'Nama mempelai wanita wajib diisi.',
            'event_date.required' => 'Tanggal acara wajib diisi.',
            'event_date.after' => 'Tanggal acara harus setelah hari ini.',
            'event_time_start.required' => 'Waktu mulai acara wajib diisi.',
            'event_time_start.date_format' => 'Format waktu tidak valid (HH:MM).',
            'event_venue.required' => 'Tempat acara wajib diisi.',
            'event_maps_url.url' => 'URL Google Maps tidak valid.',
            'cover_image.image' => 'Cover harus berupa gambar.',
            'cover_image.max' => 'Ukuran cover maksimal 5MB.',
            'music_file.mimes' => 'File musik harus format MP3 atau WAV.',
            'music_file.max' => 'Ukuran musik maksimal 10MB.',
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
        // Auto-generate title from names
        if ($this->groom_name && $this->bride_name) {
            $this->merge([
                'title' => $this->groom_name . ' & ' . $this->bride_name,
            ]);
        }
    }
}
