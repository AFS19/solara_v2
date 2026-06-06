import { HeroSection } from "./HeroSection";
import { UspBar } from "./UspBar";
import { ProductsGrid } from "./ProductsGrid";
import { SpfGuide } from "./SpfGuide";
import { HowItWorks } from "./HowItWorks";
import { Testimonials } from "./Testimonials";
import { AboutBrand } from "./AboutBrand";
import { FaqSection } from "./FaqSection";
import { Newsletter } from "./Newsletter";

export function App({ featuredProducts, heroUrl }: { featuredProducts?: any[]; heroUrl?: string | null }) {
  return (
    <main>
      <HeroSection heroUrl={heroUrl} />
      <UspBar />
      <ProductsGrid products={featuredProducts} />
      <SpfGuide />
      <HowItWorks />
      <Testimonials />
      <AboutBrand />
      <FaqSection />
      <Newsletter />
    </main>
  );
}
