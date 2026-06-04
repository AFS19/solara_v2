import { HeroSection } from "./HeroSection";
import { UspBar } from "./UspBar";
import { ProductsGrid } from "./ProductsGrid";
import { SpfGuide } from "./SpfGuide";
import { HowItWorks } from "./HowItWorks";
import { Testimonials } from "./Testimonials";
import { AboutBrand } from "./AboutBrand";
import { FaqSection } from "./FaqSection";
import { Newsletter } from "./Newsletter";

export function App({ featuredProducts }: { featuredProducts?: any[] }) {
  return (
    <main>
      <HeroSection />
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
