import { usePage } from '@inertiajs/react';
import { App } from '@/components/solara/App';

interface PageProps {
  featuredProducts?: any[];
  heroUrl?: string | null;
  [key: string]: unknown;
}

export default function Home() {
    const { featuredProducts, heroUrl } = usePage<PageProps>().props;
    return <App featuredProducts={featuredProducts} heroUrl={heroUrl} />;
}
