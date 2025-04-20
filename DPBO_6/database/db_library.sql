CREATE DATABASE library_db;
USE library_db;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    isbn VARCHAR(13) UNIQUE,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15)
);

CREATE TABLE loans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    loan_date DATE NOT NULL,
    return_date DATE,
    FOREIGN KEY (book_id) REFERENCES books(id),
    FOREIGN KEY (member_id) REFERENCES members(id)
);

INSERT INTO books (title, author, isbn, stock) VALUES
('The Industrial Society', 'Teddy Kazcinsk', '1234567890123', 5),
('My Struggle', 'Adi H.', '9876543210987', 3),
('Gataumaunamainapagwhabiside', 'Mulyo N.', '4567891234567', 4);

INSERT INTO members (name, email, phone) VALUES
('Grigori', 'grigori@idk.com', '08123456789'),
('Asda Fegehejekel', 'asda@idk.com', '08234567890');