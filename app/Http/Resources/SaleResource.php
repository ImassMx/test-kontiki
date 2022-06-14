<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \lluminate\Contracts\Support\Arrayable;

class SaleResource extends JsonResource
{

    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'description' => $this->when($this->description, function (){
                return $this->description;
            } ),
        ];
    }
}
