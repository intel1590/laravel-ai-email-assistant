# 🚀 Laravel AI Email Assistant — v1.0.23 (Stable)

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)  
![License](https://img.shields.io/badge/license-MIT-green.svg)  
![Laravel](https://img.shields.io/badge/Laravel-9%2B-red.svg)

**AI-powered email generator for Laravel (9, 10, 11 compatible)**  
Generate professional, context-aware, and customizable emails using AI — directly from your Laravel app.

---

## 🧠 Key Features
✅ **Multi-AI Provider Support** — use **OpenAI**, **Gemini**, or add your own  
✅ **Customizable Tones** — *Formal*, *Friendly*, *Persuasive*, *Empathetic*, etc.  
✅ **Dynamic Output Types** — generate *plain text*, *HTML*, or *Markdown* emails  
✅ **Prebuilt Prompt Templates** — *Welcome*, *Invoice*, *Follow-up*, *Support*  
✅ **Extendable Template System** — easily define new templates  
✅ **Centralized Logging** — detailed request/response tracking via Laravel logs  
✅ **Configurable Error Handling** — automatic fallbacks when an AI provider fails  
✅ **Lightweight & Fast** — optimized for production  

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

**Step 3:** Add your environment variables  
```env
AI_PROVIDER=openai
AI_API_KEY=your_api_key_here
AI_TONE=formal
AI_OUTPUT_TYPE=html
```

**Step 4:** Generate an AI-based email using Artisan  
```bash
php artisan ai-email:generate welcome
```

---

## 💡 Example Usage (Controller)
```php
use OmDiaries\AiEmailAssistant\Facades\AiEmail;

$email = AiEmail::generate([
    'template' => 'invoice',
    'tone' => 'friendly',
    'outputType' => 'html',
]);

Mail::to('john@example.com')->send(new InvoiceMail($email));
```

---

## ⚙️ Supported Templates
- `welcome`
- `invoice`
- `followup`
- `support`

You can create your own custom templates under:
```
config/ai-email-assistant.php
```

---

## 🧩 Supported AI Providers
- **OpenAI (GPT Models)**
- **Google Gemini**
- *(More coming soon)*

You can easily extend it by creating a new Adapter class under:  
`app/Adapters/YourAIProviderAdapter.php`

---

## ⚙️ Advanced Settings (From Code Base)
```php
return [

    // Default AI provider
    'default_provider' => env('AI_PROVIDER', 'openai'),

    // Available providers
    'providers' => [
        'openai' => [
            'api_key' => env('AI_API_KEY'),
        ],
        'gemini' => [
            'api_key' => env('AI_API_KEY'),
        ],
    ],

    // Default tone for generated emails
    'default_tone' => env('AI_TONE', 'formal'),

    // Output type: text, html, markdown
    'default_output' => env('AI_OUTPUT_TYPE', 'html'),

    // Enable or disable logging of AI responses
    'logging' => true,

    // Prompt templates
    'templates' => [
        'welcome' => 'Write a warm welcome email for a new user...',
        'invoice' => 'Create a polite invoice reminder email...',
        'followup' => 'Generate a friendly follow-up email...',
        'support' => 'Generate a professional support response...',
    ],
];
```

---

## 🧠 AIEmailService Overview
The main service handles:
- ✅ Provider selection (`OpenAI`, `Gemini`, etc.)  
- ✅ Dynamic prompt generation from templates  
- ✅ Error-safe API calls with fallback strategy  
- ✅ Logging with `Log::info()` and `Log::error()`  
- ✅ Flexible output type formatting  

---

## 🔄 Upgrade Notes (from Beta)
- Added full multi-provider adapter support  
- Introduced advanced tone and output customization  
- Enhanced logging & debugging system  
- Improved exception handling for provider timeouts  
- Rewritten config system for flexibility  

---

## 🧑‍💻 Contributing
Pull requests are welcome!  
For new providers or features, please open an issue first to discuss the implementation.

---

## 🪪 License
This project is licensed under the **MIT License**.  
© 2025 OmDiaries — All rights reserved.
