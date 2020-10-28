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

    public function getAdminByName(string $name)
    {
        return Admin::where('name', '=', $name)->first();
    }

    public function getAdminById($adminId)
    {
        return Admin::find($adminId);
    }
    public function deleteAdmin($adminId)
    {
        return Admin::where('id', '=', $adminId)->delete();
    }
    public function updateAdminInfo($adminId, $data)
    {
        return Admin::where('id', '=', $adminId)->update($data);
    }
}
