# Laravel AI Email Assistant (Beta)

AI-powered Email Assistant for Laravel 9, 10, and 11 — now in **Beta Release**!  
This package allows developers to generate smart, pre-trained email templates using AI for different use cases such as onboarding, payment reminders, support replies, and more.

---

## 🚀 Features

✅ Generate AI-based email templates (Welcome, Invoice, Support, Follow-Up)  
✅ Auto-format subject lines and greetings using OpenAI API  
✅ Configurable API key through `.env`  
✅ Blade & Markdown template support  
✅ Extendable template system  
✅ Laravel 11 compatibility  
✅ Works with Gmail, Mailtrap, SMTP, etc.  
✅ Beta updates include performance optimization & bug fixes  

---

## 🧠 Installation

```bash
composer require omdiaries/laravel-ai-email-assistant
```

Then publish the configuration file:

```bash
php artisan vendor:publish --tag=ai-email-config
```

---

## ⚙️ Configuration

Add your OpenAI API key in `.env`:

```
OPENAI_API_KEY=your_api_key_here
```

You can customize model and tone settings in `config/ai-email.php`.

---

## 🧩 Usage

Generate an AI-powered email with:

```php
use OmDiaries\AiEmail\Facades\AiEmail;

$email = AiEmail::generate([
    'type' => 'welcome',
    'name' => 'Radhika',
    'company' => 'OM Diaries',
    'tone' => 'friendly'
]);

Mail::to('user@example.com')->send($email);
```

---

## 🧱 Template Types

| Type | Description |
|------|--------------|
| welcome | Friendly welcome emails |
| followup | Re-engagement or reminder emails |
| invoice | Payment / billing templates |
| support | Customer service replies |

---

## 🛠️ Extending the Package

You can add new templates easily by publishing the views:

```bash
php artisan vendor:publish --tag=ai-email-templates
```

Edit the templates in:  
`resources/views/vendor/ai-email/templates`

---

## 🧪 Beta Version Notes

This **Beta** focuses on stability, better AI prompt tuning, and compatibility improvements for Laravel 11.  
Feedback and suggestions are highly encouraged — please open issues or submit PRs!

---

## 🧑‍💻 Author

**Radhika** – Full Stack Developer (9+ years experience)  
GitHub: [@intel1590](https://github.com/intel1590)  
Packagist: [omdiaries/laravel-ai-email-assistant](https://packagist.org/packages/omdiaries/laravel-ai-email-assistant)

---

## 📄 License

This package is open-sourced under the [MIT license](LICENSE).
