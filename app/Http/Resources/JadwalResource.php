<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JadwalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'jam_mulai' => $this->jam_mulai,
            'jam_berhenti' => $this->jam_berhenti,
            'user' => $this->whenLoaded('user', function(){
                return [
                    'id' => $this->user->id,
                    'nama' => $this->user->nama
                ];
            }),
            'lapangan' => $this->whenLoaded('lapangan', function(){
                return [
                    'id' => $this->lapangan->id,
                    'nama' => $this->lapangan->nama
                ];
            })
        ];
    }
}
