# Filament Security

Security plugin for Filament v4 with three protection pillars: **disposable email blocking**, **honeypot bot protection**, and **automatic Cloudflare IP blocking**.

> **Note:** This is the `1.x` branch for **Filament v4**. For Filament v5, use the `2.x` branch (`main`).

## Requirements

- PHP 8.2+
- Laravel 11 or 12
- Filament v4

## Installation

```bash
# Filament v4
composer require wallacemartinss/filament-security:"^1.0"

# Filament v5
composer require wallacemartinss/filament-security:"^2.0"
```

Publish the config file:

```bash
php artisan filament-security:install
```

Register the plugin in your `AdminPanelProvider` (**after** `->registration()`):

```php
use WallaceMartinss\FilamentSecurity\FilamentSecurityPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->login()
        ->registration() // Must come before ->plugins()
        // ...
        ->plugins([
            FilamentSecurityPlugin::make()
                ->disposableEmailProtection()
                ->honeypotProtection()
                ->cloudflareBlocking(),
        ]);
}
```

## Pillar 1: Disposable Email Blocking

Blocks registration with temporary/disposable email addresses. Ships with **72,000+ built-in domains** (sourced from [disposable/disposable-email-domains](https://github.com/disposable/disposable-email-domains)) and supports custom domains.

Covers all major disposable email providers including Mailinator, YOPmail, GuerrillaMail (all 11 variants), TempMail, ThrowAway, Burner Mail, and thousands more.

### Filament Registration Integration

When `disposableEmailProtection()` is enabled, the plugin **automatically** replaces the default Filament registration page with a secured version that validates emails against the disposable domain list. No extra configuration needed.

The plugin only replaces the default `Register::class`. If you have a custom registration page, use the trait instead:

```php
use Filament\Auth\Pages\Register;
use WallaceMartinss\FilamentSecurity\Auth\Concerns\HasDisposableEmailProtection;

class CustomRegister extends Register
{
    use HasDisposableEmailProtection;
}
```

### Usage as Validation Rule

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DisposableEmailRule;

// In any form request or validator
'email' => ['required', 'email', new DisposableEmailRule],
```

### Usage in Filament Forms

```php
use Filament\Forms\Components\TextInput;
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DisposableEmailRule;

TextInput::make('email')
    ->email()
    ->rules([new DisposableEmailRule])
```

### Programmatic Check

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\DisposableEmailService;

DisposableEmailService::isDisposable('user@mailinator.com'); // true
DisposableEmailService::isDisposable('user@gmail.com');      // false
```

### Managing Custom Domains

Add, remove, list, or view stats of custom blocked domains via artisan:

```bash
# Add a domain
php artisan filament-security:domain add spam-provider.com

# Remove a domain
php artisan filament-security:domain remove spam-provider.com

# List custom domains
php artisan filament-security:domain list

# View statistics
php artisan filament-security:domain stats
```

Output of `stats`:

```
┌──────────────────────┬────────┐
│ Source               │ Count  │
├──────────────────────┼────────┤
│ Built-in domains     │ 72,248 │
│ Custom file domains  │ 2      │
│ Config domains       │ 0      │
│ Whitelisted domains  │ 0      │
│ Total active domains │ 72,250 │
└──────────────────────┴────────┘
```

### Configuration

```php
// config/filament-security.php

'disposable_email' => [
    'enabled' => env('FILAMENT_SECURITY_DISPOSABLE_EMAIL', true),

    // Cache the domain list (recommended)
    'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),
    'cache_ttl' => 1440, // minutes (24h)

    // Additional domains to block
    'custom_domains' => [
        'my-spam-domain.com',
    ],

    // Domains to allow even if in the block list
    'whitelisted_domains' => [
        'company-internal-temp.com',
    ],
],
```

### Domain Sources (priority order)

| Source | Location | How to manage |
|--------|----------|---------------|
| Built-in | `data/disposable-domains.json` | Shipped with package (72,000+ domains) |
| Custom file | `storage/filament-security/custom-domains.txt` | `php artisan filament-security:domain` |
| Config | `config/filament-security.php` | Edit config file |
| Whitelist | `config/filament-security.php` | Edit config file (overrides all) |

## Pillar 2: Honeypot Protection

Protects registration forms against bots using invisible honeypot fields. Powered by [spatie/laravel-honeypot](https://github.com/spatie/laravel-honeypot).

### How it works

Two invisible fields are injected into the registration form:

1. **Empty field** - Bots auto-fill all fields; if this field has a value, the submission is rejected
2. **Timestamp field** - Tracks how fast the form was submitted; instant submissions are rejected

### Filament Registration Integration

When `honeypotProtection()` is enabled, the honeypot fields are **automatically** injected into the registration form. The `protectAgainstSpam()` check runs before user creation.

No extra configuration needed beyond enabling it in the plugin:

```php
FilamentSecurityPlugin::make()
    ->honeypotProtection()
```

### Custom Registration Page

If you have a custom registration page, use the trait:

```php
use Filament\Auth\Pages\Register;
use WallaceMartinss\FilamentSecurity\Auth\Concerns\HasHoneypotProtection;

class CustomRegister extends Register
{
    use HasHoneypotProtection;
}
```

### Honeypot Configuration

The honeypot behavior is configured via Spatie's config file:

```bash
php artisan vendor:publish --tag=honeypot-config
```

```php
// config/honeypot.php

return [
    'enabled' => env('HONEYPOT_ENABLED', true),
    'name_field_name' => 'my_name',
    'randomize_name_field_name' => true,
    'valid_from_field_name' => 'valid_from',
    'amount_of_seconds' => 1, // Minimum seconds before submission is valid
    'respond_to_spam_with' => \Spatie\Honeypot\SpamResponder\BlankPageResponder::class,
];
```

### Spam Detection Response

When spam is detected, the request is aborted with a `403 Forbidden` response. A `SpamDetectedEvent` is also fired, which you can listen to for logging or IP blocking (Pillar 3).

## Pillar 3: Cloudflare IP Blocking

Automatically blocks suspicious IPs on Cloudflare WAF after repeated failed login attempts or bot detection via honeypot.

### How it works

```
Failed Login → RateLimiter counts attempts → Exceeds threshold → Cloudflare API block
Honeypot Spam → Instant Cloudflare API block
```

The package resolves the **real client IP** through the header chain:
`CF-Connecting-IP` > `X-Real-IP` > `X-Forwarded-For` > `REMOTE_ADDR`

### Setup

1. Add your Cloudflare credentials to `.env`:

```env
FILAMENT_SECURITY_CLOUDFLARE=true
CLOUDFLARE_API_TOKEN=your_api_token_here
CLOUDFLARE_ZONE_ID=your_zone_id_here
```

2. Publish and run the migration:

```bash
php artisan vendor:publish --tag=filament-security-migrations
php artisan migrate
```

3. Enable in the plugin:

```php
FilamentSecurityPlugin::make()
    ->disposableEmailProtection()
    ->honeypotProtection()
    ->cloudflareBlocking()
```

### Cloudflare API Token

Create a token at [Cloudflare Dashboard](https://dash.cloudflare.com/profile/api-tokens) with permissions:

- **Zone > Firewall Services > Edit**

### Automatic Blocking Triggers

| Trigger | Behavior |
|---------|----------|
| Failed login attempts | Blocks after `max_attempts` (default: 5) within `decay_minutes` (default: 30) |
| Honeypot spam detected | **Instant block** - no threshold needed |

Both triggers are registered via Laravel event listeners:
- `Illuminate\Auth\Events\Failed` → `HandleFailedLogin`
- `Spatie\Honeypot\Events\SpamDetectedEvent` → `HandleSpamDetected`

### Managing Blocked IPs

```bash
# List active blocks
php artisan filament-security:blocked-ips list

# View configuration status
php artisan filament-security:blocked-ips status

# Manually block an IP
php artisan filament-security:blocked-ips block 203.0.113.50 --reason="Manual block"

# Unblock an IP
php artisan filament-security:blocked-ips unblock 203.0.113.50 --force
```

Output of `status`:

```
┌─────────────────────────┬───────┐
│ Setting                 │ Value │
├─────────────────────────┼───────┤
│ Cloudflare configured   │ Yes   │
│ Cloudflare enabled      │ Yes   │
│ Block mode              │ block │
│ Max attempts            │ 5     │
│ Decay minutes           │ 30    │
│ Active blocks           │ 3     │
│ Total blocks (all time) │ 12    │
└─────────────────────────┴───────┘
```

### Programmatic Usage

```php
use WallaceMartinss\FilamentSecurity\Cloudflare\BlockIpService;
use WallaceMartinss\FilamentSecurity\Cloudflare\IpResolver;

// Resolve real client IP
$ip = IpResolver::resolve();

// Block an IP
app(BlockIpService::class)->blockIp($ip, 'Custom reason');

// Unblock an IP
app(BlockIpService::class)->unblockIp($ip);

// Record a failed attempt (auto-blocks on threshold)
app(BlockIpService::class)->recordFailedAttempt($ip, 'Failed login');

// Check remaining attempts
app(BlockIpService::class)->remainingAttempts($ip);
```

### Configuration

```php
// config/filament-security.php

'cloudflare' => [
    'enabled' => env('FILAMENT_SECURITY_CLOUDFLARE', false),
    'api_token' => env('CLOUDFLARE_API_TOKEN'),
    'zone_id' => env('CLOUDFLARE_ZONE_ID'),
    'max_attempts' => env('FILAMENT_SECURITY_CF_MAX_ATTEMPTS', 5),
    'decay_minutes' => env('FILAMENT_SECURITY_CF_DECAY_MINUTES', 30),
    'mode' => env('FILAMENT_SECURITY_CF_MODE', 'block'), // 'block' or 'challenge'
    'note_prefix' => 'FilamentSecurity: Auto-blocked',
],
```

## Environment Variables

```env
# Disposable Email
FILAMENT_SECURITY_DISPOSABLE_EMAIL=true
FILAMENT_SECURITY_CACHE=true

# Honeypot
FILAMENT_SECURITY_HONEYPOT=true

# Cloudflare
FILAMENT_SECURITY_CLOUDFLARE=false
CLOUDFLARE_API_TOKEN=
CLOUDFLARE_ZONE_ID=
FILAMENT_SECURITY_CF_MAX_ATTEMPTS=5
FILAMENT_SECURITY_CF_DECAY_MINUTES=30
FILAMENT_SECURITY_CF_MODE=block
```

## Testing

```bash
php artisan test packages/filament-security/tests/
```

## Translations

The package includes translations in **English** and **Brazilian Portuguese** (`pt_BR`).

To publish translations:

```bash
php artisan vendor:publish --tag=filament-security-translations
```

## License

MIT License. See [LICENSE](LICENSE) for details.
