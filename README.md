# 🚀 Laravel AI Email Assistant

AI-powered email generation for Laravel applications using **OpenAI**
and **Google Gemini**, with reusable email templates, customizable
tones, and plain-text or HTML output.

## ✨ Key Features

-   🤖 Multiple AI providers --- OpenAI and Google Gemini
-   📝 Reusable email templates
-   🎨 Custom email tones --- friendly, formal, marketing, or custom
    tone text
-   📄 Plain-text and HTML output
-   🔌 Adapter architecture for AI providers
-   ⚙️ Publishable Laravel configuration
-   🧩 Laravel service provider and facade integration
-   🧪 PHPUnit and GitHub Actions support

## 📦 Requirements

-   PHP `>= 8.0`
-   Laravel 9, 10, or 11
-   Composer
-   API key for the selected AI provider

## 🛠️ Installation

Install using Composer:

``` bash
composer require omdiaries/laravel-ai-email-assistant
```

## ⚙️ Configuration

Publish the configuration file:

``` bash
php artisan vendor:publish --tag=ai-email-assistant-config
```

The configuration file will be available at:

``` text
config/aiemail.php
```

> The package service provider should use the publish tag
> `ai-email-assistant-config` for the command above.

### Select AI Provider

``` env
AI_PROVIDER=openai
```

Supported providers:

``` text
openai
gemini
```

### OpenAI

``` env
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
```

### Google Gemini

``` env
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
```

### Email Tone

``` env
AI_EMAIL_TONE=friendly
```

Examples:

``` text
formal
friendly
marketing
```

Custom tone text is also supported.

### Email Output

``` env
AI_EMAIL_OUTPUT=html
```

Supported formats:

``` text
plain
html
```

### Complete `.env` example

``` env
AI_PROVIDER=openai

OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini

GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash

AI_EMAIL_TONE=friendly
AI_EMAIL_OUTPUT=html
```

Only provide credentials for the provider you intend to use.

## ✉️ Email Templates

Built-in templates include:

-   `welcome`
-   `follow_up`
-   `invoice`
-   `support`

Templates are loaded from:

``` text
resources/ai-templates/
```

For example:

``` text
resources/ai-templates/
├── welcome.txt
├── welcome.html
├── follow_up.txt
├── follow_up.html
├── invoice.txt
├── invoice.html
├── support.txt
└── support.html
```

When HTML output is requested and an HTML template exists, the HTML
template is used. Otherwise the text template is used as a fallback.

If a requested template file does not exist, the package falls back to
its built-in default template.

## 🧩 Custom Templates

Add your own templates under:

``` text
resources/ai-templates/
```

For example:

``` text
payment_reminder.txt
payment_reminder.html
```

This allows reusable email content to be maintained separately from
application code.

## 🎨 Email Tones

Supported examples:

``` text
formal
friendly
marketing
```

A custom tone can also be supplied:

``` php
$email = $service->generateEmail(
    'Follow up with the customer regarding their pending payment',
    'professional',
    'html'
);
```

## 📄 Output Formats

### Plain Text

``` php
$email = $service->generateEmail(
    'Thank the customer for their order',
    'friendly',
    'plain'
);
```

### HTML

``` php
$email = $service->generateEmail(
    'Thank the customer for their order',
    'friendly',
    'html'
);
```

## 🤖 AI Providers

### OpenAI

``` env
AI_PROVIDER=openai
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
```

### Google Gemini

``` env
AI_PROVIDER=gemini
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
```

The provider architecture is designed to make additional AI providers
easier to add.

## 🏗️ AI Provider Architecture

The common AI client contract is:

``` php
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Example generic generation method:

``` php
public function generate(
    string $prompt,
    array $options = []
): string;
```

Email generation:

``` php
public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string;
```

Current adapter structure:

``` text
src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
└── Contracts/
    └── AIClientInterface.php
```

## ✉️ Using the Email Service

``` php
use OmDiaries\AIEmailAssistant\Services\AIEmailService;

$service = new AIEmailService();

$email = $service->generateEmail(
    'Write an email welcoming a new customer named John',
    'friendly',
    'html'
);
```

The generated content can then be used with Laravel's mail system:

``` php
Mail::to('customer@example.com')->send(
    new CustomerEmail($email)
);
```

## 🧠 Generic AI Text Generation

``` php
$result = $client->generate(
    'Summarize this customer message',
    []
);
```

Provider-specific options can be supplied through the options argument
where supported.

## 🔧 Adding a New AI Provider

Implement:

``` php
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Create an adapter under:

``` text
src/Adapters/YourAIProviderAdapter.php
```

Implement:

``` php
public function generate(
    string $prompt,
    array $options = []
): string
```

and:

``` php
public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string
```

Then register the provider through the package
configuration/service-provider integration.

## 🔐 Security

Never commit API keys to the repository.

Use environment variables:

``` env
OPENAI_API_KEY=your_openai_api_key
GEMINI_API_KEY=your_gemini_api_key
```

Make sure `.env` is excluded from version control.

## 🧪 Testing

Run:

``` bash
vendor/bin/phpunit
```

Validate Composer configuration with:

``` bash
composer validate
```

GitHub Actions can be used to validate the package on pushes and pull
requests.

## 📁 Project Structure

``` text
laravel-ai-email-assistant/
├── config/
│   └── aiemail.php
├── resources/
│   └── ai-templates/
├── src/
│   ├── Adapters/
│   ├── Console/
│   ├── Contracts/
│   ├── Data/
│   ├── Exceptions/
│   ├── Facades/
│   ├── Services/
│   ├── Support/
│   └── AIEmailServiceProvider.php
├── composer.json
└── README.md
```

## 💡 Typical Use Cases

-   Welcome emails
-   Invoice and payment reminders
-   Customer follow-ups
-   Customer support responses
-   Personalized transactional emails
-   AI-assisted business communication
-   Reusable email-template workflows

## 🚀 Package Purpose

The package provides a reusable Laravel foundation for AI-powered email
generation:

``` text
Laravel Application
       │
       ▼
AI Email Assistant
       │
       ├── Email Templates
       ├── Tone & Output
       │
       └── AI Provider
             ├── OpenAI
             └── Gemini
```

## 🤝 Contributing

Pull requests are welcome.

For new providers, features, bug fixes, templates, or documentation
improvements, please open an issue or pull request.

## 📄 License

This package is open-sourced under the MIT License.

Copyright © 2026 OmDiaries
