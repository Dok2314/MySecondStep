<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'        => $this->title,
            'release_date' => $this->release_date->format('d.m.y'),
            'meta'         => $this->when($this->title == 'Dr.', function () {
                return 1;
            }, function () {
                return 2;
            })
        ];
    }
}
