# 🚀 Laravel AI Email Assistant

AI-powered email generation for Laravel 9, 10, and 11 with support for OpenAI and Google Gemini.

Generate professional, customizable emails using reusable templates and AI directly from your Laravel application.

## 🧠 Features

- ✅ OpenAI support
- ✅ Google Gemini support
- ✅ Common AI client interface
- ✅ Provider adapter architecture
- ✅ AI-powered email generation
- ✅ Reusable email templates
- ✅ Built-in email templates
- ✅ Custom `.txt` and `.html` templates
- ✅ Customizable email tones
- ✅ Plain text and HTML output
- ✅ Laravel configuration publishing
- ✅ Placeholder replacement using `{{variable}}`
- ✅ Centralized Laravel logging
- ✅ Error handling
- ✅ Laravel 9, 10, and 11 support
- ✅ PHP 8.0+

---

## 📦 Installation

Install the package using Composer:

```bash
composer require omdiaries/laravel-ai-email-assistant
```

## Publish Configuration

Publish the package configuration file:

```bash
php artisan vendor:publish --tag=ai-email-assistant-config
```

The configuration file will be available at:

```text
config/aiemail.php
```

---

## ⚙️ Configuration

The package supports OpenAI and Google Gemini as AI providers.

### Select AI Provider

Set the default provider in your `.env` file:

```env
AI_PROVIDER=openai
```

Supported providers:

```text
openai
gemini
```

### OpenAI

```env
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
```

### Google Gemini

```env
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
```

You only need to provide the API key for the provider you intend to use.

### Email Tone

```env
AI_EMAIL_TONE=friendly
```

Examples:

```text
formal
friendly
marketing
```

Custom tone text is also supported.

### Email Output

```env
AI_EMAIL_OUTPUT=html
```

Supported formats:

```text
plain
html
```

### Complete `.env` Example

```env
AI_PROVIDER=openai

OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini

GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash

AI_EMAIL_TONE=friendly
AI_EMAIL_OUTPUT=html
```

---

## ✉️ Generate an AI Email

Use `AIEmailService` to generate an email from a template.

```php
use OmDiaries\AIEmailAssistant\Services\AIEmailService;

$service = new AIEmailService();

$email = $service->generate('welcome', [
    'customer_name' => 'John',
    'product' => 'My Product',
    'company_name' => 'Om Diaries',
]);
```

The package resolves the requested template, replaces its placeholders, builds an AI prompt, and sends it to the configured provider.

---

## 📝 Email Templates

Built-in templates include:

- `welcome`
- `follow_up`
- `invoice`
- `support`

Custom templates are loaded from:

```text
resources/ai-templates/
```

### Plain Text Template

Create `resources/ai-templates/welcome.txt`:

```text
Subject: Welcome to {{product}}

Hello {{customer_name}},

Welcome to {{product}}! We're excited to have you.

Best regards,
{{company_name}}
```

### HTML Template

Create `resources/ai-templates/welcome.html`.

When HTML output is requested, the HTML template is preferred. If it is unavailable, the package falls back to the `.txt` template.

### Template Resolution

Templates are resolved in this order:

1. HTML template when HTML output is requested and a matching `.html` file exists.
2. Plain text `.txt` template.
3. Built-in package template.
4. An exception is thrown if the requested template does not exist.

---

## 🔤 Template Placeholders

Templates can use placeholders such as:

```text
{{customer_name}}
{{product}}
{{company_name}}
```

Pass values when generating the email:

```php
$email = $service->generate('welcome', [
    'customer_name' => 'John',
    'product' => 'My Product',
    'company_name' => 'Om Diaries',
]);
```

Dynamic values are escaped when HTML output is enabled.

---

## 🎨 Email Tones

Supported examples:

```text
formal
friendly
marketing
```

Custom tones are also supported, for example:

```env
AI_EMAIL_TONE=professional and concise
```

---

## 📄 Output Formats

### Plain Text

```env
AI_EMAIL_OUTPUT=plain
```

### HTML

```env
AI_EMAIL_OUTPUT=html
```

The configured AI provider will be instructed to generate the requested output format.

---

## 🤖 Supported AI Providers

### OpenAI

Adapter:

```text
src/Adapters/OpenAIAdapter.php
```

Configuration:

```env
AI_PROVIDER=openai
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
```

### Google Gemini

Adapter:

```text
src/Adapters/GeminiAdapter.php
```

Configuration:

```env
AI_PROVIDER=gemini
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
```

Both providers implement the same `AIClientInterface`.

---

## 🧩 AI Provider Architecture

Common contract:

```text
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Generic AI text generation:

```php
public function generate(
    string $prompt,
    array $options = []
): string;
```

Email generation:

```php
public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string;
```

Current structure:

```text
src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
├── Contracts/
│   └── AIClientInterface.php
├── Services/
│   └── AIEmailService.php
└── Support/
    └── PromptTemplates.php
```

---

## 🔧 Generic AI Text Generation

Adapters support generic text generation through the common interface:

```php
$client->generate(
    'Summarize this customer message',
    [
        'temperature' => 0.2,
    ]
);
```

Provider-specific options can be passed through the `$options` array.

---

## 🔧 Adding a New AI Provider

Implement:

```text
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Create an adapter:

```text
src/
└── Adapters/
    └── YourAIProviderAdapter.php
```

Implement both interface methods:

```php
public function generate(
    string $prompt,
    array $options = []
): string;
```

```php
public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string;
```

Then register the provider through the package configuration/service architecture.

---

## 🔐 Security

Never commit API keys to your repository.

Use your application's `.env` file:

```env
OPENAI_API_KEY=your_openai_api_key
GEMINI_API_KEY=your_gemini_api_key
```

Make sure `.env` is excluded from version control.

---

## 🧪 Testing

Run the PHPUnit test suite with:

```bash
vendor/bin/phpunit
```

---

## 📁 Project Structure

```text
src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
├── Contracts/
│   └── AIClientInterface.php
├── Services/
│   └── AIEmailService.php
└── Support/
    └── PromptTemplates.php

config/
└── aiemail.php

resources/
└── ai-templates/
```

---

## 📋 Requirements

- PHP `>= 8.0`
- Laravel 9
- Laravel 10
- Laravel 11
- Composer
- API key for the selected AI provider

---

## 🤝 Contributing

Pull requests are welcome.

For new AI providers, bug fixes, improvements, or major features, please open an issue first to discuss the proposed implementation.

---

## 🪪 License

This package is open-sourced software licensed under the MIT License.

© 2026 OmDiaries
