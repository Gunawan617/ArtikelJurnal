import { Link, usePage } from '@inertiajs/react';

export default function Layout({ children }) {
    const { auth } = usePage().props;

    return (
        <div className="min-h-screen bg-gray-50">
            <nav className="bg-white shadow-sm">
                <div className="max-w-6xl mx-auto px-4">
                    <div className="flex justify-between items-center h-16">
                        <Link href="/" className="text-2xl font-bold text-blue-600">
                            ScholarHub
                        </Link>
                        
                        <div className="flex items-center space-x-6">
                            <Link href="/" className="text-gray-700 hover:text-blue-600">
                                Home
                            </Link>
                            <Link href="/artikel" className="text-gray-700 hover:text-blue-600">
                                Artikel
                            </Link>
                            <Link href="/tentang" className="text-gray-700 hover:text-blue-600">
                                Tentang
                            </Link>
                            
                            {auth?.user ? (
                                <>
                                    <span className="text-gray-600">
                                        Halo, {auth.user.name}
                                    </span>
                                    {auth.user.role === 'admin' && (
                                        <a href="/admin" className="text-gray-700 hover:text-blue-600">
                                            Admin
                                        </a>
                                    )}
                                    <Link 
                                        href="/logout" 
                                        method="post" 
                                        as="button"
                                        className="text-gray-700 hover:text-blue-600"
                                    >
                                        Logout
                                    </Link>
                                </>
                            ) : (
                                <>
                                    <Link href="/login" className="text-gray-700 hover:text-blue-600">
                                        Login
                                    </Link>
                                    <Link 
                                        href="/register" 
                                        className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                                    >
                                        Daftar
                                    </Link>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </nav>

            <main>{children}</main>

            <footer className="bg-gray-800 text-white py-8 mt-16">
                <div className="max-w-6xl mx-auto px-4 text-center">
                    <p>&copy; 2024 ScholarHub. Platform Artikel Ilmiah Terindeks Google Scholar.</p>
                </div>
            </footer>
        </div>
    );
}
