<?php


namespace Modules\Base\Repositories\Company;


use Modules\Base\Entities\Company\CompanyMedia;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Base\Contracts\Company\MediaRepository as ContractsMediaRepository;

class MediaRepository extends BaseRepository implements ContractsMediaRepository
{
    public function model()
    {
        return CompanyMedia::class;
    }
}
