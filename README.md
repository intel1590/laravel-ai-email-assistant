# 🚀 Laravel AI Email Assistant (Beta)

**AI-powered email generator for Laravel (9, 10, 11 compatible)**  
Easily generate professional, context-aware emails using AI — directly from your Laravel app.

---

## 🧠 What’s New in Beta Version
✅ **Support for multiple AI providers** — use **OpenAI**, **Gemini**, and more  
✅ **Customizable tone options** — choose between *Formal*, *Friendly*, *Persuasive*, and others  
✅ **Prebuilt prompt templates** — includes *Welcome*, *Invoice*, *Follow-up*, and *Support*  
✅ **Improved template engine** — enhanced for dynamic personalization  
✅ **Enhanced error handling** and stable **API integrations**  
✅ **General bug fixes** and **performance improvements**

---

## 🛠️ Installation

**Step 1:** Install the package via Composer  
```bash
composer require omdiaries/laravel-ai-email-assistant
```

**Step 2:** Publish the configuration file  
```bash
php artisan vendor:publish --tag=ai-email-assistant-config
```

**Step 3:** Set your API key(s) in `.env`  
```env
AI_PROVIDER=openai
AI_API_KEY=
```

**Step 4:** Use the Artisan command to generate an email  
```bash
php artisan ai-email:generate welcome
```

---

## 💡 Example Usage (In Controller)
```php
use OmDiaries\AiEmailAssistant\Facades\AiEmail;

$email = AiEmail::generate([
    'template' => 'invoice',
    'tone' => 'formal',
]);

Mail::to('john@example.com')->send(new InvoiceMail($email));
```

---

## ⚙️ Supported Templates
- `welcome`
- `invoice`
- `followup`
- `support`

You can also define your own templates in `config/ai-email-assistant.php`.

---

## 🧩 Supported AI Providers
- **OpenAI (GPT Models)**
- **Google Gemini**
- (More coming soon)

---

## 🧰 Config Options
```php
return [
    'default_provider' => env('AI_PROVIDER', 'openai'),
    'providers' => [
        'openai' => [
            'api_key' => env('AI_API_KEY'),
        ],
        'gemini' => [
            'api_key' => env('AI_API_KEY'),
        ],
    ],
];
```

---

## 🧑‍💻 Contributing
Pull requests are welcome!  
For major changes, please open an issue first to discuss what you’d like to change.

---

## 🪪 License
This project is licensed under the **MIT License**.
