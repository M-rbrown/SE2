-- Create the table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each record
    fname VARCHAR(255) NOT NULL,       -- Full name of the admin
    email VARCHAR(255) NOT NULL UNIQUE, -- Email address of the admin
    password VARCHAR(255) NOT NULL    -- Password of the admin
);

-- Insert sample data
INSERT INTO admins (fname, email, password)
VALUES
('Admin', 'admin@yahoo.com', 'admin');
