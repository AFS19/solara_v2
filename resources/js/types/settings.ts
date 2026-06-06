export interface GeneralSettings {
  site_name: string;
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

export interface SiteSettings {
  general: GeneralSettings;
  hero: HeroSettings;
  contact: ContactSettings;
  social: SocialSettings;
}
