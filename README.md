# 🎓 School Management System

A robust and modular school management system built with Laravel and Livewire, supporting role-based dashboards for Admins, Teachers, Students, and Parents.

## 🚀 Features

### 🔐 Multi-Role Authentication & Dashboards
Each user type has access to a dedicated dashboard with tailored features:
- **Admin**: Full control over the system including student promotions, accounting, and user management.
- **Teacher**: Create and manage exams, record attendance, and monitor student performance.
- **Student**: Access tests, view results, and request re-exams.
- **Parent**: Monitor their children's academic progress, attendance, grades, and financial dues.

### 🌐 Multi-Language Support
- Full support for **Arabic** and **English** interfaces.
- Users can easily switch the language from within the system.

### 🧩 Design Pattern
- Utilizes the **Repository Design Pattern** to keep code clean, modular, and maintainable.

### 🎥 Zoom Integration
- Admins and Teachers can schedule, manage, and hold online classes directly through **Zoom Integration**.

### ⚙️ Livewire Integration
- Real-time, dynamic UI powered by **Laravel Livewire** for seamless interactivity without full page reloads.

### 🎓 Student Promotion System
- Promote students from:
  - One grade to another
  - One class to another
  - One academic year to another
- Also supports graduating students.

### 💼 Attendance System
- **Teachers** can record daily attendance for each class.
- **Parents** can view their children's attendance history (dates of absence/presence).
- **Admins** have access to full attendance reports.

### 💵 Accounting Module
- Full accounting features for managing:
  - Invoices & fees
  - Payment status
  - Balance tracking (Debtor or Creditor)
  - Student-specific financial summaries

### 📝 Examination System
- Teachers can create and assign exams.
- Students can submit exams and receive immediate grading.
- Parents can view the performance of their children.
- Students can submit **re-exam requests** in case of issues.

## 🌄 Screenshots
  
![Admin Dashboard](screenshots/01_login.png)
![Admin Dashboard](screenshots/02_login_admin.png)
![Admin Dashboard](screenshots/03_admin_dahboard_ar.png)
![Admin Dashboard](screenshots/04_admin_dashboard_en.png)
![Admin Dashboard](screenshots/05_admin_dashboard_en.png)
![Admin Dashboard](screenshots/06_class.png)
![Admin Dashboard](screenshots/07_sections.png)
![Admin Dashboard](screenshots/08_std.png)
![Admin Dashboard](screenshots/09_addstd.png)
![Admin Dashboard](screenshots/10_promotion.png)
![Admin Dashboard](screenshots/11_add_parent.png)
![Admin Dashboard](screenshots/12_addfees.png)
![Admin Dashboard](screenshots/13_add_subject.png)
![Admin Dashboard](screenshots/14_addexam.png)
![Admin Dashboard](screenshots/15_make_zoom_meet.png)
![Admin Dashboard](screenshots/16_all_zoom_meetings.png)
![Admin Dashboard](screenshots/17_settings.png)
![Admin Dashboard](screenshots/18_teacher_dash.png)
![Admin Dashboard](screenshots/19_add_q.png)
![Admin Dashboard](screenshots/20_std_dash.png)
![Admin Dashboard](screenshots/21_std_exam.png)
![Admin Dashboard](screenshots/23_exam_grade.png_std_exam)
![Admin Dashboard](screenshots/24_parent_dash.png)
![Admin Dashboard](screenshots/25_parent_invoices.png)


## 🛠️ Tech Stack
- **Laravel** (Backend)
- **Livewire** (Frontend interactivity)
- **Zoom API** (Online sessions)
- **Repository Pattern** (Code architecture)

## 📂 Structure
- Modular, scalable structure following best practices.
- Each module is separated and can be extended easily.

## ✅ Future Enhancements
- Notifications system for reminders and updates
- Mobile-friendly version

## 🧑‍💻 Developed by [Atef Hejazi](https://www.linkedin.com/in/atefhejazi)

Feel free to fork, contribute, or reach out for collaboration.
