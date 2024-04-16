<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
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
            'patient_id' => $this->patient_id,
            'ward' => $this->ward,
            'admitted_at' => Carbon::parse($this->admitted_at)->toDateTimeString(),
            'discharged_at' => $this->discharged_at ? Carbon::parse($this->discharged_at)->toDateTimeString() : null,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),

            'patient' => new PatientResource($this->whenLoaded('patient')),
        ];
    }
}
