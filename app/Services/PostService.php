<?php

namespace App\Services;

use Illuminate\Http\Request;

class PostService
{
    public function handleStatus(array $data, Request $request): array
    {
        if ($data['status'] == 'draft') {
            $data['publish_date'] = null;
        } elseif ($data['status'] == 'published') {
            $data['publish_date'] = now();
        } elseif ($data['status'] == 'scheduled') {
            $data['publish_date'] = $request->input('publish_date');
        }

        return $data;
    }
}
