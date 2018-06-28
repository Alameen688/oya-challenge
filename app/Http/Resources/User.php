<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        if(isset($this['user'])){
            $data =  [
                'id' => $this['user']->id,
                'name' => $this['user']->name,
                'phone_number' => $this['user']->phone_number,
                //don't show business name for agents
                $this->mergeWhen(!is_null($this['user']->business_name), [
                    'business_name' => $this['user']->business_name,
                ]),
                'created_at' => $this['user']->created_at->toDateTimeString()
            ];
        }

        $message = '';
        if(isset($this['message'])){
            $message = $this['message'];
        }

        return [
            'status' => $this['status'],
            $this->mergeWhen($this['status'] == 'success', [
                'data' => $data,
            ]),
            $this->mergeWhen($this['status'] == 'error', [
                'message' => $message,
            ])
        ];
    }
}
