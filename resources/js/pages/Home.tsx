import { usePage } from '@inertiajs/react';
import { App } from '@/components/solara/App';

interface PageProps {
  featuredProducts?: any[];
  [key: string]: unknown;
}

export default function Home() {
    const { featuredProducts } = usePage<PageProps>().props;
    return <App featuredProducts={featuredProducts} />;
}
