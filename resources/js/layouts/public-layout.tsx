import { usePage } from '@inertiajs/react';
import { Header } from '@/components/solara/Header';
import { Footer } from '@/components/solara/Footer';

export default function PublicLayout({ children }: { children: React.ReactNode }) {
    const page = usePage();
    (window as unknown as { __translations?: Record<string, string> }).__translations = page.props.translations as Record<string, string>;

    return (
        <div className="min-h-screen bg-cream text-charcoal">
            <Header />
            {children}
            <Footer />
        </div>
    );
}
