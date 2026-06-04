import { Header } from "./Header";
import { HeroSection } from "./HeroSection";
import { UspBar } from "./UspBar";
import { ProductsGrid } from "./ProductsGrid";
import { SpfGuide } from "./SpfGuide";
import { HowItWorks } from "./HowItWorks";
import { Testimonials } from "./Testimonials";
import { AboutBrand } from "./AboutBrand";
import { FaqSection } from "./FaqSection";
import { Newsletter } from "./Newsletter";
import { Footer } from "./Footer";

export function App() {
  return (
    <div className="min-h-screen bg-cream text-charcoal">
      <Header />
      <main>
        <HeroSection />
        <UspBar />
        <ProductsGrid />
        <SpfGuide />
        <HowItWorks />
        <Testimonials />
        <AboutBrand />
        <FaqSection />
        <Newsletter />
      </main>
      <Footer />
    </div>
  );
}
