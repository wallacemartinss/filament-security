<p align="center">
    <img src="art/banner.jpg" alt="Filament Security" width="100%">
</p>

# Filament Security

Security plugin for Filament v4 with six protection layers: **disposable email blocking**, **DNS/MX verification**, **RDAP domain age check**, **single session enforcement**, **honeypot bot protection**, and **automatic Cloudflare IP blocking**.

> **Note:** This is the `1.x` branch for **Filament v4**. For Filament v5, use the `2.x` branch (`main`).

## Requirements

- PHP 8.2+
- Laravel 11, 12 or 13
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
                ->singleSession()
                ->cloudflareBlocking(),
        ]);
}
```

## Layer 1: Disposable Email Blocking

Blocks registration with temporary/disposable email addresses. Ships with **192,000+ built-in domains** (sourced from [disposable/disposable-email-domains](https://github.com/disposable/disposable-email-domains)) and supports custom domains.

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
│ Built-in domains     │ 192,744 │
│ Custom file domains  │ 2      │
│ Config domains       │ 0      │
│ Whitelisted domains  │ 0      │
│ Total active domains │ 192,746 │
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
| Built-in | `data/disposable-domains.json` | Shipped with package (192,000+ domains) |
| Custom file | `storage/filament-security/custom-domains.txt` | `php artisan filament-security:domain` |
| Config | `config/filament-security.php` | Edit config file |
| Whitelist | `config/filament-security.php` | Edit config file (overrides all) |

## Layer 2: DNS/MX Verification

Verifies that the email domain has valid mail infrastructure. Blocks domains that **cannot receive email** — domains with no MX records and no A/AAAA fallback, or domains with MX records pointing to suspicious targets (localhost, private IPs).

### How it works

```
Email submitted → Extract domain → Check MX records
  ├─ Has MX → Validate targets (reject localhost, private IPs, loopback)
  ├─ No MX → Check A/AAAA records (RFC 5321 fallback)
  │   ├─ Has A/AAAA → Allow (can receive email via implicit MX)
  │   └─ No records → Block (domain cannot receive email)
  └─ DNS error → Allow (fail-open, don't block legitimate users)
```

### Enabled by default

DNS/MX verification is enabled by default and runs automatically on the registration form alongside the disposable email check. No extra setup required.

### Usage as Validation Rule

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DnsMxRule;

// In any form request or validator
'email' => ['required', 'email', new DnsMxRule],
```

### Programmatic Check

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\DnsVerificationService;

DnsVerificationService::isSuspicious('user@nonexistent-domain.xyz'); // true
DnsVerificationService::isSuspicious('user@gmail.com');               // false

// Check domain directly
DnsVerificationService::isDomainSuspicious('fake-domain.xyz'); // true
```

### Configuration

```php
// config/filament-security.php

'dns_verification' => [
    'enabled' => env('FILAMENT_SECURITY_DNS_CHECK', true),

    // Cache DNS results (recommended to avoid repeated lookups)
    'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),

    // Cache TTL in minutes (default: 1 hour)
    'cache_ttl' => 60,
],
```

### What is detected

| Condition | Result |
|-----------|--------|
| No MX, no A, no AAAA records | **Blocked** — domain cannot receive email |
| MX pointing to `localhost` | **Blocked** — suspicious configuration |
| MX pointing to private/reserved IP (127.x, 10.x, 192.168.x) | **Blocked** — not a real mail server |
| Valid MX records | **Allowed** |
| No MX but has A/AAAA record | **Allowed** — RFC 5321 implicit MX |
| DNS lookup fails | **Allowed** — fail-open to avoid false positives |

## Layer 3: Domain Age Verification (RDAP)

Checks the domain registration age via [RDAP](https://about.rdap.org/) (Registration Data Access Protocol), the modern successor to WHOIS. Blocks recently registered domains — a common pattern in spam, phishing, and fraud campaigns.

### How it works

```
Email submitted → Extract domain → Get TLD
  → Query IANA RDAP bootstrap (https://data.iana.org/rdap/dns.json)
  → Find RDAP server for TLD
  → Query RDAP server for domain registration date
  → Calculate domain age in days
  → Block if age < min_days
```

### Disabled by default

This feature makes external HTTP calls to RDAP servers, so it is **disabled by default**. Enable it via `.env`:

```env
FILAMENT_SECURITY_DOMAIN_AGE=true
FILAMENT_SECURITY_DOMAIN_MIN_DAYS=30
```

### Usage as Validation Rule

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\Rules\DomainAgeRule;

// In any form request or validator
'email' => ['required', 'email', new DomainAgeRule],
```

### Programmatic Check

```php
use WallaceMartinss\FilamentSecurity\DisposableEmail\RdapService;

RdapService::isDomainTooYoung('user@brand-new-domain.com'); // true (if < 30 days old)
RdapService::isDomainTooYoung('user@gmail.com');             // false

// Get the registration date directly
$date = RdapService::getRegistrationDate('example.com');
// Returns Carbon instance or null
```

### Configuration

```php
// config/filament-security.php

'domain_age' => [
    'enabled' => env('FILAMENT_SECURITY_DOMAIN_AGE', false),

    // Minimum domain age in days
    'min_days' => env('FILAMENT_SECURITY_DOMAIN_MIN_DAYS', 30),

    // Block when RDAP lookup fails? (conservative: false)
    'block_on_failure' => env('FILAMENT_SECURITY_DOMAIN_AGE_STRICT', false),

    // Cache RDAP results (recommended — external HTTP calls)
    'cache_enabled' => env('FILAMENT_SECURITY_CACHE', true),

    // Cache TTL in minutes (default: 24 hours)
    'cache_ttl' => 1440,
],
```

### Failure behavior

| Scenario | `block_on_failure=false` (default) | `block_on_failure=true` |
|----------|-----------------------------------|------------------------|
| RDAP server unreachable | Allow | Block |
| TLD not in IANA bootstrap | Allow | Block |
| No registration date in response | Allow | Block |
| Domain age >= min_days | Allow | Allow |
| Domain age < min_days | Block | Block |

### Caching

RDAP results are cached to minimize external HTTP calls:

- **IANA bootstrap data** — cached for 24 hours (shared across all domains)
- **Domain registration dates** — cached for 24 hours (per domain, configurable via `cache_ttl`)

## Layer 4: Single Session Enforcement

Ensures only **one active session per user**. When a user logs in from a new browser or device, all previous sessions are immediately terminated. Works with both **database** and **Redis** session drivers.

### How it works

```
User logs in on Browser A → Session A created, tracked as active
User logs in on Browser B → Session B created
  → Login event fires → Session A destroyed
  → Middleware updates active session to B
User returns to Browser A → Session A no longer exists → Redirected to login
```

### Disabled by default

Enable via `.env`:

```env
FILAMENT_SECURITY_SINGLE_SESSION=true
```

And in the plugin:

```php
FilamentSecurityPlugin::make()
    ->singleSession()
```

### Session driver support

| Driver | Destruction method | Enforcement |
|--------|-------------------|-------------|
| `database` | Bulk DELETE from `sessions` table by `user_id` | Immediate (session row deleted) |
| `redis` | Destroy session key via session handler | Immediate (key deleted) + middleware fallback |
| `file` | Destroy session file via session handler | Immediate (file deleted) + middleware fallback |

For the **database** driver, all other sessions for the user are deleted in a single query on login. For **Redis** and **file** drivers, the previously tracked session is destroyed via the session handler, and a middleware acts as a safety net to catch any edge cases.

### Architecture

The feature uses a **dual mechanism** for reliability:

1. **Login event listener** (`HandleSuccessfulLogin`) — immediately destroys other sessions on login
2. **Middleware** (`SingleSessionMiddleware`) — validates on every request that the current session is still the active one

The middleware is automatically registered in the `web` middleware group when the feature is enabled.

### Programmatic Usage

```php
use WallaceMartinss\FilamentSecurity\SingleSession\SingleSessionService;

// Invalidate all other sessions for a user (call after manual login)
SingleSessionService::handleLogin($user);

// Clear session tracking (call on manual logout)
SingleSessionService::clearTracking($user->id);
```

### Configuration

```php
// config/filament-security.php

'single_session' => [
    'enabled' => env('FILAMENT_SECURITY_SINGLE_SESSION', false),
],
```

### Requirements

- Session driver must be `database`, `redis`, or `file`
- For `database`: the `sessions` table must exist (ships with Laravel by default)
- Cache driver must be configured (used for session tracking across drivers)

## Layer 5: Honeypot Protection

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

When spam is detected, the request is aborted with a `403 Forbidden` response. A `SpamDetectedEvent` is also fired, which you can listen to for logging or IP blocking (Layer 6).

## Layer 6: Cloudflare IP Blocking

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

### How to get your Cloudflare credentials

#### API Token

1. Go to [Cloudflare Dashboard > My Profile > API Tokens](https://dash.cloudflare.com/profile/api-tokens)
2. Click **"Create Token"**
3. Select **"Create Custom Token"**
4. Configure the token:
   - **Token name:** `FilamentSecurity`
   - **Permissions:** `Zone` > `Firewall Services` > `Edit`
   - **Zone Resources:** `Include` > `Specific zone` > select your domain
5. Click **"Continue to summary"** > **"Create Token"**
6. Copy the token and add to your `.env` as `CLOUDFLARE_API_TOKEN`

#### Zone ID

1. Go to [Cloudflare Dashboard](https://dash.cloudflare.com) and select your domain
2. On the **Overview** page, scroll down to the right sidebar
3. Under **API** section, copy the **Zone ID**
4. Add to your `.env` as `CLOUDFLARE_ZONE_ID`

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
FILAMENT_SECURITY_DISPOSABLE_EMAIL=true   # Enable/disable disposable email blocking
FILAMENT_SECURITY_CACHE=true              # Enable/disable caching (shared across features)

# DNS/MX Verification
FILAMENT_SECURITY_DNS_CHECK=true          # Enable/disable DNS/MX check (default: enabled)

# Domain Age (RDAP)
FILAMENT_SECURITY_DOMAIN_AGE=false        # Enable/disable domain age check (default: disabled)
FILAMENT_SECURITY_DOMAIN_MIN_DAYS=30      # Minimum domain age in days
FILAMENT_SECURITY_DOMAIN_AGE_STRICT=false # Block when RDAP lookup fails

# Single Session
FILAMENT_SECURITY_SINGLE_SESSION=false    # Enable/disable one session per user (default: disabled)

# Honeypot
FILAMENT_SECURITY_HONEYPOT=true           # Enable/disable honeypot protection

# Cloudflare
FILAMENT_SECURITY_CLOUDFLARE=false        # Enable/disable Cloudflare blocking
CLOUDFLARE_API_TOKEN=                     # Cloudflare API token
CLOUDFLARE_ZONE_ID=                       # Cloudflare zone ID
FILAMENT_SECURITY_CF_MAX_ATTEMPTS=5       # Failed attempts before blocking
FILAMENT_SECURITY_CF_DECAY_MINUTES=30     # Time window for counting attempts
FILAMENT_SECURITY_CF_MODE=block           # 'block' or 'challenge'
```

## Testing

```bash
php artisan test packages/filament-security/tests/
```

## Translations

The package includes translations in **15 languages**: English, Brazilian Portuguese, German, Spanish, French, Italian, Japanese, Korean, Dutch, Polish, Russian, Turkish, Ukrainian, Arabic, and Chinese (Simplified).

To publish translations:

```bash
php artisan vendor:publish --tag=filament-security-translations
```

## License

MIT License. See [LICENSE](LICENSE) for details.
