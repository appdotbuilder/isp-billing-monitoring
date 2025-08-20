import React, { useState } from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { AppHeader } from '@/components/app-header';
import { AppContent } from '@/components/app-content';

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    company?: Company;
}

interface Company {
    id: number;
    name: string;
    type: string;
    is_active: boolean;
    devices_count?: number;
    customers_count?: number;
    employees_count?: number;
}

interface Device {
    id: number;
    name: string;
    type: string;
    ip_address: string;
    status: string;
    last_seen: string;
    metrics?: {
        cpu_usage: number;
        memory_usage: number;
        bandwidth_in: string;
        bandwidth_out: string;
        uptime: string;
    };
}

interface CustomerStats {
    active: number;
    suspended: number;
    inactive: number;
}

interface DeviceStats {
    online: number;
    offline: number;
    maintenance: number;
}

interface Props {
    user: User;
    currentCompany?: Company;
    companies: Company[];
    stats: {
        totalDevices: number;
        totalCustomers: number;
        totalEmployees: number;
        totalRevenue: number;
        deviceStats: DeviceStats;
        customerStats: CustomerStats;
    };
    monitoringData?: Device[];
    recentBilling?: Array<{
        id: number;
        invoice_number: string;
        customer?: { name: string };
        total_amount: number;
        status: string;
        billing_date: string;
    }>;
    [key: string]: unknown;
}

