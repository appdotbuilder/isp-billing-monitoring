import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    const features = [
        {
            icon: '🏢',
            title: 'Multi-Tenant Architecture',
            description: 'Separate parent companies and tenant branches with complete data isolation',
        },
        {
            icon: '📡',
            title: 'Device Monitoring',
            description: 'Real-time monitoring of routers, OLTs, TR-069 servers, SSH, and SNMP devices',
        },
        {
            icon: '🗺️',
            title: 'Network Mapping',
            description: 'Interactive maps showing ODC, ODP locations and customer connections',
        },
        {
            icon: '💰',
            title: 'Automated Billing',
            description: 'Integrated billing system with payment gateways and invoice generation',
        },
        {
            icon: '📱',
            title: 'WhatsApp Integration',
            description: 'Customer communication via WhatsApp with automated messaging and chatbots',
        },
        {
            icon: '👨‍💼',
            title: 'HRD Management',
            description: 'Employee management, payroll, attendance tracking, and loan management',
        },
        {
            icon: '🔧',
            title: 'Super Admin Access',
            description: 'Self-healing capabilities with full CRUD access across all tenants',
        },
        {
            icon: '⏰',
            title: 'Smart Scheduler',
            description: 'Automated tasks for billing, customer suspension, and maintenance',
        },
    ];

    const deviceTypes = [
        { name: 'Mikrotik Routers', icon: '🌐' },
        { name: 'GenieACS TR-069', icon: '📡' },
        { name: 'OLT Devices', icon: '💡' },
        { name: 'SSH Servers', icon: '🔒' },
        { name: 'SNMP Devices', icon: '📊' },
    ];

    return (
        <>
            <Head title="ISP Management Platform">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
                {/* Header */}
                <header className="relative overflow-hidden">
                    <nav className="flex items-center justify-between p-6 lg:px-8">
                        <div className="flex items-center space-x-2">
                            <div className="text-2xl">🌐</div>
                            <span className="text-xl font-bold text-gray-900">ISP Manager</span>
                        </div>
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('isp.dashboard')}
                                    className="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <div className="flex space-x-3">
                                    <Link
                                        href={route('login')}
                                        className="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition-colors"
                                    >
                                        Register
                                    </Link>
                                </div>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="px-6 lg:px-8">
                    <div className="mx-auto max-w-7xl py-16 sm:py-24">
                        <div className="text-center">
                            <h1 className="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-6">
                                🌐 Multi-Tenant ISP
                                <span className="block text-blue-600">Management Platform</span>
                            </h1>
                            <p className="mx-auto mt-6 max-w-3xl text-lg leading-8 text-gray-600">
                                Complete ISP management solution with multi-tenant architecture, real-time device monitoring,
                                automated billing, customer management, and comprehensive network infrastructure oversight.
                                Built for scalability with PostgreSQL and Laravel.
                            </p>
                            <div className="mt-10 flex items-center justify-center gap-x-6">
                                {!auth.user && (
                                    <>
                                        <Link
                                            href={route('register')}
                                            className="rounded-lg bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-lg hover:bg-blue-700 transition-all hover:shadow-xl"
                                        >
                                            Get Started
                                        </Link>
                                        <Link
                                            href={route('login')}
                                            className="text-base font-semibold leading-6 text-gray-900 hover:text-blue-600 transition-colors"
                                        >
                                            Log in <span aria-hidden="true">→</span>
                                        </Link>
                                    </>
                                )}
                                {auth.user && (
                                    <Link
                                        href={route('isp.dashboard')}
                                        className="rounded-lg bg-blue-600 px-8 py-3 text-base font-semibold text-white shadow-lg hover:bg-blue-700 transition-all hover:shadow-xl"
                                    >
                                        Access Dashboard
                                    </Link>
                                )}
                            </div>
                        </div>

                        {/* Features Grid */}
                        <div className="mt-20">
                            <h2 className="text-center text-3xl font-bold text-gray-900 mb-12">
                                🚀 Powerful ISP Management Features
                            </h2>
                            <div className="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                                {features.map((feature, index) => (
                                    <div key={index} className="relative group">
                                        <div className="rounded-2xl border border-gray-200 bg-white p-6 hover:shadow-lg transition-all hover:border-blue-200">
                                            <div className="text-4xl mb-4 group-hover:scale-110 transition-transform">
                                                {feature.icon}
                                            </div>
                                            <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                                {feature.title}
                                            </h3>
                                            <p className="text-sm text-gray-600 leading-relaxed">
                                                {feature.description}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Device Monitoring Section */}
                        <div className="mt-20 rounded-3xl bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-16">
                            <div className="text-center">
                                <h2 className="text-3xl font-bold text-white mb-6">
                                    📡 Comprehensive Device Monitoring
                                </h2>
                                <p className="text-xl text-blue-100 mb-12 max-w-3xl mx-auto">
                                    Monitor and manage your entire network infrastructure with real-time data,
                                    automated alerts, and comprehensive device support.
                                </p>
                                <div className="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                                    {deviceTypes.map((device, index) => (
                                        <div key={index} className="text-center">
                                            <div className="text-4xl mb-2">{device.icon}</div>
                                            <p className="text-white font-medium">{device.name}</p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Architecture Highlights */}
                        <div className="mt-20">
                            <div className="text-center mb-12">
                                <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                    🏗️ Enterprise Architecture
                                </h2>
                                <p className="text-xl text-gray-600 max-w-3xl mx-auto">
                                    Built with modern technologies for scalability, security, and performance
                                </p>
                            </div>
                            <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div className="text-center p-6 bg-white rounded-2xl shadow-md">
                                    <div className="text-5xl mb-4">🔐</div>
                                    <h3 className="text-xl font-bold text-gray-900 mb-2">Multi-Tenant Security</h3>
                                    <p className="text-gray-600">
                                        Complete data isolation between parent companies and tenant branches
                                        with role-based access control and super admin capabilities.
                                    </p>
                                </div>
                                <div className="text-center p-6 bg-white rounded-2xl shadow-md">
                                    <div className="text-5xl mb-4">⚡</div>
                                    <h3 className="text-xl font-bold text-gray-900 mb-2">Real-Time Monitoring</h3>
                                    <p className="text-gray-600">
                                        Live device status, bandwidth usage, error rates, and system logs
                                        with network topology visualization.
                                    </p>
                                </div>
                                <div className="text-center p-6 bg-white rounded-2xl shadow-md">
                                    <div className="text-5xl mb-4">🤖</div>
                                    <h3 className="text-xl font-bold text-gray-900 mb-2">Intelligent Automation</h3>
                                    <p className="text-gray-600">
                                        Automated billing, customer management, WhatsApp integration,
                                        and scheduled maintenance tasks.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {/* CTA Section */}
                        <div className="mt-20 text-center">
                            <div className="rounded-2xl bg-gray-50 px-8 py-12">
                                <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                    Ready to Transform Your ISP Operations?
                                </h2>
                                <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                                    Join forward-thinking ISPs who trust our platform to manage their
                                    network infrastructure, customers, and business operations.
                                </p>
                                {!auth.user ? (
                                    <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                        <Link
                                            href={route('register')}
                                            className="rounded-lg bg-blue-600 px-8 py-3 text-base font-semibold text-white hover:bg-blue-700 transition-colors"
                                        >
                                            Start Free Trial
                                        </Link>
                                        <Link
                                            href={route('login')}
                                            className="rounded-lg border border-gray-300 px-8 py-3 text-base font-semibold text-gray-700 hover:bg-gray-50 transition-colors"
                                        >
                                            Login to Dashboard
                                        </Link>
                                    </div>
                                ) : (
                                    <Link
                                        href={route('isp.dashboard')}
                                        className="inline-flex rounded-lg bg-blue-600 px-8 py-3 text-base font-semibold text-white hover:bg-blue-700 transition-colors"
                                    >
                                        Access Your Dashboard
                                    </Link>
                                )}
                            </div>
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 py-12">
                    <div className="mx-auto max-w-7xl px-6 lg:px-8">
                        <div className="text-center">
                            <p className="text-sm text-gray-500">
                                Built with ❤️ for ISP professionals | PostgreSQL • Laravel • React • Inertia.js
                            </p>
                            <div className="mt-4 flex justify-center space-x-6 text-sm text-gray-400">
                                <span>🌐 Multi-Tenant</span>
                                <span>📡 Device Monitoring</span>
                                <span>💰 Automated Billing</span>
                                <span>📱 WhatsApp Integration</span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}