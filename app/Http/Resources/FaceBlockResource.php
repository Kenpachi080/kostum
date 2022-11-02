<?php

namespace App\Http\Resources;

use App\Models\FaceBlock;
use Illuminate\Http\Resources\Json\JsonResource;

class FaceBlockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return FaceBlock::where('id', $this->resource)->first();
    }
}