export default function IspDashboard({ 
    user, 
    currentCompany, 
    companies, 
    stats, 
    monitoringData,
    recentBilling 
}: Props) {
    const [activeTab, setActiveTab] = useState('overview');
    const [selectedDevice, setSelectedDevice] = useState<Device | null>(null);

    const getStatusColor = (status: string) => {
        switch (status) {
            case 'online':
            case 'active':
                return 'text-green-600 bg-green-100';
            case 'offline':
            case 'suspended':
                return 'text-red-600 bg-red-100';
            case 'maintenance':
            case 'inactive':
                return 'text-yellow-600 bg-yellow-100';
            default:
                return 'text-gray-600 bg-gray-100';
        }
    };

    return (
        <AppShell>
            <Head title="ISP Dashboard" />
            <AppHeader />
            <AppContent>
                <div className="p-6">
                {/* Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🌐 ISP Management Dashboard
                    </h1>
                    <p className="text-gray-600">
                        {user.role === 'super_admin' ? (
                            'Super Admin - All Companies Access'
                        ) : (
                            `${currentCompany?.name || 'No Company'} - ${user.role}`
                        )}
                    </p>
                </div>

                {/* Quick Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Devices</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.totalDevices}</p>
                            </div>
                            <div className="text-4xl">📡</div>
                        </div>
                        <div className="mt-4 flex space-x-2">
                            <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {stats.deviceStats.online} Online
                            </span>
                            <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {stats.deviceStats.offline} Offline
                            </span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Total Customers</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.totalCustomers}</p>
                            </div>
                            <div className="text-4xl">👥</div>
                        </div>
                        <div className="mt-4 flex space-x-2">
                            <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {stats.customerStats.active} Active
                            </span>
                            <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {stats.customerStats.suspended} Suspended
                            </span>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Employees</p>
                                <p className="text-3xl font-bold text-gray-900">{stats.totalEmployees}</p>
                            </div>
                            <div className="text-4xl">👨‍💼</div>
                        </div>
                    </div>

                    <div className="bg-white rounded-lg shadow p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600">Revenue</p>
                                <p className="text-3xl font-bold text-gray-900">
                                    ${stats.totalRevenue.toLocaleString()}
                                </p>
                            </div>
                            <div className="text-4xl">💰</div>
                        </div>
                    </div>
                </div>

                {/* Tab Navigation */}
                <div className="mb-6">
                    <nav className="flex space-x-8">
                        {[
                            { key: 'overview', label: '📊 Overview', icon: '📊' },
                            { key: 'devices', label: '📡 Device Monitoring', icon: '📡' },
                            { key: 'network', label: '🗺️ Network Map', icon: '🗺️' },
                            { key: 'billing', label: '💳 Billing', icon: '💳' },
                            { key: 'customers', label: '👥 Customers', icon: '👥' },
                        ].map((tab) => (
                            <button
                                key={tab.key}
                                onClick={() => setActiveTab(tab.key)}
                                className={`py-2 px-1 border-b-2 font-medium text-sm ${
                                    activeTab === tab.key
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                }`}
                            >
                                {tab.label}
                            </button>
                        ))}
                    </nav>
                </div>

                {/* Tab Content */}
                {activeTab === 'overview' && (
                    <div className="space-y-6">
                        {/* Companies Overview (Super Admin) */}
                        {user.role === 'super_admin' && (
                            <div className="bg-white rounded-lg shadow p-6">
                                <h3 className="text-lg font-semibold mb-4">🏢 Companies Overview</h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    {companies.map((company) => (
                                        <div key={company.id} className="border rounded-lg p-4">
                                            <div className="flex items-center justify-between mb-2">
                                                <h4 className="font-medium">{company.name}</h4>
                                                <span className={`px-2 py-1 rounded-full text-xs ${
                                                    company.type === 'parent' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'
                                                }`}>
                                                    {company.type}
                                                </span>
                                            </div>
                                            <div className="text-sm text-gray-600">
                                                <p>Devices: {company.devices_count || 0}</p>
                                                <p>Customers: {company.customers_count || 0}</p>
                                                <p>Employees: {company.employees_count || 0}</p>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Recent Activity */}
                        <div className="bg-white rounded-lg shadow p-6">
                            <h3 className="text-lg font-semibold mb-4">🔄 Recent Billing Activity</h3>
                            {recentBilling && recentBilling.length > 0 ? (
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                            <tr>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Invoice
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Customer
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Amount
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                            {recentBilling.slice(0, 5).map((bill) => (
                                                <tr key={bill.id}>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {bill.invoice_number}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {bill.customer?.name}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        ${bill.total_amount}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap">
                                                        <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getStatusColor(bill.status)}`}>
                                                            {bill.status}
                                                        </span>
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {new Date(bill.billing_date).toLocaleDateString()}
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            ) : (
                                <p className="text-gray-500 text-center py-4">No recent billing activity</p>
                            )}
                        </div>
                    </div>
                )}

                {activeTab === 'devices' && (
                    <div className="bg-white rounded-lg shadow p-6">
                        <div className="flex justify-between items-center mb-6">
                            <h3 className="text-lg font-semibold">📡 Device Monitoring</h3>
                            <button 
                                onClick={() => window.location.reload()}
                                className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                            >
                                🔄 Refresh Data
                            </button>
                        </div>
                        
                        {monitoringData && monitoringData.length > 0 ? (
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                {monitoringData.map((device) => (
                                    <div 
                                        key={device.id} 
                                        className="border rounded-lg p-4 cursor-pointer hover:shadow-md transition-shadow"
                                        onClick={() => setSelectedDevice(device)}
                                    >
                                        <div className="flex items-center justify-between mb-3">
                                            <h4 className="font-medium">{device.name}</h4>
                                            <span className={`px-2 py-1 rounded-full text-xs ${getStatusColor(device.status)}`}>
                                                {device.status}
                                            </span>
                                        </div>
                                        <div className="space-y-1 text-sm text-gray-600">
                                            <p>Type: {device.type}</p>
                                            <p>IP: {device.ip_address}</p>
                                            {device.metrics && (
                                                <>
                                                    <p>CPU: {device.metrics.cpu_usage}%</p>
                                                    <p>Memory: {device.metrics.memory_usage}%</p>
                                                    <p>Uptime: {device.metrics.uptime}</p>
                                                </>
                                            )}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        ) : (
                            <div className="text-center py-12">
                                <div className="text-6xl mb-4">📡</div>
                                <h3 className="text-lg font-medium text-gray-900 mb-2">No devices found</h3>
                                <p className="text-gray-500">Add devices to start monitoring your network infrastructure.</p>
                            </div>
                        )}

                        {/* Device Details Modal */}
                        {selectedDevice && (
                            <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                                <div className="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                                    <div className="flex justify-between items-center mb-4">
                                        <h3 className="text-lg font-semibold">{selectedDevice.name}</h3>
                                        <button 
                                            onClick={() => setSelectedDevice(null)}
                                            className="text-gray-400 hover:text-gray-600"
                                        >
                                            ✕
                                        </button>
                                    </div>
                                    <div className="space-y-3">
                                        <div>
                                            <span className="font-medium">Status: </span>
                                            <span className={`px-2 py-1 rounded-full text-xs ${getStatusColor(selectedDevice.status)}`}>
                                                {selectedDevice.status}
                                            </span>
                                        </div>
                                        <p><span className="font-medium">Type:</span> {selectedDevice.type}</p>
                                        <p><span className="font-medium">IP Address:</span> {selectedDevice.ip_address}</p>
                                        {selectedDevice.metrics && (
                                            <div className="border-t pt-3">
                                                <h4 className="font-medium mb-2">Real-time Metrics</h4>
                                                <div className="space-y-2 text-sm">
                                                    <p>CPU Usage: {selectedDevice.metrics.cpu_usage}%</p>
                                                    <p>Memory Usage: {selectedDevice.metrics.memory_usage}%</p>
                                                    <p>Bandwidth In: {selectedDevice.metrics.bandwidth_in}</p>
                                                    <p>Bandwidth Out: {selectedDevice.metrics.bandwidth_out}</p>
                                                    <p>Uptime: {selectedDevice.metrics.uptime}</p>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {activeTab === 'network' && (
                    <div className="bg-white rounded-lg shadow p-6">
                        <h3 className="text-lg font-semibold mb-4">🗺️ Network Infrastructure Map</h3>
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">🗺️</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">Interactive Network Map</h3>
                            <p className="text-gray-500 mb-4">
                                This will show ODC, ODP locations, customer connections, and device topology.
                                Integration with Leaflet maps for geospatial visualization.
                            </p>
                            <div className="inline-flex space-x-4">
                                <div className="flex items-center space-x-2">
                                    <div className="w-4 h-4 bg-green-500 rounded-full"></div>
                                    <span className="text-sm">ODC (Active)</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <div className="w-4 h-4 bg-blue-500 rounded-full"></div>
                                    <span className="text-sm">ODP</span>
                                </div>
                                <div className="flex items-center space-x-2">
                                    <div className="w-4 h-4 bg-purple-500 rounded-full"></div>
                                    <span className="text-sm">Customers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {activeTab === 'billing' && (
                    <div className="bg-white rounded-lg shadow p-6">
                        <h3 className="text-lg font-semibold mb-4">💳 Billing & Financial Management</h3>
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">💳</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">Billing Management</h3>
                            <p className="text-gray-500">
                                Automated billing, payment gateway integration, invoice generation,
                                and financial reporting capabilities.
                            </p>
                        </div>
                    </div>
                )}

                {activeTab === 'customers' && (
                    <div className="bg-white rounded-lg shadow p-6">
                        <h3 className="text-lg font-semibold mb-4">👥 Customer Management</h3>
                        <div className="text-center py-12">
                            <div className="text-6xl mb-4">👥</div>
                            <h3 className="text-lg font-medium text-gray-900 mb-2">Customer Portal</h3>
                            <p className="text-gray-500">
                                Complete customer lifecycle management, service provisioning,
                                support ticketing, and communication tools.
                            </p>
                        </div>
                    </div>
                )}
                </div>
            </AppContent>
        </AppShell>
    );
}