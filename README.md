📚 Book Management System

A small Laravel-based project built to demonstrate skills in API development, Filament Admin Panel, Authentication, Authorization, and Localization (Arabic / English).

🔗 Live Demo:
👉 https://book-management.mhmud.com/

🚀 Features

🗄️ Database Structure

The system is built around two main entities and logs:

Authors

Books

Logs

Relations

An Author has many Books

A Book belongs to one Author

🛠 Admin Panel (Filament)

The admin panel is powered by Filament and supports full CRUD operations.

🔐 Roles & Permissions

Implemented using roles and permissions:

Role	Permissions
Admin	Full access (Authors & Books & Logs)
Editor	Manage Books only
✨ Features

CRUD for Authors and Books

Localization support (Arabic / English)

Only the current language fields are shown

Email Notifications

A welcome email is sent automatically when a new author is created

SMTP configured using  Gmail

🔑 Authentication (API)

Authentication is handled using Laravel Sanctum.

📘 Books API
All book routes require:  Authorization: Bearer {token}

🌍 Language Handling (API)

The API supports Arabic & English responses.

You can control the language using:

Query parameter: ?lang=en or ?lang=ar

OR request header

📌 The API returns only one language based on the selected locale.

📝 API Logs

All API requests are logged into a logs table for tracking and auditing.
🧰 Tech Stack

Laravel

Filament

Laravel Sanctum

MySQL

SMTP ( Gmail)

Localization (EN / AR)

📌 Notes

This project is built for testing and showcasing backend skills

Clean architecture with services, policies, and resources

Ready to be extended or integrated with frontend apps

👨‍💻 Author

Mahmoud Elsayed
Backend Developer – Laravel

🔗 Demo: https://book-management.mhmud.com/
