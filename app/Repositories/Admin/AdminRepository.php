<?php


namespace App\Repositories\Admin;


use App\Models\Admin;

class AdminRepository
{
    public function getAdminList()
    {
        return Admin::orderby('id', 'desc')
            ->paginate();
    }
}
