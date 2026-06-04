import { usePage } from '@inertiajs/react';
import { App } from '@/components/solara/App';

export default function Home() {
    const page = usePage();
    (window as unknown as { __translations?: Record<string, string> }).__translations = page.props.translations as Record<string, string>;

    return <App />;
}
