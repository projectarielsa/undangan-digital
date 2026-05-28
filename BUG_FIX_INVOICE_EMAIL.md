# 🐛 Bug Fix: Invoice Email JSON Decode Error

## 📋 Problem Summary

**Error:** `json_decode(): Argument #1 ($json) must be of type string, array given`

**Root Cause:** Double decoding JSON pada field yang sudah otomatis di-cast sebagai `array` oleh Laravel Model.

---

## 🔍 Investigation Results

### Files dengan `json_decode()`:
1. ✅ `resources/views/emails/payment-invoice.blade.php` - **FIXED**
2. ✅ `tests/Feature/PaymentInvoiceEmailTest.php` - **FIXED**
3. ✅ Null safety issues - **FIXED**

### Model Cast Analysis:

**Package Model** (`app/Models/Package.php`):
```php
protected function casts(): array
{
    return [
        'features' => 'array',  // ← Already auto-cast to array!
        // ... other casts
    ];
}
```

Ketika field `features` di-cast sebagai `array`, Laravel otomatis:
- **Saat save:** Convert array → JSON string untuk database
- **Saat load:** Convert JSON string → array untuk PHP

Jadi **TIDAK PERLU** `json_decode()` manual lagi!

---

## ✅ Changes Made

### 1. Fixed `payment-invoice.blade.php`

#### **Issue #1: Double JSON Decode**
**Before (Line 287):**
```blade
@foreach(json_decode($package->features, true) ?? [] as $feature)
```

**After:**
```blade
@foreach((is_array($package->features) ? $package->features : json_decode($package->features, true)) ?? [] as $feature)
```

**Why this approach?**
- ✅ **Backward compatible**: Tetap handle jika data masih string JSON
- ✅ **Future-proof**: Handle jika cast array sudah aktif
- ✅ **Safe**: Tidak error di kondisi apapun

#### **Issue #2: Null Safety on `paid_at`**
**Before (Line 254):**
```blade
{{ $payment->paid_at->format('d M Y, H:i') }} WIB
```

**After:**
```blade
{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : '-' }}
```

**Why?**
- Mencegah error jika `paid_at` null
- Display `-` sebagai fallback

### 2. Fixed `PaymentInvoiceEmailTest.php`

**Before (Line 118):**
```php
$features = json_decode($this->package->features, true);
```

**After:**
```php
$features = is_array($this->package->features) 
    ? $this->package->features 
    : json_decode($this->package->features, true);
```

---

## 🧪 Testing

### Manual Test Command:
```bash
# Clear cache
php artisan optimize:clear

# Test invoice email
php artisan invoice:test

# Test dengan order ID tertentu
php artisan invoice:test --order-id=ORDER-123

# Test tanpa queue (langsung kirim)
php artisan invoice:test --email=test@example.com
```

### Expected Output:
```
Order ID tidak diberikan. Mencari payment terakhir yang berhasil...
✓ Ditemukan payment: ORDER-xxx

═══════════════════════════════════════════════════════════
                   PAYMENT INFORMATION
═══════════════════════════════════════════════════════════

+------------------+--------------------------------+
| Field            | Value                         |
+------------------+--------------------------------+
| Order ID         | ORDER-xxx                     |
| Transaction ID   | TRX-xxx                       |
| Status           | paid                          |
| ...              | ...                           |
+------------------+--------------------------------+

Kirim invoice email untuk payment ini? (yes/no) [yes]:
> yes

📧 Mengirim invoice langsung ke: user@example.com
✓ Invoice berhasil dikirim!
```

### Automated Test:
```bash
php artisan test --filter=PaymentInvoiceEmailTest
```

---

## 🛡️ Safety Improvements

### 1. Null-Safe Handling
Semua nullable fields kini aman:

```blade
<!-- Transaction ID -->
{{ $payment->transaction_id ?? '-' }}

<!-- Paid At -->
{{ $payment->paid_at ? $payment->paid_at->format('d M Y, H:i') . ' WIB' : '-' }}

<!-- Payment Type -->
{{ ucwords(str_replace('_', ' ', $payment->payment_type ?? 'N/A')) }}

<!-- Invitation Title -->
{{ $invitation->title ?? 'N/A' }}
```

### 2. Array/JSON Compatibility
```blade
@foreach((is_array($package->features) ? $package->features : json_decode($package->features, true)) ?? [] as $feature)
```

Pattern ini handle 3 scenario:
1. ✅ `$package->features` adalah array (via cast) → gunakan langsung
2. ✅ `$package->features` adalah string JSON → decode dulu
3. ✅ `$package->features` adalah null → return empty array `[]`

---

## 📊 Files Changed Summary

| File | Changes | Reason |
|------|---------|--------|
| `resources/views/emails/payment-invoice.blade.php` | 2 fixes | Fix double json_decode & null safety |
| `tests/Feature/PaymentInvoiceEmailTest.php` | 1 fix | Handle array cast in test |

**Total:** 2 files modified, 3 bugs fixed

---

## 🎯 Root Cause Analysis

### Why This Happened?

1. **Laravel Model Cast** otomatis handle JSON conversion
2. Developer tidak aware field sudah di-cast sebagai `array`
3. Habit dari Laravel lama yang belum ada `casts` property
4. Copy-paste code tanpa cek model cast

### Prevention Tips:

1. **Always check model casts first:**
   ```bash
   # Quick check model casts
   grep -A 10 "casts()" app/Models/Package.php
   ```

2. **Use helper function:**
   ```php
   // Helper untuk handle array/json safely
   function ensureArray($data) {
       return is_array($data) ? $data : json_decode($data, true);
   }
   ```

3. **Enable strict types (PHP 8.4+):**
   ```php
   declare(strict_types=1);
   ```

---

## ✨ Verification Checklist

After fix, verify:

- [x] Email template render tanpa error
- [x] Features list tampil dengan benar
- [x] Null values tidak crash aplikasi
- [x] Test suite pass semua
- [x] Manual test via `invoice:test` sukses
- [x] Email terkirim dengan format benar

---

## 🚀 Deployment Notes

### Before Deploy:
```bash
# Clear all cache
php artisan optimize:clear

# Test di local dulu
php artisan invoice:test

# Run automated tests
php artisan test
```

### After Deploy:
```bash
# Di production server
php artisan config:clear
php artisan view:clear
php artisan optimize

# Test kirim invoice
php artisan invoice:test --email=admin@yourdomain.com
```

---

## 📚 Related Documentation

- [Laravel Eloquent Casts](https://laravel.com/docs/11.x/eloquent-mutators#attribute-casting)
- [Blade Null Coalescing](https://laravel.com/docs/11.x/blade#displaying-data)
- [PHP Type Juggling](https://www.php.net/manual/en/language.types.type-juggling.php)

---

## 🔗 Commit Message

```
fix: Resolve json_decode error in invoice email template

Fixed issues:
- Remove double json_decode on Package->features (already cast as array)
- Add null safety for Payment->paid_at field
- Add backward compatibility for array/json handling
- Update test to handle model cast

Changes:
- resources/views/emails/payment-invoice.blade.php (2 fixes)
- tests/Feature/PaymentInvoiceEmailTest.php (1 fix)

Tested:
✓ Manual test via 'php artisan invoice:test'
✓ Automated test suite
✓ Null value handling
✓ Array cast compatibility
```

---

**Status:** ✅ FIXED & TESTED  
**Impact:** High (Payment critical path)  
**Risk:** Low (Backward compatible)  
**Tested:** Yes (Manual + Automated)

