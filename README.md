# 🚀 Laravel AI Email Assistant

AI-powered email generation for Laravel 9, 10, and 11 with support for OpenAI and Google Gemini.

Generate professional, customizable emails using AI directly from your Laravel application.

---

## 🧠 Features

- ✅ OpenAI support
- ✅ Google Gemini support
- ✅ Provider adapter architecture
- ✅ AI-powered email generation
- ✅ Customizable email tones
- ✅ Plain text and HTML output
- ✅ Prebuilt email templates
- ✅ Extendable template system
- ✅ Centralized Laravel logging
- ✅ Error handling
- ✅ Laravel 9, 10, and 11 support
- ✅ PHP 8.0+

---

## 📦 Installation

Install the package using Composer:

```bash

composer require omdiaries/laravel-ai-email-assistant



## Publish the configuration file:

php artisan vendor:publish --tag=ai-email-assistant-config

## The configuration file will be available at:

config/aiemail.php

⚙️ ## Configuration

The package supports OpenAI and Google Gemini as AI providers.

## Select AI Provider

Set the default AI provider in your .env file:

AI_PROVIDER=openai

## Supported providers:

openai
gemini
OpenAI Configuration
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
Google Gemini Configuration
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
Email Tone

## Configure the default email tone:

AI_EMAIL_TONE=friendly

Supported examples:

formal
friendly
marketing

Custom tone text is also supported.

## Email Output

Configure the default email output format:

## AI_EMAIL_OUTPUT=html

## Supported formats:

plain
html
Complete .env Example
AI_PROVIDER=openai

OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini

GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash

AI_EMAIL_TONE=friendly
AI_EMAIL_OUTPUT=html

You only need to provide the API key for the provider you intend to use.

✉️ ## Generate an AI Email

The package provides AI-powered email generation through the AI email service.

Example:

use OmDiaries\AIEmailAssistant\Services\AIEmailService;

$service = new AIEmailService();

$email = $service->generateEmail(
    'Write an email welcoming a new customer named John',
    'friendly',
    'html'
);

The generated email can then be used with Laravel's mail system.

🤖 ## Supported AI Providers
## OpenAI

OpenAI is supported through the package's OpenAI adapter.

The adapter communicates with the OpenAI API using Laravel's HTTP client.

## Google Gemini

Google Gemini is supported through the package's Gemini adapter.

The adapter communicates with the Gemini API using Laravel's HTTP client.

Both providers implement the same AI client interface, allowing the provider implementation to be changed without changing the email-generation contract.

🧩 ## AI Provider Architecture

The package uses a common AI client contract:

OmDiaries\AIEmailAssistant\Contracts\AIClientInterface

## The interface provides email generation through:

public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string;

## Current adapters:

src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
│
└── Contracts/
    └── AIClientInterface.php

This adapter architecture makes it easier to add additional AI providers in the future.

📝 ## Email Templates

The package supports prebuilt email templates.

Examples include:

welcome
invoice
followup
support

Templates can be extended according to your application's requirements.

🎨 ## Email Tones

You can customize the tone of generated emails.

## Examples:

formal
friendly
marketing

You can also provide a custom tone.

Example:

$email = $service->generateEmail(
    'Follow up with the customer regarding their pending payment',
    'professional',
    'html'
);
📄 Output Formats

The package supports two output formats.

Plain Text
$email = $service->generateEmail(
    'Thank the customer for their order',
    'friendly',
    'plain'
);
HTML
$email = $service->generateEmail(
    'Thank the customer for their order',
    'friendly',
    'html'
);
🔧 Adding a New AI Provider

To add another AI provider, implement:

OmDiaries\AIEmailAssistant\Contracts\AIClientInterface

Create a new adapter:

src/
└── Adapters/
    └── YourAIProviderAdapter.php

Implement the required method:

public function generateEmail(
    string $prompt,
    string $tone = 'friendly',
    string $output = 'plain'
): string

Then register the provider through the package configuration/service provider.

This allows new AI providers to be integrated without changing the core email-generation contract.

🔐 ## Security

Never commit API keys to your repository.

Use your application's .env file:

OPENAI_API_KEY=your_openai_api_key
GEMINI_API_KEY=your_gemini_api_key

Make sure .env is excluded from version control.

🧪 ## Testing

The package can be tested using Composer and PHPUnit.

## Run the test suite with:

vendor/bin/phpunit

## GitHub Actions is also configured for automated PHP validation.

📁 ## Project Structure

src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
├── Contracts/
│   └── AIClientInterface.php
├── Data/
│   └── EmailAnalysis.php
├── Services/
│   ├── AIEmailService.php
│   └── EmailAnalyzer.php
└── ...

📋 ## Requirements
PHP >= 8.0
Laravel 9
Laravel 10
Laravel 11
Composer
API key for the selected AI provider

🤝 ## Contributing

## Pull requests are welcome!

For new AI providers, bug fixes, improvements, or major features, please open an issue first to discuss the proposed implementation.

🪪 ## License

This package is open-sourced software licensed under the MIT License.

© 2026 OmDiaries
