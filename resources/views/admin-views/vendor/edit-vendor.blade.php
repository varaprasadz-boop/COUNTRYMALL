@extends('layouts.back-end.app')

@section('title', translate('edit_vendor'))
@push('css_or_js')
<link rel="stylesheet" href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/css/intlTelInput.css') }}">
@endpush

@section('content')
<div class="content container-fluid main-card {{ Session::get('direction') }}">
    <div class="mb-4">
        <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/edit-seller.png') }}" class="mb-1" alt="">
            {{ translate('edit_vendor') }}
        </h2>
    </div>
    <form class="user" action="{{ route('admin.vendors.update', $vendor->id) }}" method="post" enctype="multipart/form-data" id="edit-vendor-form">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-4 pl-4">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/vendor-information.png') }}" class="mb-1" alt="">
                    {{ translate('vendor_information') }}
                </h5>
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                            <label for="firstName" class="title-color d-flex gap-1 align-items-center">{{ translate('first_name') }}</label>
                            <input type="text" class="form-control form-control-user" id="firstName" name="f_name" value="{{ old('f_name', $vendor->f_name) }}" placeholder="{{ translate('ex') }}: Jhone" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName" class="title-color d-flex gap-1 align-items-center">{{ translate('last_name') }}</label>
                            <input type="text" class="form-control form-control-user" id="lastName" name="l_name" value="{{ old('l_name', $vendor->l_name) }}" placeholder="{{ translate('ex') }}: Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="title-color d-flex" for="phone">{{ translate('phone') }}</label>
                            <div class="mb-3">
                                <input class="form-control form-control-user phone-input-with-country-picker"
                                    type="tel" id="phone" value="{{ old('phone', $vendor->phone) }}"
                                    placeholder="{{ translate('enter_phone_number') }}" required>
                                <div class="">
                                    <input type="text" class="country-picker-phone-number w-50" value="{{ old('phone', $vendor->phone) }}" name="phone" hidden readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="d-flex justify-content-center">
                                <img class="upload-img-view" id="viewer"
                                    src="{{ isset($vendor->image) ? getStorageImages(path: $vendor?->shop?->image_full_url, type: 'backend-basic') : dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt="{{ translate('vendor_image') }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="title-color mb-2 d-flex gap-1 align-items-center">{{ translate('vendor_Image') }} <span class="text-info">({{ translate('ratio') }} 1:1)</span></div>
                            <div class="custom-file text-left">
                                <input type="file" name="image" id="custom-file-upload" class="custom-file-input image-input"
                                    data-image-id="viewer"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="custom-file-upload">{{ translate('upload_image') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information Section -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-4 pl-4">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/vendor-information.png') }}" class="mb-1" alt="">
                    {{ translate('account_information') }}
                </h5>
                <div class="row">
                    <div class="col-lg-4 form-group">
                        <label for="email" class="title-color d-flex gap-1 align-items-center">{{ translate('email') }}</label>
                        <input type="email" class="form-control form-control-user" id="email" name="email" value="{{ old('email', $vendor->email) }}" placeholder="{{ translate('ex') . ': ' . 'Jhone@company.com' }}" required>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="password" class="title-color d-flex gap-1 align-items-center">
                            {{ translate('password') }}
                            <span class="input-label-secondary cursor-pointer d-flex" data-toggle="tooltip" data-placement="top" title="{{ translate('Leave blank if you do not want to change the password') }}">
                                <img alt="" width="16" src="{{ dynamicAsset(path: 'public/assets/back-end/img/info-circle.svg') }}">
                            </span>
                        </label>
                        <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control password-check"
                                name="password" id="password" minlength="8"
                                placeholder="{{ translate('password_minimum_8_characters') }}"
                                data-hs-toggle-password-options='{
                                    "target": "#changePassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changePassIcon"
                                }'>
                            <div id="changePassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changePassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                        <span class="text-danger mx-1 password-error"></span>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label for="confirm_password" class="title-color d-flex gap-1 align-items-center">{{ translate('confirm_password') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="password" class="js-toggle-password form-control"
                                name="confirm_password" id="confirm_password"
                                placeholder="{{ translate('confirm_password') }}"
                                data-hs-toggle-password-options='{
                                    "target": "#changeConfirmPassTarget",
                                    "defaultClass": "tio-hidden-outlined",
                                    "showClass": "tio-visible-outlined",
                                    "classChangeTarget": "#changeConfirmPassIcon"
                                }'>
                            <div id="changeConfirmPassTarget" class="input-group-append">
                                <a class="input-group-text" href="javascript:">
                                    <i id="changeConfirmPassIcon" class="tio-visible-outlined"></i>
                                </a>
                            </div>
                        </div>
                        <div class="pass invalid-feedback">{{ translate('repeat_password_not_match') . '.' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Information Section -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize border-bottom pb-3 mb-4 pl-4">{{ translate('business_information') }}</h5>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('business_name') }}</label>
                        <input type="text" name="business_name" class="form-control" placeholder="{{ translate('Enter Business Name') }}" value="{{ old('business_name', $vendor->business_name) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('business_type') }}</label>
                        <select name="business_type" class="form-control">
                            <option value="Sole Proprietorship" {{ $vendor->business_type == 'Sole Proprietorship' ? 'selected' : '' }}>{{ translate('Sole Proprietorship') }}</option>
                            <option value="Partnership" {{ $vendor->business_type == 'Partnership' ? 'selected' : '' }}>{{ translate('Partnership') }}</option>
                            <option value="Private Limited Company" {{ $vendor->business_type == 'Private Limited Company' ? 'selected' : '' }}>{{ translate('Private Limited Company') }}</option>
                            <option value="Public Limited Company" {{ $vendor->business_type == 'Public Limited Company' ? 'selected' : '' }}>{{ translate('Public Limited Company') }}</option>
                            <option value="Others" {{ $vendor->business_type == 'Others' ? 'selected' : '' }}>{{ translate('Others (Specify)') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('primary_industry') }}</label>
                        <select name="primary_industry" class="form-control">
                            <option value="Manufacturing" {{ $vendor->primary_industry == 'Manufacturing' ? 'selected' : '' }}>{{ translate('Manufacturing') }}</option>
                            <option value="Retail" {{ $vendor->primary_industry == 'Retail' ? 'selected' : '' }}>{{ translate('Retail') }}</option>
                            <option value="Service" {{ $vendor->primary_industry == 'Service' ? 'selected' : '' }}>{{ translate('Service') }}</option>
                            <option value="Others" {{ $vendor->primary_industry == 'Others' ? 'selected' : '' }}>{{ translate('Others (Specify)') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('years_in_business') }}</label>
                        <input type="number" name="years_in_business" class="form-control" placeholder="{{ translate('Enter Years') }}" value="{{ old('years_in_business', $vendor->years_in_business) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('business_registration_number') }}</label>
                        <input type="text" name="business_registration_number" class="form-control" placeholder="{{ translate('Enter Registration Number') }}" value="{{ old('business_registration_number', $vendor->business_registration_number) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('gst_tax_id') }}</label>
                        <input type="text" name="gst_tax_id" class="form-control" placeholder="{{ translate('Enter GST/Tax ID') }}" value="{{ old('gst_tax_id', $vendor->gst_tax_id) }}">
                    </div>
                    <div class="col-lg-12 form-group">
                        <label>{{ translate('business_address') }}</label>
                        <textarea name="business_address" class="form-control" rows="3" placeholder="{{ translate('Enter Business Address') }}">{{ old('business_address', $vendor->business_address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product or Service Information -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize border-bottom pb-3 mb-4 pl-4">{{ translate('product_or_service_information') }}</h5>
                <div class="row">
                    <div class="col-lg-12 form-group">
                        <label>{{ translate('primary_products_services_offered') }}</label>
                        <textarea name="primary_products_services" class="form-control" rows="2" placeholder="{{ translate('Describe the products/services') }}">{{ old('primary_products_services', $vendor->primary_products_services) }}</textarea>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('warranty_or_guarantee') }}</label>
                        <select name="provides_warranty" class="form-control">
                            <option value="Yes" {{ $vendor->provides_warranty == 'Yes' ? 'selected' : '' }}>{{ translate('Yes') }}</option>
                            <option value="No" {{ $vendor->provides_warranty == 'No' ? 'selected' : '' }}>{{ translate('No') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('details_of_warranty') }}</label>
                        <textarea name="warranty_details" class="form-control" rows="2" placeholder="{{ translate('Provide warranty details if any') }}">{{ old('warranty_details', $vendor->warranty_details) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment and Billing Information -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize border-bottom pb-3 mb-4 pl-4">{{ translate('payment_and_billing_information') }}</h5>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('preferred_payment_method') }}</label>
                        <select name="payment_method" class="form-control">
                            <option value="Bank Transfer" {{ $vendor->payment_method == 'Bank Transfer' ? 'selected' : '' }}>{{ translate('Bank Transfer') }}</option>
                            <option value="Cheque" {{ $vendor->payment_method == 'Cheque' ? 'selected' : '' }}>{{ translate('Cheque') }}</option>
                            <option value="Credit Card" {{ $vendor->payment_method == 'Credit Card' ? 'selected' : '' }}>{{ translate('Credit Card') }}</option>
                            <option value="Others" {{ $vendor->payment_method == 'Others' ? 'selected' : '' }}>{{ translate('Others (Specify)') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('payment_terms') }}</label>
                        <select name="payment_terms" class="form-control">
                            <option value="Net 15" {{ $vendor->payment_terms == 'Net 15' ? 'selected' : '' }}>{{ translate('Net 15') }}</option>
                            <option value="Net 30" {{ $vendor->payment_terms == 'Net 30' ? 'selected' : '' }}>{{ translate('Net 30') }}</option>
                            <option value="Net 45" {{ $vendor->payment_terms == 'Net 45' ? 'selected' : '' }}>{{ translate('Net 45') }}</option>
                            <option value="Others" {{ $vendor->payment_terms == 'Others' ? 'selected' : '' }}>{{ translate('Others (Specify)') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('billing_contact_name') }}</label>
                        <input type="text" name="billing_contact_name" class="form-control" placeholder="{{ translate('Enter Billing Contact Name') }}" value="{{ old('billing_contact_name', $vendor->billing_contact_name) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('billing_contact_email') }}</label>
                        <input type="email" name="billing_contact_email" class="form-control" placeholder="{{ translate('Enter Billing Email') }}" value="{{ old('billing_contact_email', $vendor->billing_contact_email) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('billing_contact_phone') }}</label>
                        <input type="text" name="billing_contact_phone" class="form-control" placeholder="{{ translate('Enter Billing Contact Phone') }}" value="{{ old('billing_contact_phone', $vendor->billing_contact_phone) }}">
                    </div>
                </div>
            </div>
        </div>
        <!-- Location Information -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="mb-0 text-capitalize border-bottom pb-3 mb-4 pl-4">{{ translate('location_information') }}</h5>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('latitude') }}</label>
                        <input type="text" name="latitude" class="form-control" placeholder="{{ translate('Enter latitude') }}" value="{{ old('latitude', $vendor->latitude) }}">
                    </div>
                    <div class="col-lg-6 form-group">
                        <label>{{ translate('longitude') }}</label>
                        <input type="text" name="longitude" class="form-control" placeholder="{{ translate('Enter longitude') }}" value="{{ old('longitude', $vendor->longitude) }}">
                    </div>
                </div>
                <!-- Map Location -->
                <div class="form-group">
                    <label>{{ translate('map_location') }}</label>
                    <div id="map" style="height: 400px; width: 100%; border:1px solid lightgray; border-radius:10px;"></div>
                </div>
            </div>
        </div>
        <!-- Shop Information -->
        <div class="card mt-3">
            <div class="card-body">
                <h5 style="display: none !important;" class="mb-0 text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-4 pl-4">
                    <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/vendor-information.png') }}" class="mb-1" alt="">
                    {{ translate('shop_information') }}
                </h5>
                <div class="row">
                    <div class="col-lg-6 form-group">
                        <label for="shop_name" class="title-color d-flex gap-1 align-items-center">{{ translate('shop_name') }}</label>
                        <input type="text" class="form-control form-control-user" id="shop_name" name="shop_name" placeholder="{{ translate('ex') . ':' . translate('Jhon') }}" value="{{ old('shop_name', $vendor->shop->name) }}" required>
                    </div>
                    <div class="col-lg-6 form-group">
                        <label for="shop_address" class="title-color d-flex gap-1 align-items-center">{{ translate('shop_address') }}</label>
                        <textarea name="shop_address" class="form-control text-area-max" id="shop_address" rows="1" placeholder="{{ translate('ex') . ':' . translate('doe') }}">{{ old('shop_address', $vendor->shop->address) }}</textarea>
                    </div>
                    <div class="col-lg-6 form-group">
                        <div class="d-flex justify-content-center">
                            <img class="upload-img-view" id="viewerLogo"
                                src="{{ isset($vendor->shop->image) ? asset('storage/shop/' . $vendor->shop->image) : dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt="{{ translate('shop_logo') }}" />
                        </div>
                        <div class="mt-4">
                            <div class="d-flex gap-1 align-items-center title-color mb-2">
                                {{ translate('shop_logo') }}
                                <span class="text-info">({{ translate('ratio') . ' 1:1' }})</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="logo" id="logo-upload" class="custom-file-input image-input"
                                    data-image-id="viewerLogo"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="logo-upload">{{ translate('upload_logo') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 form-group">
                        <div class="d-flex justify-content-center">
                            <img class="upload-img-view upload-img-view__banner" id="viewerBanner"
                                src="{{ isset($vendor->shop->banner) ? asset('storage/shop/banner/' . $vendor->shop->banner) : dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt="{{ translate('shop_banner') }}" />
                        </div>
                        <div class="mt-4">
                            <div class="d-flex gap-1 align-items-center title-color mb-2">
                                {{ translate('shop_banner') }}
                                <span class="text-info">{{ THEME_RATIO[theme_root_path()]['Store cover Image'] }}</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="banner" id="banner-upload" class="custom-file-input image-input"
                                    data-image-id="viewerBanner"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label text-capitalize" for="banner-upload">{{ translate('upload_Banner') }}</label>
                            </div>
                        </div>
                    </div>
                    @if(theme_root_path() == "theme_aster")
                    <div class="col-lg-6 form-group">
                        <div class="d-flex justify-content-center">
                            <img class="upload-img-view upload-img-view__banner" id="viewerBottomBanner"
                                src="{{ isset($vendor->bottom_banner) ? asset('storage/vendor/banner/' . $vendor->bottom_banner) : dynamicAsset(path: 'public/assets/back-end/img/400x400/img2.jpg') }}" alt="{{ translate('shop_secondary_banner') }}" />
                        </div>
                        <div class="mt-4">
                            <div class="d-flex gap-1 align-items-center title-color mb-2">
                                {{ translate('shop_secondary_banner') }}
                                <span class="text-info">{{ THEME_RATIO[theme_root_path()]['Store Banner Image'] }}</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" name="bottom_banner" id="bottom-banner-upload" class="custom-file-input image-input"
                                    data-image-id="viewerBottomBanner"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label text-capitalize" for="bottom-banner-upload">{{ translate('upload_bottom_banner') }}</label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-end gap-10">
                    <button type="reset" class="btn btn-secondary reset-button">{{ translate('reset') }}</button>
                    <button type="button" class="btn btn--primary btn-user form-submit" data-form-id="edit-vendor-form" data-redirect-route="{{ route('admin.vendors.vendor-list') }}"
                        data-message="{{ translate('want_to_update_this_vendor') . '?' }}">{{ translate('submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('script')
<script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/intl-tel-input/js/intlTelInput.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/country-picker-init.js') }}"></script>
<script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/vendor.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5Yz987h6JXrVIsg86u00bSWZpI4F5FiM&callback=initMap" async defer></script>
<script>
    // Initialize the map with the vendor's coordinates or default location
    function initMap() {
        const defaultLat = parseFloat(document.querySelector('input[name="latitude"]').value) || 17.4065;
        const defaultLng = parseFloat(document.querySelector('input[name="longitude"]').value) || 78.4772;

        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: defaultLat, lng: defaultLng },
            zoom: 16,
        });

        const marker = new google.maps.Marker({
            position: { lat: defaultLat, lng: defaultLng },
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            document.querySelector('input[name="latitude"]').value = lat;
            document.querySelector('input[name="longitude"]').value = lng;
        });
    }

    // Update map when latitude or longitude inputs change
    document.querySelector('input[name="latitude"]').addEventListener('change', initMap);
    document.querySelector('input[name="longitude"]').addEventListener('change', initMap);
</script>
@endpush
