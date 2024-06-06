SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `tickets`;
DROP TABLE IF EXISTS `user_details`;
DROP TABLE IF EXISTS `bus_details`;


CREATE TABLE `bus_details` (
    `bus_id` int(11) NOT NULL AUTO_INCREMENT,
    `bus_name` varchar(255) NOT NULL,
    `source` varchar(255) NOT NULL,
    `destination` varchar(255) NOT NULL,
    `fare` int(11) NOT NULL,
    `seats_available` int(10) NOT NULL,
    `bus_type` ENUM('Standard', 'Economy', 'Premium') NOT NULL DEFAULT 'Standard',
    PRIMARY KEY (`bus_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `user_details` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL, 
    `contact_number` varchar(12) NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `tickets` (
    `ticket_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `bus_name` VARCHAR(255) NOT NULL,
    `num_passengers` INT NOT NULL,
    `total_fare` DECIMAL(10,2) NOT NULL,
    `ticket_name` VARCHAR(255) NOT NULL,
    `booking_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `tickets`
ADD COLUMN `travel_date` DATE;

ALTER TABLE `tickets`
ADD COLUMN `user_id` INT NOT NULL;


ALTER TABLE `tickets`
ADD CONSTRAINT fk_user_id
FOREIGN KEY (`user_id`) REFERENCES `user_details`(`user_id`);

CREATE TABLE `discounts` (
    `discount_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `description` VARCHAR(255),
    `percentage_off` DECIMAL(5,2) NOT NULL CHECK (`percentage_off` > 0 AND `percentage_off` <= 100),
    `valid_from` DATE NOT NULL,
    `valid_until` DATE NOT NULL,
    `min_fare` DECIMAL(10,2) DEFAULT NULL,
    `max_discount_amount` DECIMAL(10,2) DEFAULT NULL,
    `active` BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `discounts` (code, description, percentage_off, valid_from, valid_until, min_fare, max_discount_amount, active)
VALUES 
('WEEKEND50', '50% off for weekend bookings', 50.00, '2024-05-01', '2024-12-31',1000, NULL, TRUE),
('WINTER25', '25% off for winter travel bookings', 25.00, '2024-12-01', '2025-02-28', 1000, 200, TRUE),
('FAMILY10', '10% off for family bookings (min. 4 passengers)', 10.00, '2024-01-01', '2024-12-31', 1500, NULL, TRUE),
('RETURN20', '20% off for return trips', 20.00, '2024-01-01', '2024-12-31', 2000, NULL, TRUE);




INSERT INTO `bus_details` (`bus_name`, `source`, `destination`, `fare`, `seats_available`, `bus_type`) VALUES

('Kolkata-Delhi 10:00pm Volvo AC', 'Kolkata', 'Delhi', 1999, 50, 'Premium'),
('Kolkata-Delhi 6:00am Semi-Sleeper', 'Kolkata', 'Delhi', 1599, 40, 'Economy'),
('Kolkata-Delhi 2:00pm Standard', 'Kolkata', 'Delhi', 999, 60, 'Standard'),
('Kolkata-Bhubaneswar 7:00am Premium', 'Kolkata', 'Bhubaneswar', 1199, 50, 'Premium'),
('Kolkata-Bhubaneswar 1:00pm Economy', 'Kolkata', 'Bhubaneswar', 799, 45, 'Economy'),
('Kolkata-Bhubaneswar 6:00pm Standard', 'Kolkata', 'Bhubaneswar', 699, 50, 'Standard'),

-- Routes from Mumbai
('Mumbai-Goa 8:30am Luxury Sleeper', 'Mumbai', 'Goa', 1999, 30, 'Premium'),
('Mumbai-Goa 3:00pm Semi-Sleeper', 'Mumbai', 'Goa', 999, 40, 'Economy'),
('Mumbai-Goa 9:45pm Standard', 'Mumbai', 'Goa', 899, 40, 'Standard'),
('Mumbai-Pune 6:00am Deluxe', 'Mumbai', 'Pune', 1399, 40, 'Premium'),
('Mumbai-Pune 12:00pm Economy', 'Mumbai', 'Pune', 499, 60, 'Economy'),
('Mumbai-Pune 8:00pm Standard', 'Mumbai', 'Pune', 599, 50, 'Standard'),

-- Routes from Chennai
('Chennai-Bangalore 6:00am Semi-Sleeper', 'Chennai', 'Bangalore', 799, 60, 'Economy'),
('Chennai-Bangalore 11:00pm Standard', 'Chennai', 'Bangalore', 499, 50, 'Standard'),
('Chennai-Bangalore 3:00pm Luxury', 'Chennai', 'Bangalore', 1199, 45, 'Premium'),
('Chennai-Hyderabad 9:00pm Standard', 'Chennai', 'Hyderabad', 899, 70, 'Standard'),
('Chennai-Hyderabad 6:00am Economy', 'Chennai', 'Hyderabad', 699, 55, 'Economy'),
('Chennai-Hyderabad 2:00pm Premium', 'Chennai', 'Hyderabad', 1299, 50, 'Premium'),

-- Routes from Hyderabad
('Hyderabad-Pune 9:00pm Seater', 'Hyderabad', 'Pune', 699, 80, 'Standard'),
('Hyderabad-Pune 4:00pm Economy', 'Hyderabad', 'Pune', 599, 60, 'Economy'),
('Hyderabad-Pune 10:00am Premium', 'Hyderabad', 'Pune', 1199, 50, 'Premium'),
('Hyderabad-Bangalore 5:00am Deluxe', 'Hyderabad', 'Bangalore', 1199, 45, 'Premium'),
('Hyderabad-Bangalore 1:00pm Standard', 'Hyderabad', 'Bangalore', 899, 60, 'Standard'),
('Hyderabad-Bangalore 8:00pm Semi-Sleeper', 'Hyderabad', 'Bangalore', 699, 50, 'Economy'),
('Delhi-Jaipur 7:00am Deluxe AC', 'Delhi', 'Jaipur', 1299, 50, 'Premium'),
('Delhi-Jaipur 8:30am Semi-Sleeper', 'Delhi', 'Jaipur', 799, 60, 'Economy'),
('Delhi-Jaipur 10:00am Standard', 'Delhi', 'Jaipur', 499, 70, 'Standard'),
('Delhi-Agra 9:00am Luxury AC', 'Delhi', 'Agra', 1499, 30, 'Premium'),
('Delhi-Agra 2:00pm Economy', 'Delhi', 'Agra', 599, 50, 'Economy'),
('Delhi-Agra 6:00pm Standard', 'Delhi', 'Agra', 699, 60, 'Standard'),

-- Routes from Bangalore
('Bangalore-Mumbai 9:00am Luxury Sleeper', 'Bangalore', 'Mumbai', 1999, 30, 'Premium'),
('Bangalore-Mumbai 11:30am Deluxe Non-AC', 'Bangalore', 'Mumbai', 1299, 40, 'Standard'),
('Bangalore-Mumbai 1:00pm Semi-Sleeper', 'Bangalore', 'Mumbai', 999, 50, 'Economy'),
('Bangalore-Chennai 6:30am Deluxe AC', 'Bangalore', 'Chennai', 1300, 40, 'Premium'),
('Bangalore-Chennai 12:00pm Semi-Sleeper', 'Bangalore', 'Chennai', 800, 60, 'Economy'),
('Bangalore-Chennai 8:00pm Standard', 'Bangalore', 'Chennai', 600, 70, 'Standard'),

-- Routes from Pune
('Pune-Hyderabad 8:00am Seater', 'Pune', 'Hyderabad', 699, 80, 'Standard'),
('Pune-Hyderabad 10:30am Semi-Sleeper', 'Pune', 'Hyderabad', 899, 60, 'Economy'),
('Pune-Hyderabad 1:00pm Deluxe AC', 'Pune', 'Hyderabad', 1299, 50, 'Premium'),
('Pune-Nagpur 5:00am Premium', 'Pune', 'Nagpur', 1600, 40, 'Premium'),
('Pune-Nagpur 11:00am Economy', 'Pune', 'Nagpur', 1000, 60, 'Economy'),
('Pune-Nagpur 9:00pm Standard', 'Pune', 'Nagpur', 800, 70, 'Standard'),
('Jaipur-Chandigarh 8:00am Deluxe', 'Jaipur', 'Chandigarh', 1200, 40, 'Premium'),
('Jaipur-Chandigarh 2:00pm Semi-Sleeper', 'Jaipur', 'Chandigarh', 900, 60, 'Economy'),
('Jaipur-Chandigarh 10:00pm Standard', 'Jaipur', 'Chandigarh', 700, 70, 'Standard'),
('Jaipur-Udaipur 7:30am Luxury Sleeper', 'Jaipur', 'Udaipur', 1400, 30, 'Premium'),
('Jaipur-Udaipur 12:00pm Economy', 'Jaipur', 'Udaipur', 850, 50, 'Economy'),
('Jaipur-Udaipur 5:00pm Standard', 'Jaipur', 'Udaipur', 650, 60, 'Standard'),
-- Routes from Guwahati to Shimla
('Guwahati-Shimla 6:00am Deluxe AC', 'Guwahati', 'Shimla', 2200, 40, 'Premium'),
('Guwahati-Shimla 12:00pm Semi-Sleeper', 'Guwahati', 'Shimla', 1800, 50, 'Economy'),
('Guwahati-Shimla 8:00pm Standard', 'Guwahati', 'Shimla', 1500, 55, 'Standard'),

-- Routes from Guwahati to Manali
('Guwahati-Manali 7:00am Premium Sleeper', 'Guwahati', 'Manali', 2500, 35, 'Premium'),
('Guwahati-Manali 1:00pm Deluxe AC', 'Guwahati', 'Manali', 2300, 45, 'Premium'),
('Guwahati-Manali 9:00pm Economy', 'Guwahati', 'Manali', 1900, 50, 'Economy'),

-- Routes from Guwahati to Dharamshala
('Guwahati-Dharamshala 5:00am Deluxe', 'Guwahati', 'Dharamshala', 2400, 40, 'Premium'),
('Guwahati-Dharamshala 11:00am Semi-Sleeper', 'Guwahati', 'Dharamshala', 2000, 50, 'Economy'),
('Guwahati-Dharamshala 7:00pm Standard', 'Guwahati', 'Dharamshala', 1600, 55, 'Standard'),

-- Routes from Guwahati to Dalhousie
('Guwahati-Dalhousie 8:00am Luxury Sleeper', 'Guwahati', 'Dalhousie', 2600, 30, 'Premium'),
('Guwahati-Dalhousie 2:00pm Semi-Sleeper', 'Guwahati', 'Dalhousie', 2100, 50, 'Economy'),
('Guwahati-Dalhousie 10:00pm Standard', 'Guwahati', 'Dalhousie', 1800, 45, 'Standard'),
-- Routes from Kolkata to Darjeeling
('Kolkata-Darjeeling 7:00am Deluxe AC', 'Kolkata', 'Darjeeling', 1700, 40, 'Premium'),
('Kolkata-Darjeeling 1:00pm Semi-Sleeper', 'Kolkata', 'Darjeeling', 1300, 50, 'Economy'),
('Kolkata-Darjeeling 9:00pm Standard', 'Kolkata', 'Darjeeling', 1100, 55, 'Standard'),

-- Routes from Kolkata to Siliguri
('Kolkata-Siliguri 6:00am Luxury Sleeper', 'Kolkata', 'Siliguri', 1800, 30, 'Premium'),
('Kolkata-Siliguri 2:00pm Deluxe AC', 'Kolkata', 'Siliguri', 1500, 45, 'Premium'),
('Kolkata-Siliguri 10:00pm Economy', 'Kolkata', 'Siliguri', 1200, 50, 'Economy'),

-- Routes from Kolkata to Digha
('Kolkata-Digha 5:00am Premium AC', 'Kolkata', 'Digha', 900, 40, 'Premium'),
('Kolkata-Digha 11:00am Semi-Sleeper', 'Kolkata', 'Digha', 700, 50, 'Economy'),
('Kolkata-Digha 6:00pm Standard', 'Kolkata', 'Digha', 500, 60, 'Standard'),

-- Routes from Siliguri to Gangtok
('Siliguri-Gangtok 8:00am Luxury Sleeper', 'Siliguri', 'Gangtok', 1300, 30, 'Premium'),
('Siliguri-Gangtok 2:00pm Semi-Sleeper', 'Siliguri', 'Gangtok', 1000, 50, 'Economy'),
('Siliguri-Gangtok 7:00pm Standard', 'Siliguri', 'Gangtok', 800, 60, 'Standard'),

-- Routes from Darjeeling to Kalimpong
('Darjeeling-Kalimpong 9:00am Deluxe AC', 'Darjeeling', 'Kalimpong', 700, 40, 'Premium'),
('Darjeeling-Kalimpong 1:00pm Standard', 'Darjeeling', 'Kalimpong', 500, 50, 'Standard'),
('Darjeeling-Kalimpong 4:00pm Economy', 'Darjeeling', 'Kalimpong', 400, 60, 'Economy'),

-- Routes from Asansol to Kolkata
('Asansol-Kolkata 7:00am Deluxe AC', 'Asansol', 'Kolkata', 800, 40, 'Premium'),
('Asansol-Kolkata 1:00pm Semi-Sleeper', 'Asansol', 'Kolkata', 600, 50, 'Economy'),
('Asansol-Kolkata 8:00pm Standard', 'Asansol', 'Kolkata', 450, 60, 'Standard'),
-- Routes from Shimla to Manali
('Shimla-Manali 8:00am Luxury AC', 'Shimla', 'Manali', 1200, 30, 'Premium'),
('Shimla-Manali 12:00pm Semi-Sleeper', 'Shimla', 'Manali', 900, 50, 'Economy'),
('Shimla-Manali 5:00pm Standard', 'Shimla', 'Manali', 700, 60, 'Standard'),

-- Routes from Dharamshala to Chandigarh
('Dharamshala-Chandigarh 7:00am Deluxe AC', 'Dharamshala', 'Chandigarh', 1000, 40, 'Premium'),
('Dharamshala-Chandigarh 1:00pm Economy', 'Dharamshala', 'Chandigarh', 800, 50, 'Economy'),
('Dharamshala-Chandigarh 6:00pm Standard', 'Dharamshala', 'Chandigarh', 600, 70, 'Standard'),

-- Routes from Manali to Leh
('Manali-Leh 4:00am Luxury Sleeper', 'Manali', 'Leh', 2500, 20, 'Premium'),
('Manali-Leh 9:00am Deluxe', 'Manali', 'Leh', 2200, 30, 'Premium'),
('Manali-Leh 3:00pm Standard', 'Manali', 'Leh', 1800, 40, 'Standard'),

-- Routes from Shimla to Delhi
('Shimla-Delhi 6:00am Semi-Sleeper', 'Shimla', 'Delhi', 1500, 45, 'Premium'),
('Shimla-Delhi 2:00pm Deluxe Non-AC', 'Shimla', 'Delhi', 1200, 50, 'Economy'),
('Shimla-Delhi 8:00pm Standard', 'Shimla', 'Delhi', 1000, 60, 'Standard'),

-- Routes from Solan to Amritsar
('Solan-Amritsar 5:00am Premium AC', 'Solan', 'Amritsar', 1400, 35, 'Premium'),
('Solan-Amritsar 11:00am Semi-Sleeper', 'Solan', 'Amritsar', 1100, 45, 'Economy'),
('Solan-Amritsar 7:00pm Standard', 'Solan', 'Amritsar', 900, 55, 'Standard'),

-- Routes from Kullu to Jaipur
('Kullu-Jaipur 7:00am Deluxe Sleeper', 'Kullu', 'Jaipur', 1800, 30, 'Premium'),
('Kullu-Jaipur 12:00pm Standard', 'Kullu', 'Jaipur', 1500, 50, 'Economy'),
('Kullu-Jaipur 8:00pm Economy', 'Kullu', 'Jaipur', 1300, 60, 'Economy');








SELECT `password` FROM `user_details` WHERE `email` = 'user@example.com';

ALTER TABLE user_details ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL;
ALTER TABLE user_details ADD COLUMN token_expiry DATETIME DEFAULT NULL;


DROP TABLE IF EXISTS `driver_details`;

CREATE TABLE `driver_details` (
    `driver_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `driver_name` VARCHAR(255) NOT NULL,
    `license_number` VARCHAR(50) NOT NULL UNIQUE,
    `contact_number` VARCHAR(12) NOT NULL
);

CREATE TABLE `driver_bus_assignment` (
    `assignment_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `driver_id` INT NOT NULL,
    `bus_id` INT NOT NULL,
    FOREIGN KEY (`driver_id`) REFERENCES `driver_details`(`driver_id`),
    FOREIGN KEY (`bus_id`) REFERENCES `bus_details`(`bus_id`)
);

-- Insert data into driver_details
INSERT INTO `driver_details` (`driver_name`, `license_number`, `contact_number`) VALUES
('Manish Raj', 'AB123456', '1234567890'),
('Anand Sharma', 'CD789012', '9876543210'),
('Shivam Sharma', 'EF345678', '5678901234'),
('Dev Laal', 'AB123656', '1234567880'),
('Ramsingh Chadda', 'CM789012', '9875543210'),
('Rangeela Yadav', 'EP345678', '5678901234');


-- Insert data into driver_bus_assignment to assign drivers to buses
INSERT INTO `driver_bus_assignment` (`driver_id`, `bus_id`) VALUES
(1, 1),
(2, 2), 
(3, 3),
(1, 4), 
(2, 5), 
(1, 7), 
(2, 8), 
(3, 9), 
(4, 10), 
(5, 11), 
(6, 12),
(4, 13), 
(5, 14), 
(6, 15),
(1,16),
(1,18),
(2,19),
(3,20),
(4,17),
(5,21),
(6,22),
(1,23),
(2,24),
(3,25),
(1,26),
(2,27),
(3,28),
(1,29),
(2,30),
(3,31),
(4,32),
(5,33),
(6,34),
(1,35),
(2,36),
(3,37),
(1,38),
(2,39),
(3,40),
(1, 41),
(2, 42),
(3, 43),
(4, 44),
(5, 45),
(6, 46),
(1, 47),
(2, 48),
(3, 49),
(4, 50),
(5, 51),
(6, 52),
(1, 53),
(2, 54),
(3, 55),
(4, 56),
(5, 57),
(6, 58),
(1, 59),
(2, 60),
(3, 61),
(4, 62),
(5, 63),
(6, 64),
(1, 65),
(2, 66),
(3, 67),
(4, 68),
(5, 69),
(6, 70),
(1, 71),
(2, 72),
(3, 73),
(4, 74),
(5, 75),
(6, 76),
(1, 77),
(2, 78),
(3, 79),
(4, 80),
(5, 81),
(6, 82),
(1, 83),
(2, 84),
(3, 85),
(4, 86),
(5, 87),
(6, 88),
(1, 89),
(2, 90),
(3, 91),
(4, 92),
(5, 93),
(6, 94),
(1, 95),
(2, 96);

-- Creating a table to handle ticket cancellations
CREATE TABLE `ticket_cancellations` (
    `cancellation_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `ticket_id` INT NOT NULL,
    `cancellation_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `refund_amount` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`ticket_id`) REFERENCES `tickets`(`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Creating an admin table to manage admin details
CREATE TABLE `admin_details` (
    `admin_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Example insert into admin_details (for admin management)
INSERT INTO `admin_details` (username, password, email) VALUES
('admin1', 'securepassword123', 'admin1@example.com'),
('admin2', 'securepassword123', 'admin2@example.com');

-- Providing a VIEW for admins to see all bookings, cancellations, and user details
CREATE VIEW `admin_view_all_details` AS
SELECT 
    u.user_id, u.name, u.email,
    t.ticket_id, t.bus_name, t.num_passengers, t.total_fare, t.travel_date,
    c.cancellation_id, c.refund_amount, c.cancellation_time
FROM `user_details` u
JOIN `tickets` t ON u.user_id = t.user_id
LEFT JOIN `ticket_cancellations` c ON t.ticket_id = c.ticket_id;

-- Optionally, you could also create a procedure to facilitate admin tasks such as viewing specific records.
-- Example: A procedure to view all ticket details for a specific user
DELIMITER $$
    

DELIMITER ;





SET FOREIGN_KEY_CHECKS = 1;


-- Fetch the current seats_available value for the bus on the travel_date
SELECT seats_available FROM bus_details WHERE bus_name = @bus_name;

-- Assuming you have fetched the current_seats_available value, deduct the num_passengers
SET @new_seats_available = @current_seats_available - @num_passengers;

-- Update the seats_available value for the bus
UPDATE bus_details SET seats_available = @new_seats_available WHERE bus_name = @bus_name;


COMMIT;

SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
