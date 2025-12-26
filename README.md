📚 Book Management System

A small Laravel-based project built to demonstrate skills in API development, Filament Admin Panel, Authentication, Authorization, and Localization (Arabic / English).

🔗 Live Demo:
👉 https://book-management.mhmud.com/

🚀 Features

🗄️ Database Structure

The system is built around two main entities:

Authors

id

name_en

name_ar

bio_en

bio_ar

Books

id

title_en

title_ar

description_en

description_ar

price

author_id

Relations

An Author has many Books

A Book belongs to one Author
