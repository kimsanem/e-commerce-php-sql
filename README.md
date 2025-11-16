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
