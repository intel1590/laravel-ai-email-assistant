# 🚀 Laravel AI Email Assistant

AI-powered email generation and email intelligence for Laravel 9, 10, and 11.

Generate professional emails using AI and automatically analyze incoming emails for category, intent, sentiment, priority, summaries, and action items.

---

## 🧠 Features

### AI Email Generation

- ✅ OpenAI support
- ✅ Google Gemini support
- ✅ Custom email tones
- ✅ Plain text and HTML output
- ✅ Prebuilt prompt templates
- ✅ File-based email templates
- ✅ AI fallback when a local template is unavailable
- ✅ Dynamic template variables
- ✅ Centralized Laravel logging

### AI Email Intelligence

- ✅ Email category detection
- ✅ Intent detection
- ✅ Sentiment analysis
- ✅ Priority detection
- ✅ Automatic email summary
- ✅ Action-item extraction
- ✅ Structured analysis response

### Developer Features

- ✅ Provider adapter architecture
- ✅ Common AI client interface
- ✅ Extendable AI provider support
- ✅ Laravel 9, 10, and 11 support
- ✅ PHP 8.0+

---

## 📦 Installation

Install the package using Composer:

```bash
composer require omdiaries/laravel-ai-email-assistant
```

Publish the configuration file:

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

Set the default AI provider in your `.env` file:

```env
AI_PROVIDER=openai
```

Supported providers:

```text
openai
gemini
```

### OpenAI Configuration

```env
OPENAI_API_KEY=your_openai_api_key
OPENAI_MODEL=gpt-4o-mini
```

### Google Gemini Configuration

```env
GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-1.5-flash
```

### Email Tone

Configure the default email tone:

```env
AI_EMAIL_TONE=friendly
```

Supported tones include:

```text
formal
friendly
marketing
```

Custom tone text can also be provided.

### Email Output

Configure the default output format:

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

You only need to provide the API key for the provider you intend to use.

---

# ✉️ AI Email Generation

Generate emails using a template name and dynamic data.

```php
use OmDiaries\AIEmailAssistant\Services\AIEmailService;

$service = new AIEmailService();

$email = $service->generate(
    'welcome',
    [
        'name' => 'John'
    ]
);
```

The service supports both file-based templates and AI-generated emails.

---

## 📄 File-Based Email Templates

The package first checks for a local email template:

```text
resources/ai-templates/{template}.txt
```

If the template exists, it is used directly.

Example:

```text
resources/
└── ai-templates/
    └── welcome.txt
```

A template can contain dynamic variables:

```text
Subject: Welcome {{name}}

Body:
Hello {{name}},

Welcome to our platform!

We are happy to have you with us.
```

Pass the variable when generating the email:

```php
$email = $service->generate(
    'welcome',
    [
        'name' => 'John'
    ]
);
```

The package replaces the `{{variable}}` placeholders automatically.

---

## 🤖 AI Fallback

If a file-based template does not exist, the package automatically falls back to AI-based generation.

```php
$email = $service->generate(
    'customer-followup',
    [
        'customer_name' => 'John',
        'order_id' => 'ORD-1001'
    ]
);
```

The configured AI provider will generate the email using the selected tone and output format.

---

# 🧠 AI Email Intelligence

The package can analyze an email and return structured intelligence.

The analyzer extracts:

- Category
- Intent
- Sentiment
- Priority
- Summary
- Action items

Example categories include:

```text
support
billing
sales
complaint
refund
technical
feedback
marketing
general
```

Supported sentiment values include:

```text
positive
neutral
negative
frustrated
urgent
```

Supported priority values include:

```text
low
medium
high
urgent
```

---

## 🔍 Analyze an Email

Use the `EmailAnalyzer` service:

```php
use OmDiaries\AIEmailAssistant\Services\EmailAnalyzer;

$analysis = $analyzer->analyze(
    'I was charged twice for my order. Please refund the duplicate payment.'
);
```

