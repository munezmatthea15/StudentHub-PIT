CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_code VARCHAR(20) NOT NULL UNIQUE,
    department_name VARCHAR(150) NOT NULL
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    course_code VARCHAR(20) NOT NULL UNIQUE,
    course_name VARCHAR(150) NOT NULL,
    FOREIGN KEY (department_id)
        REFERENCES departments(id)
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_number VARCHAR(30) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(20) NOT NULL,
    email VARCHAR(150),
    course_id INT NOT NULL,
    year_level TINYINT NOT NULL,
    status ENUM('Active', 'Inactive', 'Graduated')
        DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id)
        REFERENCES courses(id)
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
