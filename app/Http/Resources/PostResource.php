<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this);
        return [
            'id' => $this->id,
            'custom_id' => $this->custom_id,
            'title' => $this->title,
            'name' => $this->name,
            'description' => $this->description,
            'publish_date' => $this->publish_date,
            'category_id' => $this->category_id,
            'category_name' => $this->category ? $this->category->title : "",
            'is_active' => $this->is_active,
        ];
    }
}