The result is returned as an `EmailAnalysis` object containing:

```text
category
intent
sentiment
priority
summary
actionItems
```

Example:

```php
$analysis->category;
$analysis->intent;
$analysis->sentiment;
$analysis->priority;
$analysis->summary;
$analysis->actionItems;
```

---

## 📊 Example Analysis

For an email such as:

```text
I was charged twice for my order.
Please refund the duplicate payment.
```

The analysis can identify information such as:

```text
Category: billing
Intent: Request a refund for duplicate payment
Sentiment: frustrated
Priority: high
Summary: Customer reports a duplicate payment and requests a refund.
Action Items:
- Verify duplicate payment
- Process refund
```

The exact result depends on the AI provider's response.

---

# 🧩 AI Provider Architecture

The package uses a common AI client contract so that different AI providers can be integrated through adapters.

The main contract is:

```php
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Current provider adapters:

```text
src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
│
└── Contracts/
    └── AIClientInterface.php
```

The `EmailAnalyzer` receives an `AIClientInterface`, allowing the analyzer to work with different AI providers.

---

## 🔌 OpenAI Adapter

OpenAI is supported through:

```text
src/Adapters/OpenAIAdapter.php
```

The adapter communicates with the OpenAI API and supports email generation.

---

## 🔌 Gemini Adapter

Google Gemini is supported through:

```text
src/Adapters/GeminiAdapter.php
```

The adapter communicates with the Gemini API and supports email generation.

---

# 🎨 Email Tones

Configure the default email tone:

```env
AI_EMAIL_TONE=friendly
```

Supported examples:

```text
formal
friendly
marketing
```

You can also provide a custom tone when using the service.

---

# 📄 Output Formats

The package supports:

### Plain Text

```env
AI_EMAIL_OUTPUT=plain
```

### HTML

```env
AI_EMAIL_OUTPUT=html
```

When HTML output is selected, generated email content is formatted as HTML.

---

# 📝 Prompt Templates

The package uses prompt templates to construct AI email-generation prompts.

Templates can include dynamic variables:

```text
{{name}}
{{order_id}}
{{company}}
```

These variables are replaced with the values supplied to the email generation service.

---

# 🔧 Adding a New AI Provider

To add another AI provider, implement:

```php
OmDiaries\AIEmailAssistant\Contracts\AIClientInterface
```

Create a new adapter:

```text
src/
└── Adapters/
    └── YourAIProviderAdapter.php
```

The adapter should provide the methods required by the common AI client contract.

After creating the adapter, register the provider through the package configuration/service provider.

This architecture allows additional AI providers to be added without changing the email analysis and generation workflow.

---

# 🔐 Security

Never commit API keys to your repository.

Use your application's `.env` file:

```env
OPENAI_API_KEY=your_openai_api_key
GEMINI_API_KEY=your_gemini_api_key
```

Make sure `.env` is excluded from version control.

---

# 🧪 Testing

Run the package test suite with:

```bash
vendor/bin/phpunit
```

GitHub Actions can be used to validate the package automatically.

---

# 📁 Project Structure

```text
src/
├── Adapters/
│   ├── OpenAIAdapter.php
│   └── GeminiAdapter.php
│
├── Contracts/
│   └── AIClientInterface.php
│
├── Data/
│   └── EmailAnalysis.php
│
├── Services/
│   ├── AIEmailService.php
│   └── EmailAnalyzer.php
│
└── Support/
    └── PromptTemplates.php
```

---

# 📋 Requirements

- PHP `>= 8.0`
- Laravel 9
- Laravel 10
- Laravel 11
- Composer
- API key for the selected AI provider

---

# 🤝 Contributing

Pull requests are welcome!

For:

- New AI providers
- AI improvements
- Email templates
- Email intelligence improvements
- Bug fixes
- Performance improvements

please open an issue first to discuss the proposed change.

---

# 🪪 License

This package is open-sourced software licensed under the MIT License.

© 2026 OmDiaries
