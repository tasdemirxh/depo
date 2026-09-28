# NovaShop Commerce

NovaShop Commerce, WooCommerce odakli modern bir WordPress tema baslangicidir. Woodmart benzeri premium magazacilik deneyimini sifirdan gelistirmek icin temiz bir klasik tema iskeleti, responsive header, ana sayfa ticaret bolumleri, Customizer ayarlari ve WooCommerce kart stilleri icerir.

> Not: Bu tema Woodmart'in kopyasi degildir. Benzer e-ticaret ihtiyaclarini karsilayan ozgun bir baslangic temasidir.

## Ozellikler

- WordPress klasik tema yapisi
- WooCommerce tema destegi
- Urun galeri zoom/lightbox/slider destegi
- Responsive header ve mobil menu
- Ust bar mesaji
- Sepet ve hesap linkleri
- Customizer uzerinden:
  - vurgu rengi
  - sticky header
  - ana sayfa hero metinleri
  - buton linkleri
  - footer metni
- Ana sayfa hero bolumu
- Kategori ve one cikan urun bolumleri
- Kampanya/promo kartlari
- Footer widget alanlari
- Magaza sidebar alani
- Gelismis tema ayar paneli
- Mega menu yonetim alanlari
- Wishlist ve compare koleksiyonlari
- Urun hizli gorunum AJAX modali
- AJAX urun filtreleri
- Elementor aktifken NovaShop Product Grid widget'i
- Demo import sistemi
- Header/footer builder ayarlari
- Fashion ve Electronics demo ana sayfa sablonlari
- Blog, sayfa, arsiv, arama ve 404 sablonlari

## Kurulum

1. Bu klasoru WordPress kurulumunuzda `wp-content/themes/novashop-commerce` yoluna yerlestirin.
2. WordPress admin panelinden **Gorunum > Temalar** alanina gidin.
3. **NovaShop Commerce** temasini etkinlestirin.
4. WooCommerce eklentisini kurup etkinlestirin.
5. **Gorunum > Ozellestir** alanindan tema renklerini, hero metinlerini ve header/footer ayarlarini duzenleyin.
6. **Gorunum > Menuler** alanindan Primary, Secondary ve Footer menu konumlarini atayin.
7. **Gorunum > NovaShop Settings** alanindan gelismis ozellikleri acip kapatin.

## Kisa kodlar

- `[novashop_wishlist]`: ziyaretcinin wishlist urunlerini listeler.
- `[novashop_compare]`: ziyaretcinin compare urunlerini listeler.
- `[novashop_collection type="wishlist"]`: belirli koleksiyonu listeler.
- `[novashop_ajax_filters]`: kategori, fiyat ve siralama alanlari olan AJAX urun filtre formu gosterir.

## Guvenlik notlari

- AJAX islemleri WordPress nonce kontrolu kullanir.
- Admin islemleri `edit_theme_options` yetkisi ister.
- Urun ID'leri WooCommerce urun nesnesi ve yayin durumu ile dogrulanir.
- Misafir wishlist/compare verileri yalnizca sanitize edilmis urun ID listesi olarak HttpOnly cookie'de tutulur.
- Demo import islemi nonce korumalidir ve mevcut sayfalari slug uzerinden tekrar kullanir.

## Dosya yapisi

```text
.
├── 404.php
├── archive.php
├── assets/
│   └── js/
│       └── theme.js
├── comments.php
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── inc/
│   ├── ajax-filters.php
│   ├── builders.php
│   ├── commerce-actions.php
│   ├── customizer.php
│   ├── demo-import.php
│   ├── elementor.php
│   ├── mega-menu.php
│   ├── settings.php
│   ├── setup.php
│   ├── template-functions.php
│   └── woocommerce.php
├── index.php
├── page.php
├── page-templates/
│   ├── home-electronics.php
│   └── home-fashion.php
├── search.php
├── searchform.php
├── single.php
├── style.css
├── template-parts/
│   ├── content-none.php
│   ├── content-page.php
│   └── content.php
└── woocommerce.php
```

## Sonraki gelistirme alanlari

- Tasarim/stil iyilestirmeleri
- Wishlist ve compare icin gelismis tablo gorunumu
- Filtrelerde pagination ve attribute filtreleri
- Header/footer builder icin surukle-birak arayuzu
- Demo import icin ornek urun ve medya setleri
