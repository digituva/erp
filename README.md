# PHP ERP Uygulaması

Bu proje, küçük ve orta ölçekli işletmeler için modüler bir ERP çekirdeği sağlar. PHP 8, PDO ve MySQL kullanılarak hazırlanmıştır; MVC benzeri katmanlı yapı, rol tabanlı yetkilendirme ve CSRF koruması içerir.

## Veritabanı Tasarımı (schema.sql özeti)
Başlıca tablolar ve ilişkiler:

- **users**: Kullanıcı hesapları, roller ve aktiflik durumu. `username` benzersizdir, şifreler `password_hash` ile saklanır.
- **roles / permissions / role_permissions**: Modül bazlı yetki matrisi (görme/ekleme/düzenleme/silme bayrakları) için ilişki.
- **settings / currencies**: Şirket bilgileri, varsayılan para birimi, tarih formatı ve kur bilgileri.
- **customers**: Müşteri/tedarikçi kartı, ödeme vadesi ve risk limiti.
- **products**: Stok kartları; KDV, birim ve fiyat alanlarıyla.
- **warehouses**: Depo tanımları.
- **sales_documents / sales_items**: Teklif, sipariş, irsaliye veya fatura tipindeki satış belgeleri ve satırları. `customer_id` ve `product_id` yabancı anahtarlarıyla bütünlük sağlar.
- **stock_movements**: Depo bazlı giriş/çıkış hareketleri; satış, satınalma veya sayım gibi kaynak belgelerle bağlantı kurar.
- **cash_transactions / bank_accounts / bank_transactions**: Temel kasa/banka hareketleri.
- **bill_of_materials / production_orders**: Üretim reçetesi ve üretim emri yönetimi.
- **projects / tasks**: Proje ve görev yönetimi; görevler kullanıcılara atanabilir.

Tam şema için `database/schema.sql` dosyasına bakın.

## Klasör Yapısı ve Mimari

```
app/
  Controllers/   # HTTP denetçileri (Auth, Dashboard, User, Customer, Product, Sales)
  Core/          # Router, BaseController, Database (PDO), Auth, CSRF yardımcıları
  Models/        # Tablolara karşılık gelen modeller (BaseModel üst sınıfına bağlı)
  Views/         # Blade'siz PHP şablonları (Bootstrap 5 tabanlı)
config/          # Uygulama ve DB ayarları
public/          # index.php giriş noktası
storage/logs/    # Hata kayıtları için klasör
vendor/          # Composer autoload (composer dump-autoload sonrası oluşur)
database/schema.sql # MySQL şema tanımı
```

- **Router**: Basit GET/POST tanımlarıyla closure tabanlı eşleştirme yapar.
- **BaseModel**: `all`, `find`, `create`, `update`, `delete` (soft delete) metotlarını PDO prepared statements kullanarak uygular.
- **Auth**: Session bazlı oturum açma, rol kontrolü, güvenli şifre doğrulama.
- **CSRF**: Formlara gizli token ekleyerek gönderimlerde doğrulama yapar.
- **Views**: `layouts/main.php` şablonu navigasyon, breadcrumb ve Bootstrap stilini yükler.

## Örnek Kod Parçaları

### Router Tanımı (`public/index.php`)
```php
$router->get('/products', fn() => $productController->index());
$router->get('/products/create', fn() => $productController->create());
$router->post('/products/store', fn() => $productController->store());
```

### Controller Örneği (`ProductController`)
```php
public function store()
{
    if (!CSRF::check($_POST['_token'] ?? null)) {
        die('CSRF hatası');
    }
    $data = [
        'sku' => $_POST['sku'] ?? '',
        'name' => $_POST['name'] ?? '',
        'barcode' => $_POST['barcode'] ?? '',
        'unit' => $_POST['unit'] ?? '',
        'vat_rate' => $_POST['vat_rate'] ?? 0,
        'purchase_price' => $_POST['purchase_price'] ?? 0,
        'sale_price' => $_POST['sale_price'] ?? 0,
        'currency' => $_POST['currency'] ?? 'TRY',
        'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    $this->products->create($data);
    $this->redirect('/products');
}
```

### Model Örneği (`app/Models/Product.php`)
```php
class Product extends BaseModel
{
    protected string $table = 'products';
    protected array $fillable = ['sku', 'name', 'barcode', 'unit', 'vat_rate', 'purchase_price', 'sale_price', 'currency', 'is_active'];
}
```

### View Örneği (`app/Views/products/index.php`)
```php
<?php foreach ($products as $product): ?>
<tr>
  <td><?= htmlspecialchars($product['sku']); ?></td>
  <td><?= htmlspecialchars($product['name']); ?></td>
  <td><?= number_format($product['sale_price'], 2); ?> <?= $product['currency']; ?></td>
</tr>
<?php endforeach; ?>
```

## Modül Akış Özetleri
- **Satış**: Teklif/Sipariş/İrsaliye/Fatura tipleri `sales_documents` tablosunda tutulur; satır detayları `sales_items` tablosundadır. Kayıt sırasında `stock_movements` ile stok düşümü örneklenmiştir ve CSV dışa aktarma (`/sales/export`) sağlanır.
- **Stok/Depo**: `stock_movements` depo ve ürün bazında giriş/çıkış takibi yapar. Depolar `warehouses` tablosuyla ilişkilidir.
- **Kullanıcı Yönetimi**: Adminler kullanıcı oluşturur, roller atanır ve soft delete ile silinir. CSRF ve rol kontrolü mevcuttur.
- **Dashboard**: Açık sipariş, ürün ve müşteri sayıları hızlı özet olarak gösterilir.

## Kurulum ve Çalıştırma
1. `composer dump-autoload` komutunu çalıştırın.
2. MySQL veritabanını oluşturup `database/schema.sql` dosyasını uygulayın.
3. `config/config.php` içindeki veritabanı bilgilerini düzenleyin.
4. İlk kullanıcıyı manuel olarak `users` tablosuna ekleyin (şifreyi `password_hash` ile üretin).
5. PHP yerleşik sunucusunu başlatın:
   ```bash
   php -S localhost:8000 -t public
   ```
6. Tarayıcıdan `http://localhost:8000/login` adresine giderek giriş yapın.

## Güvenlik Notları
- Tüm SQL sorguları prepared statement ile çalışır.
- Formlarda CSRF token kontrolü vardır.
- Şifreler `password_hash()` ile saklanır.
- Basit rol kontrolü `Auth::authorize()` üzerinden yapılır; modül bazlı izinler `role_permissions` ile genişletilebilir.

## Genişletme Önerileri
- API katmanı için JWT veya bearer token desteği eklenebilir.
- Tam metin arama ve gelişmiş rapor filtreleri için index optimizasyonu yapılabilir.
- Dosya yükleme (logo vb.) için `public/uploads` dizini ve MIME kontrolü eklenebilir.
- Üretim, satınalma ve CRM süreçlerinin detaylı durum makineleri (workflow) ile zenginleştirilmesi önerilir.
