# Laravel AI Email Assistant (by OmDiaries)

AI-powered email generator compatible with Laravel 9, 10, and 11.

## Installation
```bash
composer require omdiaries/laravel-ai-email-assistant
```

## Usage
```php
use AIEmail;

$email = AIEmail::generate('welcome', [
  'customer_name' => 'Radhika',
  'product' => 'Pro Plan',
  'company_name' => 'OM Diaries'
], ['tone' => 'friendly']);
```

## 🚀 Installation

Install the package using Composer:

```bash
composer require omdiaries/laravel-ai-email-assistant

