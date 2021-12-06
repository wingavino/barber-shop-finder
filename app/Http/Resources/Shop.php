<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Shop extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      // return [
      //   'id' => $this->id,
      //   'name' => $this->name,
      //   'owner_name' => $this->owner_name,
      //   'lat' => $this->lat,
      //   'lng' => $this->lng,
      // ];
        return parent::toArray($request);
    }
}
