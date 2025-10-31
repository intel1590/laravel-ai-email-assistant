# 🧩 Laravel AI Email Assistant (by OmDiaries)

AI-powered Email Assistant for **Laravel 9, 10, and 11** — automatically generate personalized, well-structured emails like **welcome messages**, **follow-ups**, **sales pitches**, and **reminders**, powered by OpenAI or other AI APIs.

---

## ⚡ Quick Start

1️⃣ **Install the package**
```bash
composer require omdiaries/laravel-ai-email-assistant
```

2️⃣ **Publish config & set your API key**
```bash
php artisan vendor:publish --tag=ai-email-config
```
Then add this to your `.env` file:
```env
OPENAI_API_KEY=your_real_openai_api_key
AI_EMAIL_MODEL=gpt-3.5-turbo
AI_EMAIL_DEFAULT_TONE=friendly
AI_EMAIL_LANGUAGE=en
```

3️⃣ **Test your setup**
```bash
php artisan ai-email:test
```
✅ You should see:
```
AI Email Assistant is configured correctly!
Model: gpt-3.5-turbo
Tone: friendly
```

---

## ⚙️ Configuration (Detailed)

If needed, you can manually adjust:
```
config/ai-email.php
```

For Laravel 8 or 9, add the service provider manually:
```php
'providers' => [
    OmDiaries\AIEmail\AIEmailServiceProvider::class,
],
```
Laravel 10+ will auto-discover it.

---

## 🧠 Usage Example

```php
use AIEmail;

$email = AIEmail::generate('welcome', [
    'customer_name' => 'Mick',
    'product' => 'Pro Plan',
    'company_name' => 'OM Diaries'
], [
    'tone' => 'friendly',
]);

echo $email;
```

✅ **Output Example:**
> Hi Radhika,  
> Welcome to OM Diaries! We’re thrilled to have you with us on the Pro Plan.  
> Let’s make something amazing together!  
> — The OM Diaries Team

---

## 🧾 Testing

### ✅ Option 1: Test via Route
Add this to your `routes/web.php`:
```php
use Illuminate\Support\Facades\Route;
use AIEmail;

Route::get('/test-ai-email', function () {
    $email = AIEmail::generate('welcome', [
        'customer_name' => 'Radhika',
        'product' => 'Pro Plan',
        'company_name' => 'OM Diaries'
    ]);
    return nl2br($email);
});
```

Then visit:  
👉 http://127.0.0.1:8000/test-ai-email

### ✅ Option 2: Test via Artisan Command
```bash
php artisan ai-email:test
```

---

## ✨ Features

- 🧩 AI-powered email generation (welcome, marketing, reminders, etc.)
- 🎨 Custom tone, language, and style
- 🔧 Plug-and-play Laravel integration
- 🌍 Works with any AI API (OpenAI, Gemini, Claude, etc.)
- ⚡ Lightweight and developer-friendly

---

## 🧰 Troubleshooting

| Issue | Possible Fix |
|-------|---------------|
| `AIEmail class not found` | Add provider manually or clear config cache. |
| `Missing OPENAI_API_KEY` | Ensure `.env` key exists and run `php artisan config:clear`. |
| Timeout / Blank Response | Check internet connection and API key validity. |
| Config not working | Run `php artisan vendor:publish --tag=ai-email-config --force` |

---

## 🪄 License

This package is open-sourced under the [MIT License](LICENSE).
