<?php


namespace Modules\Base\Repositories\Company;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Base\Entities\Company\Company;
use Modules\Base\Entities\Company\CompanyAddress;
use Modules\Base\Repositories\Company\Traits\UploadTrait;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Base\Contracts\Company\AddressRepository as ContractsAddressRepository;

class AddressRepository extends BaseRepository implements ContractsAddressRepository
{

    use UploadTrait;

    public function model()
    {
        return CompanyAddress::class;
    }

    public function getStatusLogs(CompanyAddress $companyAddress)
    {
        return $companyAddress->logs();
    }

    public function updateStatus(CompanyAddress $companyAddress)
    {
        $status = $companyAddress->status == 1 ? 0 : 1;
        $companyAddress->update([
            'status' => $status
        ]);
        return true;
    }

    public function store(Company $company, array $addressData)
    {
        $address = $company->address()->create($addressData);
        return $address;
    }

    /**
     * 更新地址信息
     * @param  Request  $request
     * @param  CompanyAddress  $address
     * @param  int  $type
     * @return CompanyAddress
     */
    public function updateAddress(array $addressData, CompanyAddress $address)
    {
        $address->update($addressData);
        return $address;
    }


    public function storeContacts(CompanyAddress $address, $contact)
    {
        $contact['uuid'] = Str::uuid()->getHex()->toString();
        $address->allContacts()->create($contact);
    }

    public function deleteContacts(CompanyAddress $address, array $uuids)
    {
        if(!empty($uuids)){
            $address->allContacts()->whereNotIn('uuid', $uuids)->delete();
        } else {
            $address->allContacts()->delete();
        }
    }

    /**
     * 更新联系人信息
     * @param  CompanyAddress  $address
     * @param  Request  $request
     */
    public function updateContacts(CompanyAddress $address, array $contact = [])
    {
        if(isset($contact['uuid'])) {
            if($contact['type'] == 1) {
                $old = $address->contacts()->find($contact['uuid']);
            } else {
                $old = $address->foreignContacts()->find($contact['uuid']);
            }
            if(!is_null($old)){
                $old->update($contact);
            }
        }

    }
}
