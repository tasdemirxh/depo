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
- Blog, sayfa, arsiv, arama ve 404 sablonlari

## Kurulum

1. Bu klasoru WordPress kurulumunuzda `wp-content/themes/novashop-commerce` yoluna yerlestirin.
2. WordPress admin panelinden **Gorunum > Temalar** alanina gidin.
3. **NovaShop Commerce** temasini etkinlestirin.
4. WooCommerce eklentisini kurup etkinlestirin.
5. **Gorunum > Ozellestir** alanindan tema renklerini, hero metinlerini ve header/footer ayarlarini duzenleyin.
6. **Gorunum > Menuler** alanindan Primary, Secondary ve Footer menu konumlarini atayin.

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
│   ├── customizer.php
│   ├── setup.php
│   ├── template-functions.php
│   └── woocommerce.php
├── index.php
├── page.php
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

- Mega menu yonetimi
- Wishlist ve compare ozellikleri
- AJAX urun filtreleri
- Elementor widget destegi
- Demo import sistemi
- Gelismis tema ayar paneli
- Urun hizli gorunum modali
- Header/footer builder
- Coklu demo ana sayfa sablonlari
