import { Head } from '@inertiajs/react';
import { t } from '@/lib/i18n';

interface PageProps {
  page: {
    title: string;
    content: string;
  };
}

export default function Legal({ page }: PageProps) {
  return (
    <main className="pt-[64px]">
      <Head title={page.title} />
      <section className="py-16 bg-white min-h-[60vh]">
        <div className="max-w-[800px] mx-auto px-6">
          <h1 className="text-3xl md:text-4xl text-charcoal mb-8">{page.title}</h1>
          <div
            className="prose-content"
            dangerouslySetInnerHTML={{ __html: page.content }}
          />
        </div>
      </section>
    </main>
  );
}
