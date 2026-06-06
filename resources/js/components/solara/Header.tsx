import { useEffect, useState } from "react";
import { Link, usePage } from '@inertiajs/react';
import { Menu, ShoppingBag, X } from "lucide-react";
import { t } from "@/lib/i18n";
import { home } from '@/routes';
import products from '@/routes/products';

const links = [
  { key: "nav.home", href: home.url() },
  { key: "nav.products", href: products.index.url() },
  { key: "nav.guide", href: home.url() + '#spf-guide' },
  { key: "nav.about", href: home.url() + '#about' },
  { key: "nav.contact", href: home.url() + '#newsletter' },
];

export function Header() {
  const { cartCount } = usePage<{ cartCount: number }>().props;
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);
  const [lang, setLang] = useState<"FR" | "AR" | "EN">("FR");

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 80);
    window.addEventListener("scroll", onScroll);
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  useEffect(() => {
    if (open) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
    return () => { document.body.style.overflow = ''; };
  }, [open]);

  return (
    <header
      className={`fixed top-0 inset-x-0 z-50 transition-all duration-300 ${
        scrolled ? "bg-white/95 backdrop-blur shadow-sm" : "bg-transparent"
      }`}
      style={{ height: 64 }}
    >
      <div className="max-w-[1280px] mx-auto h-full px-6 flex items-center justify-between">
        <Link href={home.url()} className="font-display text-[24px] text-gold font-bold tracking-tight">
          SOLARA
        </Link>

        <nav className="hidden lg:flex items-center gap-8">
          {links.map((l) => (
            <Link
              key={l.key}
              href={l.href}
              className="text-sm text-charcoal hover:text-coral transition-colors"
            >
              {t(l.key)}
            </Link>
          ))}
        </nav>

        <div className="flex items-center gap-3">
          {/* <div className="hidden md:flex items-center bg-cream/80 rounded-full p-1 border border-border">
            {(["FR", "AR", "EN"] as const).map((l) => (
              <button
                key={l}
                onClick={() => setLang(l)}
                className={`px-3 py-1 text-xs rounded-full transition-colors ${
                  lang === l ? "bg-charcoal text-white" : "text-charcoal/70"
                }`}
              >
                {l}
              </button>
            ))}
          </div> */}

          <Link href="/panier" className="relative p-2 text-charcoal hover:text-coral transition-colors">
            <ShoppingBag size={20} />
            {cartCount > 0 && (
              <span className="absolute -top-0.5 -right-0.5 bg-coral text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center">
                {cartCount}
              </span>
            )}
          </Link>

          <Link
            href={products.index.url()}
            className="hidden sm:inline-flex bg-gold text-white px-5 py-2 rounded-full text-sm font-medium btn-press btn-press-active hover:bg-gold/90"
          >
            {t("nav.shop")}
          </Link>

          <button
            className="lg:hidden p-2 text-charcoal"
            onClick={() => setOpen(true)}
            aria-label="Menu"
          >
            <Menu size={22} />
          </button>
        </div>
      </div>

      {open && (
        <div className="fixed inset-0 z-50 lg:hidden">
          <div className="absolute inset-0 bg-charcoal/40" onClick={() => setOpen(false)} />
          <div className="absolute top-0 right-0 h-full w-72 bg-white shadow-xl p-6 animate-fade-up">
            <div className="flex justify-between items-center mb-8">
              <span className="font-display text-gold text-xl">SOLARA</span>
              <button onClick={() => setOpen(false)}>
                <X size={22} />
              </button>
            </div>
            <nav className="flex flex-col gap-4">
              {links.map((l) => (
                <Link
                  key={l.key}
                  href={l.href}
                  onClick={() => setOpen(false)}
                  className="text-charcoal text-base"
                >
                  {t(l.key)}
                </Link>
              ))}
            </nav>
          </div>
        </div>
      )}
    </header>
  );
}
