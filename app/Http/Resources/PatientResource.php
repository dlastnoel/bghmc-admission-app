<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'suffix' => $this->suffix,
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->age,
            'address' => $this->address,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),

            'admissions' => AdmissionResource::collection($this->whenLoaded('admissions')),
            'admission_count' => $this->whenCounted('admissions')
        ];
    }
}
