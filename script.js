```javascript
AOS.init({
duration:1200,
once:true
});

window.addEventListener('scroll',function(){
const nav=document.querySelector('.custom-navbar');

if(window.scrollY>50){
nav.style.background='#0b3d2e';
}else{
nav.style.background='rgba(0,0,0,0.4)';
}
});
```
const API_URL = "http://localhost/website/submit_application.php";















Developed Using:
HTML

CSS

JavaScript

PHP

MySQL

XAMPP

MySQL Workbench








1. Introduction

The Arshith Group Internship Portal is a full-stack web application developed for managing internship applications online.

The project allows users to:
• View internship openings
• Apply through online forms
• Store applicant data in database

The application uses XAMPP as the local server environment and MySQL Workbench for database management.
2. Technologies Used

| Technology      | Purpose             |
| --------------- | ------------------- |
| HTML            | Webpage structure   |
| CSS/Tailwind    | Styling             |
| JavaScript      | Interactions        |
| PHP             | Backend processing  |
| MySQL           | Database            |
| XAMPP           | Apache server       |
| MySQL Workbench | Database management |
| VS Code         | Code editor         |
 3. Software Requirements

• XAMPP
• MySQL Workbench
• VS Code
• Web Browser

Frontend Explanation
The frontend is designed using HTML, CSS, and JavaScript.

Features:
• Responsive design
• Animated sections
• Internship cards
• Application form
• Modern UI/UX

6. Backend Explanation

The backend is developed using PHP.

Responsibilities:
• Receive form data
• Connect with database
• Store user applications
• Handle form submission

7. XAMPP Working
What is XAMPP?

XAMPP is a local server package that provides Apache and MySQL services.

Apache:
Runs PHP files on localhost

MySQL:
Stores application data



8. Starting XAMPP
Steps
Open XAMPP Control Panel

Start Apache

Start MySQL

Add Screenshot Here.

Caption:


Figure 1: XAMPP Control Panel

9. Database Using MySQL Workbench

Database Creation,Table Creation

11. MySQL Workbench Explanation

MySQL Workbench is used to:
• Create database
• Create tables
• Execute SQL queries
• View stored application data


Database Connection:
Form Submission:

14. Frontend and Backend Flow

User fills application form
            ↓
HTML form sends data
            ↓
PHP receives data
            ↓
PHP connects to MySQL
            ↓
Data stored in database
            ↓
Success message displayed


Conclusion:


The Internship Portal successfully demonstrates a full-stack web application using PHP, MySQL, XAMPP, and MySQL Workbench. The project provides an efficient system for managing internship applications digitally.


