<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\RssFeedIntervalType;
use Illuminate\Validation\Rule;
use App\Rules\ArrayCheck;
use Log;

class RssFeedFormRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function start() : array {

        return [
            "rss_feed_link"                   => ["required", "url"],
            "refresh_interval"                => ["required", "numeric"],
            "interval_type"                   => ["required", Rule::enum(RssFeedIntervalType::class)],
            "session_started_at"              => ["required", "date_format:Y-m-d H:i:s"],
            "rss_feed_details"                => ["required", "array", new ArrayCheck],
            "rss_feed_details.*.title"        => ["required", "string"],
            "rss_feed_details.*.link"         => [ "required", "url:http,https"],
            "rss_feed_details.*.published_at" => ["required", "date_format:Y-m-d H:i:s"]
        ];
    }

    public function stop() : array {
        return ["session_ended_at" => ["required", "date_format:Y-m-d H:i:s"]];
    }

    public function refetch() : array {
        return [
            "rss_feed_id"                     => ["required", "numeric"],
            "rss_feed_details"                => ["required", "array", new ArrayCheck],
            "rss_feed_details.*.title"        => ["required", "string"],
            "rss_feed_details.*.link"         => [ "required", "url:http,https"],
            "rss_feed_details.*.published_at" => ["required", "date_format:Y-m-d H:i:s"]
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
