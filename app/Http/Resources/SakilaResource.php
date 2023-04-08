<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SakilaResource extends JsonResource
{
    // define properti
    public $status;
    public $message;
    public $resource;

    /**
     * __construct
     *
     * @param  mixed $status
     * @param  mixed $message
     * @param  mixed $resource
     * @return void
     */
    public function __construct($status, $code, $message, $resource)
    {
        parent::__construct($resource);
        $this->code = $code;
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'success'   => $this->status,
            'code'      => $this->code,
            'message'   => $this->message,
            'data'      => $this->resource
        ];
    }
}
