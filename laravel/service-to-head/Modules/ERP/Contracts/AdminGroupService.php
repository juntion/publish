<?php


namespace Modules\ERP\Contracts;


interface AdminGroupService
{
    public function getAdminGroup($id);

    public function getSeamGroupAdmins($id);
}
