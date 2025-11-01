# 🧠 Laravel AI Email Assistant (by OmDiaries)

AI-powered Email Assistant for **Laravel 9, 10, and 11** — automatically generate personalized, well-structured emails (welcome, follow-up, sales pitch, and more) using **OpenAI** or **mock AI responses** for local testing.  
Built with ❤️ by **Om Diaries**.

---

## 🏷️ Badges
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)  
![Laravel](https://img.shields.io/badge/Laravel-9%2F10%2F11-red)  
![PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-blue)  
![AI Powered](https://img.shields.io/badge/AI-Enabled-success)  
![Stable](https://img.shields.io/badge/version-v1.0.23-green)

---

## 📘 Table of Contents
1. [Installation](#installation)  
2. [Configuration](#configuration)  
3. [Usage Example](#usage-example)  
4. [Mock Mode (No API Key)](#mock-mode-no-api-key)  
5. [Output Example](#output-example)  
6. [Testing](#testing)  
7. [Contributing](#contributing)  
8. [License](#license)

---

## ⚙️ Installation

```bash
composer require omdiaries/laravel-ai-email-assistant
```

---

## 🔧 Configuration (Checklist)

If not auto-published, manually publish the config file:

```bash
php artisan vendor:publish --tag=ai-email-config
```

Set your API key in `.env`:

```env
OPENAI_API_KEY=your_api_key_here
```

You can also customize settings in:
```
config/ai-email.php
```

---

## 🧩 Usage Example

```php
use OmDiaries\AIEmailAssistant\Facades\AIEmail;

$email = AIEmail::generate('welcome', [
    'customer_name' => 'Mike',
    'product' => 'AI Email Assistant',
    'company_name' => 'OM Diaries'
], [
    'tone' => 'friendly'
]);

dd($email);
```

---

## 🧠 Mock Mode (No API Key)

If the API key is missing, invalid, or quota is exceeded,  
the package **automatically switches to mock mode** and returns a **sample AI-generated email** — perfect for local testing.

**Example Output (Mock Mode):**
```php
[
    "subject" => "Welcome Mike to AI Email Assistant!",
    "body" => "Hi Mike, thank you for choosing AI Email Assistant by OM Diaries. We're thrilled to have you onboard!"
]
```

---

## 📨 Output Example

```text
Hi Mike,

Welcome to OM Diaries! We're thrilled to have you using our AI Email Assistant.
Get ready for smarter, automated communication powered by AI.

Cheers,  
The OM Diaries Team
```

---

## 🧪 Testing

You can test it quickly using a route in `web.php`:

```php
Route::get('/test-ai-email', function () {
    $email = AIEmail::generate('welcome', [
        'customer_name' => 'Mike',
        'product' => 'AI Email Assistant',
        'company_name' => 'OM Diaries'
    ]);
    return nl2br($email['body']);
});
```

Then open in your browser:
```
http://yourapp.test/test-ai-email
```

---

## 🧾 Changelog

### 🟢 v1.0.23 (Stable)
- Added **Mock Mode** for offline or quota-exceeded environments.  
- Improved error handling for missing API key.  
- Enhanced Laravel 11 compatibility.  
- Cleaned up internal service binding and facade references.

---

## 🤝 Contributing

Contributions are welcome!  
If you’d like to improve this package, fork the repo, make your changes, and submit a pull request.  
Your ideas help make AI email automation even better 🚀

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

✅ **Stable Version:** `v1.0.23`  
💡 **Next Planned Version:** `v1.1.0` – with customizable templates via config & multiple AI providers.
