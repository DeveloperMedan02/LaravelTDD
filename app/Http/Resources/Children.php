<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Children extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'employee_id' => (int) $this->employee_id,
            'name' => $this->name,
            'age' => $this->age
        ];
    }
}
