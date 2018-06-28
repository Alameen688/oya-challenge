<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = 'success';
        $data = $this['users'];
        $message = '';
        if($data == null){
            $status = 'error';
            $message = "Oops! admin account is null"; 
        }
        
        return [
            'status' => $status,
            $this->mergeWhen($status == 'success', [
                'data' => $data,
            ]),
            $this->mergeWhen($status == 'error', [
                'message' => $message,
            ]),
        ];

    }
}
