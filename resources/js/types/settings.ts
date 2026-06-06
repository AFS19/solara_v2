export interface GeneralSettings {
  site_name: string;
  currency: string;
}

export interface HeroSettings {
  source: 'product' | 'upload';
  product_id: number | null;
  media_path: string | null;
}

export interface ContactSettings {
  email: string;
  phone: string | null;
  address: string;
}

export interface SocialSettings {
  whatsapp: string | null;
  facebook: string | null;
  instagram: string | null;
  tiktok: string | null;
}

export interface ContentSettings {
  testimonials: { name: string; loc: string; product: string; rating: number; text: string }[];
  about_stats: string;
  about_badges: string[];
}

export interface SiteSettings {
  general: GeneralSettings;
  hero: HeroSettings;
  contact: ContactSettings;
  social: SocialSettings;
  content: ContentSettings;
}
