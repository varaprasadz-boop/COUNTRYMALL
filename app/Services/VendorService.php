<?php

namespace App\Services;

use App\Traits\FileManagerTrait;
use Illuminate\Support\Str;

class VendorService
{
    use FileManagerTrait;
    /**
     * @param string $email
     * @param string $password
     * @param string|bool|null $rememberToken
     * @return bool
     */
    public function isLoginSuccessful(string $email, string $password, string|null|bool $rememberToken): bool
    {
        if (auth('seller')->attempt(['email' => $email, 'password' => $password], $rememberToken)) {
            return true;
        }
        return false;
    }

    /**
     * @param int $vendorId
     * @return array
     */
    public function getInitialWalletData(int $vendorId): array
    {
        return [
            'seller_id' => $vendorId,
            'withdrawn' => 0,
            'commission_given' => 0,
            'total_earning' => 0,
            'pending_withdraw' => 0,
            'delivery_charge_earned' => 0,
            'collected_cash' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function logout(): void
    {
        auth()->guard('seller')->logout();
        session()->invalidate();
    }

    /**
     * @param object $request
     * @return array
     */
    public function getFreeDeliveryOverAmountData(object $request):array
    {
        return [
            'free_delivery_status' => $request['free_delivery_status'] == 'on' ? 1 : 0,
            'free_delivery_over_amount' => currencyConverter($request['free_delivery_over_amount'], 'usd'),
        ];
    }

    /**
     * @return array[minimum_order_amount: float|int]
     */
    public function getMinimumOrderAmount(object $request) :array
    {
        return [
            'minimum_order_amount' => currencyConverter($request['minimum_order_amount'], 'usd')
        ];
    }

    /**
     * @param object $request
     * @param object $vendor
     * @return array
     */
    public function getVendorDataForUpdate(object $request, object $vendor):array
    {
        $image = $request['image'] ? $this->update(dir: 'seller/', oldImage: $vendor['image'], format: 'webp', image: $request->file('image')) : $vendor['image'];
        return [
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'phone' => $request['phone'],
            'image' => $image,
        ];
    }

    /**
     * @return array[password: string]
     */
    public function getVendorPasswordData(object $request):array
    {
        return [
            'password' => bcrypt($request['password']),
        ];
    }

    /**
     * @param object $request
     * @return array
     */
    public function getVendorBankInfoData(object $request):array
    {
        return [
            'bank_name' => $request['bank_name'],
            'branch' => $request['branch'],
            'holder_name' => $request['holder_name'],
            'account_no' => $request['account_no'],
        ];
    }
    public function getAddData(object $request):array
    {
        return [
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'image' => $this->upload(dir: 'seller/', format: 'webp', image: $request->file('image')),
            'password' => bcrypt($request['password']),
            'status' => $request['status'] == 'approved' ? 'approved' : 'pending',
            'business_name' => $request['business_name'],
            'business_type' => $request['business_type'],
            'primary_industry' => $request['primary_industry'],
            'years_in_business' => $request['years_in_business'],
            'business_registration_number' => $request['business_registration_number'],
            'business_address' => $request['business_address'],
            'primary_products_services' => $request['primary_products_services'],
            'provides_warranty' => $request['provides_warranty'],
            'warranty_details' => $request['warranty_details'],
            'payment_method' => $request['payment_method'],
            'payment_terms' => $request['payment_terms'],
            'billing_contact_name' => $request['billing_contact_name'],
            'billing_contact_email' => $request['billing_contact_email'],
            'billing_contact_phone' => $request['billing_contact_phone'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],

        ];
    }

    public function getEditData(object $request):array
    {
        return [
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'image' => $this->upload(dir: 'seller/', format: 'webp', image: $request->file('image')),
            'password' => bcrypt($request['password']),
            // 'status' => $request['status'] == 'approved' ? 'approved' : 'pending',
            'business_name' => $request['business_name'],
            'business_type' => $request['business_type'],
            'primary_industry' => $request['primary_industry'],
            'years_in_business' => $request['years_in_business'],
            'business_registration_number' => $request['business_registration_number'],
            'business_address' => $request['business_address'],
            'primary_products_services' => $request['primary_products_services'],
            'provides_warranty' => $request['provides_warranty'],
            'warranty_details' => $request['warranty_details'],
            'payment_method' => $request['payment_method'],
            'payment_terms' => $request['payment_terms'],
            'billing_contact_name' => $request['billing_contact_name'],
            'billing_contact_email' => $request['billing_contact_email'],
            'billing_contact_phone' => $request['billing_contact_phone'],
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],

        ];
    }
}
