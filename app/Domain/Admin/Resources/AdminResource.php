<?php

namespace App\Domain\Admin\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        $resources =  [
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('j F Y H:i'),
        ];

        if ($request->jwt_token) {
            $resources['jwt_token'] = $request->jwt_token;
        }

        return $resources;
    }
}
