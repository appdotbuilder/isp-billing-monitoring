<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Employee;
use App\Services\DeviceMonitoringService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IspDashboardController extends Controller
{
    /**
     * The device monitoring service instance.
     */
    protected DeviceMonitoringService $monitoringService;

    /**
     * Create a new controller instance.
     */
    public function __construct(DeviceMonitoringService $monitoringService)
    {
        $this->monitoringService = $monitoringService;
    }

    /**
     * Display the ISP dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $currentCompany = $user->company;
        
        // Super admin can see all companies, others see only their company
        if ($user->isSuperAdmin()) {
            $companies = Company::with(['devices', 'customers', 'employees'])->get();
            $totalDevices = Device::count();
            $totalCustomers = Customer::count();
            $totalEmployees = Employee::count();
            $totalRevenue = Billing::paid()->sum('total_amount');
        } else {
            $companies = $currentCompany ? [$currentCompany->load(['devices', 'customers', 'employees'])] : [];
            $totalDevices = $currentCompany ? $currentCompany->devices()->count() : 0;
            $totalCustomers = $currentCompany ? $currentCompany->customers()->count() : 0;
            $totalEmployees = $currentCompany ? $currentCompany->employees()->count() : 0;
            $totalRevenue = $currentCompany ? Billing::where('company_id', $currentCompany->id)->paid()->sum('total_amount') : 0;
        }

        // Device status overview
        $deviceStats = [
            'online' => Device::online()->count(),
            'offline' => Device::offline()->count(),
            'maintenance' => Device::where('status', 'maintenance')->count(),
        ];

        // Customer status overview
        $customerStats = [
            'active' => Customer::active()->count(),
            'suspended' => Customer::suspended()->count(),
            'inactive' => Customer::where('status', 'inactive')->count(),
        ];

        // Recent activity (last 10 records)
        $recentBilling = Billing::with(['customer', 'company'])
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('isp-dashboard', [
            'user' => $user,
            'currentCompany' => $currentCompany,
            'companies' => $companies,
            'stats' => [
                'totalDevices' => $totalDevices,
                'totalCustomers' => $totalCustomers,
                'totalEmployees' => $totalEmployees,
                'totalRevenue' => $totalRevenue,
                'deviceStats' => $deviceStats,
                'customerStats' => $customerStats,
            ],
            'recentBilling' => $recentBilling,
        ]);
    }

    /**
     * Get real-time device monitoring data.
     */
    public function store(Request $request)
    {
        // This endpoint handles AJAX requests for real-time data updates
        $user = $request->user();
        
        if ($user->isSuperAdmin()) {
            $devices = Device::with('company')->get();
        } else {
            $devices = $user->company ? $user->company->devices : collect();
        }

        // Get real-time monitoring data
        $monitoringData = $devices->map(function ($device) {
            $metrics = $this->monitoringService->checkDeviceStatus($device);
            return [
                'id' => $device->id,
                'name' => $device->name,
                'status' => $device->fresh()->status, // Get updated status
                'type' => $device->type,
                'ip_address' => $device->ip_address,
                'last_seen' => $device->fresh()->last_seen,
                'metrics' => $metrics,
            ];
        });

        return Inertia::render('isp-dashboard', [
            'user' => $user,
            'currentCompany' => $user->company,
            'monitoringData' => $monitoringData,
        ]);
    }
}