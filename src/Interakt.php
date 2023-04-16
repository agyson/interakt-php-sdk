<?php

namespace Agyson\InteraktPhpSdk;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Interakt
{
  protected string $api_key;

  public function __construct(string $api_key)
  {
    $this->api_key = $api_key;
  }

  public function track_user(
    string $userId = null,
    string $fullPhoneNumber = null,
    string $phoneNumber = null,
    string $countryCode = null,
    array $traits = [],
    array $tags = []
  ): array
  {
    $body = [
      'traits' => $traits,
      'tags' => $tags,
    ];

    if($userId != null) {
      $body['userId'] = $userId;
    }

    if($fullPhoneNumber != null) {
      $body['fullPhoneNumber'] = $fullPhoneNumber;
    }else{
      $body['phoneNumber'] = $phoneNumber;
      $bodu['countryCode'] = $countryCode;
    }

    return $this->send(
      'track_user',
      $body = $body
    );
  }

  public function track_event(
    string $userId = null,
    string $fullPhoneNumber = null,
    string $phoneNumber = null,
    string $countryCode = null,
    string $event = null,
    array $traits = []
  ): array
  {
    $body = [
      'event' => $event,
      'traits' => $traits,
    ];

    if ($userId != null) {
      $body['userId'] = $userId;
    }

    if($fullPhoneNumber != null){
      $body['fullPhoneNumber'] = $fullPhoneNumber;
    }else{
      $body['phoneNumber'] = $phoneNumber;
      $bodu['countryCode'] = $countryCode;
    }

    return $this->send(
      'track_user',
      $body = $body
    );
  }

  public function get_users(
    int $offset = 0,
    int $limit = 100,
    string $filter_start_date = '2010-01-01',
    string $filter_end_date = null
  ): array
  {
    $body = [
      'filters' => [
        [
          'trait' => 'created_at_utc',
          'op' => 'gt',
          'val' => Carbon::parse($filter_start_date)
        ]
      ],
    ];

    if($filter_end_date != null){
      $body['filters'][] = [
          'trait' => 'created_at_utc',
          'op' => 'lt',
          'supr_op' => 'and',
          'val' => Carbon::parse($filter_end_date)
      ];
    }

    return $this->send(
      'customer',
      $parameter = [
        'offset' => $offset,
        'limit' => $limit,
      ],
      $body = $body
    );
  }

  public function send_template(
    string $fullPhoneNumber = null,
    string $phoneNumber = null,
    string $countryCode = null,
    string $callbackData = null,
    string $templateName = null,
    string $templateLanguageCode = null,
    array $headerValues = [],
    array $bodyValues = [],
    array $buttonValues = [],
  )
  : array
  {
    $body = [
      'callbackData' => $callbackData,
      'type' => 'Template',
      'template' => [
        'name' => $templateName,
        'languageCode' => $templateLanguageCode,
      ]
    ];

    if ($fullPhoneNumber != null) {
      $body['fullPhoneNumber'] = $fullPhoneNumber;
    } else {
      $body['phoneNumber'] = $phoneNumber;
      $bodu['countryCode'] = $countryCode;
    }

    if(count($headerValues)){
      $body['template']['headerValues'] = $headerValues;
    }

    if(count($bodyValues)){
      $body['template']['bodyValues'] = $bodyValues;
    }

    if(count($buttonValues)){
      $body['template']['buttonValues'] = $buttonValues;
    }

    return $this->send(
      'template',
      $body = $body
    );
  }

  private function send(string $api_type = null, array $parameter = [], array $body = []): array{
    $response = Http::withHeaders([
      'Authorization' => 'Basic ' . $this->api_key
    ])
    ->withBody(json_encode($body), 'application/json')
    ->post($this->get_url($api_type), $parameter);

    return json_decode($response, true);
  }

  private function get_url(string $api_type): string {
    $url = 'https://api.interakt.ai/v1/public/';

    switch ($api_type) {
      case 'track_user':
        return $url . 'track/users/';
        break;
      case 'tract_event':
        return $url . 'track/events/';
        break;
      case 'customer':
        return $url . 'apis/users/';
        break;
      case 'template':
        return $url . 'message/';
        break;
      default:
        return $url;
        break;
    }
  }
}
