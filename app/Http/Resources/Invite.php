<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Invite extends JsonResource
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
        $data = $this['invites'];
        $message = '';
        if($data == null){
            $status = 'error';
            $message = "Oops! invites is null"; 
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
