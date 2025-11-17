# 🛒 Kimsan Grocery Store — PHP E-Commerce Platform

Kimsan Grocery Store is a full-stack PHP e-commerce application designed to deliver a simple, fast, and secure online shopping experience. The system allows users to browse products, add items to their cart, manage the cart, and complete purchases through a checkout system that stores transactions in a bookings database.

---

## 📦 Core Features

### 🔐 User Authentication  
Session-based login system to ensure secure access. Only logged-in users can add items to their cart or check out.

### 🛍️ Product Browsing  
Each product displays name, price, image, and an **Add to Cart** button.

### 🛒 Shopping Cart  
- Add items using POST forms  
- Cart stored in MySQL  
- Delete items from cart  
- Auto-calculated subtotal and total  
- Dynamic cart rendering from database  

### 📄 Checkout (Bookings System)  
When “Proceed to Checkout” is pressed:  
- Stores the order in `bookings` table  
- Saves `user_id`, each `product_name`, and `total_price`  
- Clears the cart after purchase  

---

## 🏗️ Tech Stack

### Frontend  
- HTML5  
- CSS3 / Bootstrap  
- JavaScript  

### Backend  
- PHP 8+  
- MySQL  
- Prepared Statements for security  

### Tools  
- XAMPP / MAMP / LAMP  
- phpMyAdmin  
- Apache Server  

---

## 🚀 How to Use This Project

This project is a full PHP-based Grocery Store system that uses **XAMPP**, **Apache**, and **MySQL**.  
Follow the steps below to set it up on **Windows**, **macOS**, or **Linux**.

---

# 1️⃣ Install XAMPP

XAMPP includes Apache + PHP + MySQL in one package.

### ✅ Windows
1. Download XAMPP: https://www.apachefriends.org/download.html  
2. Install it normally.
3. Open the **XAMPP Control Panel**.
4. Start:
   - **Apache**
   - **MySQL**

### ✅ macOS
1. Download XAMPP for macOS (ARM or Intel):  
   https://www.apachefriends.org/download.html
2. Install and open the XAMPP app.
3. Go to **Manage Servers**.
4. Start:
   - **Apache Web Server**
   - **MySQL Database**

### ✅ Linux (Ubuntu / Debian)
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysqli php-xml php-curl php-zip
