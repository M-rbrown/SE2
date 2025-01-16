
CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    location VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL
);

INSERT INTO residents (first_name, last_name, gender, location, phone) VALUES
('Mark Rainier', 'Soriao', 'Male', 'Baryo', '09770182865'),
('Cyrill', 'Cariasa', 'Female', 'Baryo', '09319301407'),
('Jose Karlo', 'Toledo', 'Male', 'Tulay na Bakal', '09942414623'),
('Jomari Ivan', 'Porteria', 'Male', 'Pinag-tagpo', '09777742341'),
('Angelica', 'Cortez', 'Female', 'Pinag-layo', '09917165633'),
('Michael Laurence', 'Narvaez', 'Male', 'Baryo', '09383598519');