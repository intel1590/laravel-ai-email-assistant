# 🧠 Laravel AI Email Assistant (by OmDiaries)

AI-powered Email Assistant for Laravel 9, 10, and 11 — automatically generate personalized, well-structured emails (welcome, follow-up, sales pitch, and more) using OpenAI or other AI models.  
Built with ❤️ by **Om Diaries**.

---

## 🏷️ Badges
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
![Laravel](https://img.shields.io/badge/Laravel-9%2F10%2F11-red)
![PHP](https://img.shields.io/badge/PHP-%3E%3D8.1-blue)
![AI Powered](https://img.shields.io/badge/AI-Enabled-success)

---

## 📘 Table of Contents
1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Mock Mode (No API Key)](#mock-mode-no-api-key)
4. [Usage Example](#usage-example)
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

## 🔧 Configuration
If not auto-published, manually publish the config file:

```bash
php artisan vendor:publish --tag=ai-email-config
```

Add your OpenAI API key in the `.env` file:
```
OPENAI_API_KEY=your_api_key_here
```

You can also modify the default configuration in:
```
config/ai-email.php
```

---

## 🧱 Mock Mode (No API Key)
If you don’t have an API key or just want to test locally, **Mock Mode** lets you simulate AI responses.

The package automatically switches to **mock mode** when:
- `OPENAI_API_KEY` is missing, invalid, or
- your API quota is exceeded.

When this happens, a **sample AI-generated email** will be returned (instead of calling the real API).  
Perfect for **local development** or **CI/CD testing**.

Example `.env` setup:
```
# Without real API key (enables Mock Mode)
OPENAI_API_KEY=
AI_EMAIL_MOCK=true
```

You’ll see a default output like:
```
Subject: Welcome to OM Diaries
Body: Hello Mike, welcome aboard! This is a sample AI email generated in mock mode.
```

---

## 🧩 Usage Example
```php
use AIEmail;

$email = AIEmail::generate('welcome', [
  'customer_name' => 'Mike',
  'product' => 'Pro Plan',
  'company_name' => 'OM Diaries'
], ['tone' => 'friendly']);
```

---

## 📨 Output Example
```text
Hi Mike,

Welcome to OM Diaries! We're thrilled to have you on our Pro Plan. 
Get ready for smarter communication powered by AI.

Cheers,  
The OM Diaries Team
```

---

## 🧪 Testing
You can test it quickly via a route in `web.php`:

```php
Route::get('/test-ai-email', function () {
    $email = AIEmail::generate('welcome', [
        'customer_name' => 'Mike',
        'product' => 'Pro Plan',
        'company_name' => 'OM Diaries'
    ]);
    return nl2br($email);
});
```

Then visit:
```
http://yourapp.test/test-ai-email
```

---

## 🤝 Contributing
Contributions are welcome!  
If you’d like to improve this package, feel free to fork the repo and create a pull request.

---

## 📄 License
This project is open-sourced under the [MIT License](LICENSE).
