<?php

namespace Modules\Setting\Http\Requests;


use Illuminate\Validation\Rule;
use Modules\Support\Enums\MailEncryptionProtocols;
use Modules\Support\Locale;
use Modules\Support\TimeZone;
use Modules\Core\Http\Requests\Request;

class UpdateSettingRequest extends Request
{

    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'settings';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->name) {
            case 'general':
                return [
                    'supported_locales.*' => ['required', Rule::in(Locale::codes())],
                    'default_locale' => 'required|in_array:supported_locales.*',
                    'default_timezone' => ['required', Rule::in(TimeZone::all())],
                    "week_starts_at" => ["required", Rule::in(array_keys(__('days')))],
                    "week_ends_at" => ["required", Rule::in(array_keys(__('days'))), "different:week_starts_at"]
                ];
            case 'mail':
                return [
                    'mail_from_address' => 'nullable|email',
                    'mail_encryption' => ['nullable', Rule::in(MailEncryptionProtocols::values())],
                ];
            case 'maintenance':
                return [];
            case 'application':
                return [
                    'translatable.app_name' => 'required|max:100',
                    'app_phone_number' => 'required|numeric',
                    'app_email' => 'required|email',
                    'translatable.app_address' => 'required|max:255',
                ];
            default:
                return [];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
