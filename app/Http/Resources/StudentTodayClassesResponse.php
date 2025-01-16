<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentTodayClassesResponse extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'session_title' => $this->class->name, // Class name as session title
            'start_time' => \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time)->format('g:i A'), // Format time
            'end_time' => \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time)->format('g:i A'), // Format time
            'venue' => $this->mode, // Mode: online or physical
            'lecturer' => $this->tutor,
            'date' => $this->day,
            'isToday' => $this->day === now()->format('Y-m-d'),
            'url' => $this->link, // Optional link
            'id' => (string)$this->id, // Convert ID to string
        ];
    }
}
