<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\UserRole;
use App\Enums\ViewPaths\Admin\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\Admin;
use App\Services\AdminService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LoginController extends BaseController
{
    /**
     * @var Admin $admin
     * @var AdminService $adminService
     */
    public function __construct(
        private readonly Admin $admin,
        private readonly AdminService $adminService
    ) {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    /**
     * Display the login view.
     *
     * @param Request|null $request
     * @param string|null $type
     * @return View|Collection|LengthAwarePaginator|null|callable
     */
    public function index(?Request $request, string $type = null): View
    {
        return $this->getLoginView($type);
    }

    /**
     * Fetch and return the login view.
     *
     * @param string $loginUrl
     * @return View
     */
    private function getLoginView(string $loginUrl): View
    {
        $loginTypes = [
            UserRole::ADMIN => getWebConfig(name: 'admin_login_url'),
            UserRole::EMPLOYEE => getWebConfig(name: 'employee_login_url')
        ];

        $userType = array_search($loginUrl, $loginTypes, true);
        abort_if(!$userType, 404, 'Login type not found');

        return view(Auth::ADMIN_LOGIN, ['role' => $userType]);
    }

    /**
     * Handle admin login requests.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $admin = $this->admin->where('email', $request->input('email'))->first();

        // Validate user role and account status
        if ($admin && $admin->status && in_array($request->input('role'), [UserRole::ADMIN, UserRole::EMPLOYEE], true)) {
            // Attempt login via AdminService
            if ($this->adminService->isLoginSuccessful(
                $request->input('email'),
                $request->input('password'),
                $request->boolean('remember')
            )) {
                Toastr::success(translate('Login successful!'));
                return redirect()->route('admin.dashboard.index');
            }
        }

        // Return error for failed login
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([translate('Invalid credentials or account is suspended')]);
    }

    /**
     * Logout the admin.
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->adminService->logout();
        session()->flash('success', translate('Logged out successfully.'));
        return redirect('login/' . getWebConfig(name: 'admin_login_url'));
    }
}
