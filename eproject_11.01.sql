DROP DATABASE eproject;
CREATE DATABASE eproject;
USE eproject;

CREATE TABLE `eproject`.`user` (
  `userID` INT NOT NULL AUTO_INCREMENT,
  `password` VARCHAR(255) NULL,
  `userName` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `address` VARCHAR(100) NULL,
  `phone` VARCHAR(12) NULL,
  `dob` DATE NULL,
  `roleUser` int NULL,
  PRIMARY KEY (`userID`));

CREATE TABLE `eproject`.`category` (
  `categoryID` INT NOT NULL AUTO_INCREMENT,
  `categoryName` VARCHAR(50) NULL,
  PRIMARY KEY (`categoryID`));

CREATE TABLE `eproject`.`brand` (
  `brandID` INT NOT NULL AUTO_INCREMENT,
  `brandName` VARCHAR(50) NULL,
  PRIMARY KEY (`brandID`));
  
CREATE TABLE `eproject`.`products` (
  `productID` INT NOT NULL AUTO_INCREMENT,
  `productName` VARCHAR(100) NULL,
  `imageLink` VARCHAR(200) NULL,
  `unitPrice` FLOAT NULL,
  `quantity` INT NULL,
  `categoryID` INT NULL,
  `brandID` INT NULL,
  `memory` VARCHAR(10) NULL,
  `speed` VARCHAR(50) NULL,
  `color` VARCHAR(25) NULL,
  `warranty` VARCHAR(30) NULL,
  `dimension` VARCHAR(30) NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`productID`));
  
CREATE TABLE `eproject`.`carts` (
  `cartID` INT NOT NULL AUTO_INCREMENT,
  `productID` INT NULL,
  `cartCode` VARCHAR(30) NULL,
  `userID` INT NULL,
  `cartQuantity` INT NULL,
  `totalMoney` INT NULL,
  PRIMARY KEY (`cartID`));
  
CREATE TABLE `eproject`.`order` (
  `orderID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NULL,
  `cartCode` VARCHAR(30) NULL,
  `orderEmail` VARCHAR(45) NULL,
  `orderAddress` VARCHAR(100) NULL,
  `orderPhone` VARCHAR(12) NULL,
  `orderDate` DATETIME DEFAULT NOW(),
  PRIMARY KEY (`orderID`));
  
CREATE TABLE `eproject`.`orderDetails` (
  `orderDetailsID` INT NOT NULL AUTO_INCREMENT,
  `orderID` INT NULL,
  `productID` INT NULL,
  `discount` FLOAT NULL,
  `orderQuantity` INT NULL,
  `totalMoney` INT NULL,
  PRIMARY KEY (`orderDetailsID`));
    
CREATE TABLE `eproject`.`feedback` (
  `feedbackID` INT NOT NULL AUTO_INCREMENT,
  `userID` INT NULL,
  `orderID` INT NULL,
  `productID` INT NULL,
  `message` VARCHAR(200) NULL,
  PRIMARY KEY (`feedbackID`));

ALTER TABLE `eproject`.`products` ADD CONSTRAINT fk_categoryID_products FOREIGN KEY (categoryID) REFERENCES `eproject`.`category`(categoryID);
ALTER TABLE `eproject`.`products` ADD CONSTRAINT fk_brandID_products FOREIGN KEY (brandID) REFERENCES `eproject`.`brand`(brandID);

ALTER TABLE `eproject`.`carts` ADD CONSTRAINT fk_productID_carts FOREIGN KEY (productID) REFERENCES `eproject`.`products`(productID);
ALTER TABLE `eproject`.`carts` ADD CONSTRAINT fk_userID_carts FOREIGN KEY (userID) REFERENCES `eproject`.`user`(userID);

ALTER TABLE `eproject`.`feedback` ADD CONSTRAINT fk_orderID_feedback FOREIGN KEY (orderID) REFERENCES `eproject`.`order`(orderID);
ALTER TABLE `eproject`.`feedback` ADD CONSTRAINT fk_userID_feedback FOREIGN KEY (userID) REFERENCES `eproject`.`user`(userID);

ALTER TABLE `eproject`.`order` ADD CONSTRAINT fk_userID_order FOREIGN KEY (userID) REFERENCES `eproject`.`user`(userID);

ALTER TABLE `eproject`.`orderDetails` ADD CONSTRAINT fk_orderID_orderDetails FOREIGN KEY (orderID) REFERENCES `eproject`.`order`(orderID);
ALTER TABLE `eproject`.`orderDetails` ADD CONSTRAINT fk_productID_orderDetails FOREIGN KEY (productID) REFERENCES `eproject`.`products`(productID);

DELIMITER //
CREATE TRIGGER trg_order_insert
AFTER INSERT
ON `eproject`.`order`
FOR EACH ROW
BEGIN
  DELETE FROM `eproject`.`carts` WHERE `cartCode` = NEW.cartCode;
END;
//
CREATE TRIGGER trg_orderDetails_insert
AFTER INSERT
ON `eproject`.`orderDetails`
FOR EACH ROW
BEGIN
	UPDATE `eproject`.`products` SET `quantity` = `quantity` - NEW.orderQuantity WHERE `productID` = NEW.productID;
END;

DELIMITER ;

INSERT INTO `eproject`.`brand`
VALUES
	(DEFAULT,'Samsung'),
    (DEFAULT,'Western Digital (WD)'),
    (DEFAULT,'Seagate'),
    (DEFAULT,'SanDisk'),
    (DEFAULT,'Kingston'),
    (DEFAULT,'Transcend');

INSERT INTO `eproject`.`category`
VALUES
	(DEFAULT,'Hard Disk Drive - HDD'),
    (DEFAULT,'Solid State Drive - SSD'),
    (DEFAULT,'USB Flash Drive'),
    (DEFAULT,'Memory Card'),
    (DEFAULT,'Random Access Memory - RAM'),
    (DEFAULT,'Portable Hard Drive');
    
INSERT INTO `eproject`.`products`
VALUES
	(DEFAULT, 'Samsung SSD 1TB T7 Shield 1050MB/s MU-PE1T0', 'Photos/Samsung/Samsung-SSD-01.jpg', '275', '100', 2, 1, '1TB', '1050MB/s', 'Beige', '3 years', '880 x 590 x 130mm', 'Samsung T7 Shield 1TB SSD Portable Hard Drive has the Ability to download applications for mobile phones, tablets, PC and Mac, gaming consoles, etc. and upgrade software for PC and Mac.\nThe Samsung Portable T7 Shield 1TB SSD mobile storage product absolutely secures your data.\nSamsung portable SSD hard drive with the highest quality rubber outer casing, water and dust resistance meeting IP65 standards, and resistant to falling at a height of up to 3m.'),
    (DEFAULT, 'PRO Ultimate + Reader Full Size SDXC Card 512GB','Photos/Samsung/Samsung-MemoryCard-02.jpg',77.99,300,4,1,'512GB','200MB/s Read, 130MB/s Write','White','3 years','32mm x 24mm x 2.1mm','Spend more time creating and less time saving with read and write speeds up to 200/130 MB/s1 when using Samsung USB readers.\nWhether you’re using a DSLR camera or a PC, count on the PRO Ultimate for compatibility.\nDesigned to survive the rough and tumble of field work, the PRO Ultimate has built-in protection from elements like water and heat.\nSave every second in mere minutes with storage capacities ranging from 64GB to 512GB.'),
    (DEFAULT, 'PRO Ultimate Full Size SDXC 512GB','Photos/Samsung/Samsung-MemoryCard-03.jpg',77.99,400,4,1,'512GB','200MB/s Read, 130MB/s Write','White','3 years','32mm x 24mm x 2.1mm','Spend more time creating and less time saving with read and write speeds up to 200/130 MB/s¹ when using Samsung USB readers.\nWhether you’re using a DSLR camera or a PC, count on the PRO Ultimate for compatibility.\nDesigned to survive the rough and tumble of field work, the PRO Ultimate has built-in protection from elements like water and heat.\nSave every second in mere minutes with storage capacities ranging from 64GB to 512GB.'),
    (DEFAULT, 'PRO Ultimate + Adapter microSDXC 512GB','Photos/Samsung/Samsung-MemoryCard-04.jpg',54.99,200,4,1,'512GB','200MB/s Read, 130MB/s Write','Black','4 years','15mm x 11mm x 1 mm','Spend more time creating and less time saving with read and write speeds up to 200/130 MB/s¹ when using Samsung USB readers\nWhether you’re using a smartphone or a gaming console, count on the PRO Ultimate microSD for compatibility\nWith 10-year limited warranty, PRO Ultimate MicroSD is tough enough to take on anything with protection from water⁵ to extreme temps.\nPile in the files and expand your portfolio with a wide range of storage options from 128GB to 512GB'),
    (DEFAULT, 'BAR Plus USB 3.1 Flash Drive 256GB Titan Grey','Photos/Samsung/Samsung-USB-05.jpg',26.99,200,3,1,'256GB','400MB/s Data Transfer Speed','Grey','4 years','80mm x 30mm x 25mm','A modern take on a classic. The next generation Bar Plus elevates the flash drive to an everyday essential, offering impressive speeds in a striking design. Fits in your hand, a pure minimalism that cleverly blends style, speed, and reliability.\nGet your time back. Fast and convenient read speeds up to 400MB/s¹ with the latest USB 3.1 standard gives you more time to work, play, watch, and create. Send a 3GB 4K UHD video file from your Bar Plus to your PC in just 10 seconds.'),
    (DEFAULT, 'FIT Plus USB 3.1 Flash Drive 256GB','Photos/Samsung/Samsung-USB-06.jpg',25.99,200,3,1,'256GB','400MB/s Data Transfer Speed','grey','4 years','31mm x 25mm x 10mm','Expand your storage with a compact fit designed to plug in and stay. Read speeds up to 400 MB/s with the latest USB 3.1 standard.\nSafeguard your data with a 5-year limited warranty.'),
    (DEFAULT, 'DUO Plus USB Type-C Flash Drive 64GB','Photos/Samsung/Samsung-USB-07.jpg',17.99,300,3,1,'64GB','300MB/s Data Transfer Speed','Grey','4 years','76mm x 24mm x 9mm"','Two flash drives in one, to double your connectivity\nBlazing USB 3.1 read speeds up to 300 MB/s. Backward compatible with USB 3.0/2.0.'),
    (DEFAULT, 'Portable SSD T5 EVO USB 3.2 2TB (Black)','Photos/Samsung/Samsung-PortalSSD-08.jpg',189.99,400,6,1,'2TB ','460 MB/s Read','Black','4 years','93.98mm x 40.64mm x 17.78mm','Make a big save wherever your projects take you with the small but mighty T5 EVO—available in storage capacity of 2TB.\nThe T5 EVO is optimized for large file transfers with improved Intelligent TurboWrite and speeds\nThis strong, sturdy sidekick will help you see it through with shock resistance and fall protection up to 6 feet.\n Whether you’re using a desktop or a gaming console,² count on the T5 EVO Portable SSD for compatibility.'),
    (DEFAULT, 'Portable SSD T9 USB 3.2 Gen2x2 1TB (Black)','Photos/Samsung/Samsung-PortalSSD-09.jpg',129.99,400,6,1,'1TB ','2,000MB/s','Black','4 years','93.98mm x 40.64mm x 17.78mm','Load, edit and transfer with sustained read and write speeds of up to 2,000MB/s.\nStay cool with its advanced thermal solution.\nWhether you’re using a desktop or a gaming console,³ count on the T9 Portable SSD for compatibility.\nWith up to 4TB capacity, the T9 Portable SSD offers plenty of storage space making it a safe bet for capturing all your creative endeavors.'),
    (DEFAULT, 'Portable SSD T7 Shield USB 3.2 2TB (Black)','Photos/Samsung/Samsung-PortalSSD-10.jpg',179.99,500,6,1,'2TB ','1,050 MB/s Read,/1,000 MB/s Write','Black','3 years','59 x 88 x 13mm','High performance on-the-go, with rugged durability.\nIP65 rating for water and dust resistance, with Dynamic Thermal Guard to control heat.'),
    (DEFAULT, 'Portable SSD T7 USB 3.2 500GB (Gray)','Photos/Samsung/Samsung-PortalSSD-11.jpg',89.99,100,6,1,'500GB','1,050 MB/s Read, 1,050 MB/s Write','Gray','4 years','11mm x 75mm x 10mm','SSD with strong durability & blazing fast transfer speeds/n1st Flash Memory Brand'),
    (DEFAULT, 'Portable SSD T7 TOUCH USB 3.2 1TB (Black)','Photos/Samsung/Samsung-PortalSSD-12.jpg',159.99,150,6,1,'1TB','1,050 MB/s Read,/1,000 MB/s Write','Black','5 years','11mm x 75mm x 10mm','The Portable T7 Touch SSD gives you speed and fingerprint security in a palm-sized package./nBuilt-in security options on the T7 Touch utilize AES 256-bit encryption and give you the option of unlocking with a touch of your finger or with a password/nWith read/write speeds of up to 1,050/1,000 MB/s, the T7 Touch is 9.5x faster than an external hard disk drive.'),
	(DEFAULT, '990 PRO w/ Heatsink PCIe® 4.0 NVMe™ SSD 4TB','Photos/Samsung/Samsung-SSD-13.jpg',359.99,250,2,1,'4TB','7,450 MB/s Read','Black Red','6 years',' 80.15mm x 25mm x 8.88mm','Gen4 steps up to the arena with more than 55% improvement in random performance compared to 980 PRO.\nWith read and write speeds up to 7450/6900 MB/s², you’ll reach near max performance of PCIe® 4.0³ powering through for any use.\nGive yourself some space with storage capacities from 1TB to 4TB.\nThe ultra-slim Integrated Heatsink dissipates heat from your device for uninterrupted play.'),
    (DEFAULT, '990 PRO PCIe® 4.0 NVMe® SSD 1TB','Photos/Samsung/Samsung-SSD-14.jpg',99.99,350,2,1,'1TB','7,450 MB/s Read, 6,900 MB/s Write','Black','2 years','80mm x 22mm x 2.3mm','Designed for tech enthusiasts, hardcore gamers and heavy-workload professionals who want blazing fast speed.\nEnjoy up to 50% improved performance per watt over 980 PRO, plus optimal power efficiency with max PCIe® 4.0 performance.\nSequential read/write speeds up to 7,450/6,900 MB/s.'),
    (DEFAULT, '980 PRO PCIe® 4.0 NVMe® SSD 1TB','Photos/Samsung/Samsung-SSD-15.png',89.99,300,2,1,'1TB','7,000 MB/s Read, 5,000 MB/s Write','Black','1 years','105mm x 31mm x 2.9mm','Genuine PCIe 4.0 NVMe™ speed (up to 7,000/5,000MB/s for read/write speed). Ideal for heavy computing, high resolution graphics and PC gaming.\nFor console gaming, compatible only with Playstation® 5. Must be installed with a heatsink (sold separately).'),
    (DEFAULT, '870 EVO SATA 2.5" SSD 500GB','Photos/Samsung/Samsung-SSD-16.jpg',49.99,400,2,1,'500GB','560 MB/s Read, 530 MB/s Write','Black','3 years','131mm x 92mm x 9mm','Maximize SATA interface limit up to 560/530 MB/s for read and write sequential speeds.\nUp to 300 TBW* under a 5 year limited warranty.'),
    (DEFAULT, '970 EVO Plus NVMe® M.2 SSD 1TB','Photos/Samsung/Samsung-SSD-17.jpg',99.99,500,2,1,'1TB','3,500 MB/s Read, 3,300 MB/s Write','Black','4 years','105mm x 29mm x 3mm','Superior NVMe® Read/Write performance with speeds up to 3,500/3,300 MB/s\nV-NAND reliability backed by up to 5 yr. warranty'),
    (DEFAULT, '980 PRO w/ Heatsink PCIe® 4.0 NVMe® SSD 1TB','Photos/Samsung/Samsung-SSD-18.jpg',89.99,400,2,1,'1TB','7000 MB/s Read, 5000 MB/s Write','Black','5 years','24mm x 80mm x 8.6 mm','True PCIe® 4.0 NVMe™ speed (up to 7,000 MB/s for seq. reads,  5,100MB/s for seq. writes)\nIdeal for heavy computing, high resolution graphics and PC gaming.\nFor console gaming, compatible only with Playstation® 5.'),
	(DEFAULT, 'USB Type-C™ Flash Drive 64GB (MUF-64DA/AM)','Photos/Samsung/Samsung-USB-19.jpg',11.99,500,3,1,'64GB','300 MB/s Read, 200 MB/s Write','Blue','5 years','33.7mm x 15.9mm x 8.2 mm','USB Type C Drive has transfer speeds up to 4GB in just 11 seconds.\nWater-proof, shock-proof and temperature-proof.\nCompatible with USB 3.0 and USB 2.0 systems.\nLimited 5 year warranty'),
	(DEFAULT, 'EVO Select microSD Memory Card 64GB','Photos/Samsung/Samsung-MemoryCard-20.jpg',11.99,500,4,1,'64GB','100 MB/s Read, 60 MB/s Write','Green','5 years','19mm x 14mm x 1.5 mm','Up to 100MB/s Read and 60MB/s Write speed with Class 10 and U3 compatibility. Includes Full-Size SD Adapter.\nExcellent Performance for 4K UHD Video and broad compatibility across multiple applications. 10-Year limited warranty.'),
	(DEFAULT, 'EVO microSD Memory Card 32GB','Photos/Samsung/Samsung-MemoryCard-21.jpg',7.99,500,4,1,'32GB',' 95MB/s Transfer','Orange','5 years','19mm x 14mm x 1.5mm','Up to 95MB/s Transfer speed with Class 10 and U1 compatibility. Includes Full-Size SD Adapter.\nExcellent Performance for Full HD video and broad compatibility across multiple applications. 10-Year limited warranty.'),
	(DEFAULT, 'EVO Plus microSDXC Memory Card 256GB - 2 Pack','Photos/Samsung/Samsung-MemoryCard-22.jpg',199.98,500,4,1,'256GB','100MB/s Read and 90MB/s Write','Red','5 years','19mm x 14mm x 1.5mm','Get more space, faster speeds, and free up your devices to do more in 4K.\nGet up to 100MB/s read and 90MB/s write speed with Class 10 and U3 compatibility. Backed by 4-proof protection, the EVO can withstand up to 72 hours in seawater¹, extreme temperatures², airport X-ray machines³ and magnetic fields⁴ equivalent to an MRI scanner.  Includes a full-size SD Adapter. Comes with a 10-year limited warranty.'),
	(DEFAULT, 'PRO Endurance microSD Memory Card 32GB','Photos/Samsung/Samsung-MemoryCard-23.jpg',10.99,500,4,1,'32GB','100MB/s Read,30MB/s Write ','Black-White','5 years','19mm x 14mm x 1.5mm','Up to 17,520 hours of lasting performance for continuous video monitoring.\nSuperior Endurance backed by a 2-Year Limited Manufacturers Warranty.'),
	(DEFAULT, 'EVO Plus + Adapter microSDXC 128GB','Photos/Samsung/Samsung-MemoryCard-24.jpg',17.99,500,4,1,'128GB','130MB/s Transfer','White','5 years','19mm x 14mm x 1.5mm','Up to 130MB/s transfer speed with Class 10 and U3 compatibility. Includes Full-Size SD Adapter.\nHigh performance for 4K UHD video and photos and more with 10-Year limited warranty.');
	

 INSERT INTO `eproject`.`products` (
  `productID`,
  `productName`,
  `imageLink`,
  `unitPrice`,
  `quantity`,
  `categoryID`,
  `brandID`,
  `memory`,
  `speed`,
  `color`,
  `warranty`,
  `dimension`,
  `description`
)
VALUES
	(DEFAULT, 'Industrial SD Memory Card', 'Photos/Kingston/Kingston-MemoryCard-01.jpg', 18.21,1000, '4', '5', '64GB', '100MB/s read, 80MB/s write', 'Grey', '3 years', '24mm x 32mm x 2.1mm', 'Industrial SD memory cards are designed for use in demanding industrial environments. Key features include extended temperature range, high reliability, shock and vibration resistance, error correction, wear leveling, long product lifecycle, security features, compatibility with standard SD slots, and various capacity options. These cards are tailored to meet the rigorous requirements of applications in manufacturing, automation, transportation, and other industrial settings.'),
	(DEFAULT, 'Industrial microSD Memory Card', 'Photos/Kingston/Kingston-MemoryCard-02.jpg', 21.85,1000, '4', '5', '32GB', '100MB/s read, 80MB/s write', 'Black', '3 years', '11mm x 15mm x 1mm', 'Industrial microSD memory cards are compact storage solutions specifically crafted for use in demanding industrial environments. These cards share similarities with standard microSD cards but are engineered to meet the robust requirements of industrial applications. Key features include extended temperature range, high reliability, resistance to shock and vibration.'),
	(DEFAULT, 'High-Endurance microSD Memory Card', 'Photos/Kingston/Kingston-MemoryCard-03.jpg', 27.95,1000, '4', '5', '128GB', '95MB/s Read and 45MB/s Write', 'White', '3 years', '11mm x 15mm x 1mm', 'High-endurance microSD cards are designed for applications with frequent data access. They offer durability through a high number of read and write cycles, extended lifespan, advanced error correction, wear leveling, and compatibility with standard microSD slots. Ideal for continuous recording devices, dashcams, and surveillance systems, these cards come in various capacities and may include brand-specific technologies for enhanced performance and reliability.'),
	(DEFAULT, 'Canvas Select Plus SD Card', 'Photos/Kingston/Kingston-MemoryCard-04.jpg', 12.42,1000, '4', '5', '512GB', '100/85MB/s Read/Write', 'White', 'Lifetime', '24mm x 32mm x 2.1mm', 'The Canvas Select Plus SD Card, offered by Kingston, provides reliable storage with options for different performance levels, capacities, and speed class ratings. Designed for compatibility with various devices, it is suitable for tasks like photo capture, video recording, and general digital content storage. For the latest and detailed information, it is recommended to check Kingston\'s official website.'),
	(DEFAULT, 'DC1000B M.2 NVMe SSD', 'Photos/Kingston/Kingston-SSD-05.jpg', 65.57,1000, '2', '5', '960GB', '3,400MBs/925MBs', 'Blue', '5 years', '80mm x 22mm x 3.8mm', 'The DC1000B M.2 NVMe SSD by Kingston is a compact and high-performance storage solution designed for use in M.2 slots. It offers various capacity options, fast data transfer speeds typical of NVMe technology, and is likely targeted at enterprise or business applications.'),
	(DEFAULT, 'DC600M 2.5” SATA Enterprise SSD', 'Photos/Kingston/Kingston-SSD-06.jpg', 65.57,1000, '2', '5', '7680GB', '560MBs/530MBs', 'Black', '5 years', '69.9mm x 100mm x 7mm', 'The DC600M 2.5” SATA Enterprise SSD by Kingston is a reliable and high-performance solid-state drive designed for enterprise use. With a 2.5-inch SATA form factor, it offers various capacity options and features tailored for data center applications, emphasizing durability and consistent performance. For the latest details, refer to Kingston\'s official website.'),
	(DEFAULT, 'A400 SATA SSD', 'Photos/Kingston/Kingston-SSD-07.jpg', 37.11,1000, '2', '5', '480GB', '500MB/s Read and 450MB/s Write', 'Grey', '3 years', '100.0mm x 69.9mm x 7.0mm', 'The A400 SATA SSD is a solid-state drive manufactured by Kingston Technology. It utilizes SATA III (6Gb/s) interface for data transfer and is designed to significantly enhance system responsiveness and overall performance. With no moving parts, it offers faster boot times, quicker application loading, and improved system efficiency compared to traditional hard drives.'),
	(DEFAULT, 'Mini Dragon USB Flash Drive', 'Photos/Kingston/Kingston-USB-08.jpg', 22.68,1000, '3', '5', '128GB', '200MB/s-Read, 60MB/s-Write', 'Green', '5 years', '31.77mm x 33.63mm x 40.24mm', 'The Mini Dragon USB Flash Drive is a compact and portable storage solution characterized by its unique dragon-inspired design. Manufactured by an unspecified company (as of my last knowledge update in January 2022), this USB drive typically offers plug-and-play functionality with USB connectivity for quick and easy data transfer.'),
	(DEFAULT, 'Kingston IronKey Vault Privacy 50 Series', 'Photos/Kingston/Kingston-USB-09.jpg', 123.3,1000, '3', '5', '8GB', '250MB/s read, 180MB/s write', 'Blue', '5 years', '77.9 mm x 21.9 mm x 12.0 mm', 'The Kingston IronKey Vault Privacy 50 Series is a secure USB flash drive designed to protect sensitive data. It features hardware-based encryption and a keypad for PIN authentication, providing robust security for confidential information. The drive is built with a rugged metal casing, making it durable and resistant to physical damage.'),
	(DEFAULT, 'Kingston IronKey S1000 Encrypted USB Flash Drive', 'Photos/Kingston/Kingston-USB-10.jpg', 226.9,1000, '3', '5', '4GB', '180MB/s read, 80MB/s write', 'Grey', '5 years', '82.3mm x 21.1mm x 9.1mm', 'The Kingston IronKey S1000 is an encrypted USB flash drive designed to provide robust security for sensitive data. It features hardware-based encryption and a durable, tamper-evident design to protect against physical and cyber threats.'),
	(DEFAULT, 'Kingston IronKey D500S Hardware-encrypted USB', 'Photos/Kingston/Kingston-USB-11.jpg', 288.07,1000, '3', '5', '256GB', '240MB/s read, 170MB/s write', 'Black', '5 years', '77.9 mm x 21.9 mm x 12.0 mm', 'The Kingston IronKey D500S is a hardware-encrypted USB flash drive designed for secure data storage. It features robust hardware-based encryption to protect sensitive information. The drive is FIPS 140-2 Level 3 certified, ensuring a high level of security for government and enterprise use'),
	(DEFAULT, 'NV2 PCIe 4.0 NVMe SSD', 'Photos/Kingston/Kingston-SSD-12.jpg', 27.99,1000, '2', '5', '4TB', '3,500/2,800MB/s', 'Blue', '3 years', '22mm x 80mm x 2.2mm', 'The NV2 PCIe 4.0 NVMe SSD is a high-performance solid-state drive designed for ultra-fast data transfer. Utilizing the PCIe 4.0 interface, it offers significantly higher bandwidth compared to previous generations, delivering blazing-fast read and write speeds.'),
	(DEFAULT, 'XS2000 External Solid State Drive', 'Photos/Kingston/Kingston-SSD-13.jpg', 59.99,1000, '2', '5', '500GB', '2,000MB/s Read, 2,000MB/s Write', 'White', '5 years', '69.54 x 32.58 x 13.5mm', 'The XS2000 External Solid State Drive is likely a high-speed, portable storage solution designed for external use. It employs solid-state technology for faster data transfer rates compared to traditional hard drives.'),
	(DEFAULT, 'KC600 2.5" and mSATA SSD', 'Photos/Kingston/Kingston-SSD-14.jpg', 28.87,1000,  '2', '5', '256GB', '550MB/s Read, 500MB/s Write', 'Black', '5 years', '100.1mm x 69.85mm x 7mm', 'The KC600 2.5" and mSATA SSDs are solid-state drives produced by Kingston Technology. The 2.5" variant is designed to fit into standard 2.5-inch drive bays, commonly found in laptops and desktops, while the mSATA variant is a smaller form factor suitable for devices with mSATA slots.'),
	(DEFAULT, 'DT4000G2 Encrypted USB Flash Drive', 'Photos/Kingston/Kingston-USB-15.jpg', 68.99,1000, '3', '5', '8GB', '165MB/s read, 22MB/s write', 'black', '5 years', '77.9 mm x 22.2 mm x 12.05 mm', 'The DT4000G2 Encrypted USB Flash Drive is a secure and portable storage solution provided by Kingston Technology. It features hardware-based encryption, ensuring data protection with robust security measures. The drive is designed to safeguard sensitive information and prevent unauthorized access.'),
	(DEFAULT, 'DataTraveler Exodia Onyx USB Flash Drive', 'Photos/Kingston/Kingston-USB-16.jpg', 10.27,1000, '3', '5', '500GB', 'USB 3.2 Gen 1 compliant', 'Black', '5 years', '60.7mm x 21mm x 10.2mm', 'The DataTraveler Exodia Onyx is a USB flash drive produced by Kingston. It features a sleek black design and offers convenient portable storage for files, documents, and media. With USB 3.2 Gen 1 connectivity, it provides fast data transfer speeds.'),
	(DEFAULT, 'DataTraveler Exodia USB Flash Drive', 'Photos/Kingston/Kingston-USB-17.jpg', 9.44,1000, '3', '5', '256GB', 'USB 3.2 Gen 1 compliant', 'BLack', '5 years', '	67.3mm x 21.04mm x 10.14mm', 'The DataTraveler Exodia is a USB flash drive developed by Kingston Technology. It offers portable storage with a sleek design and is equipped with a capless, retractable USB connector, eliminating the need for a separate cap. The drive provides quick and convenient data transfer through USB 3.2 Gen 1 connectivity.'),
	(DEFAULT, 'DataTraveler Kyson USB Flash Drive', 'Photos/Kingston/Kingston-USB-18.jpg', 17.32,1000, '3', '5', '32GB', ' 200MB/s read, 60MB/s write', 'Silver', '5 years', '	39mm x 12.6mm x 4.9mm', 'The DataTraveler Kyson is a USB flash drive developed by Kingston. It provides portable storage with a sleek design and USB 3.2 Gen 1 (USB 3.0) connectivity for fast data transfer speeds. Available in different capacities, the Kyson offers a convenient way to store and transfer files, documents, and multimedia'),
	(DEFAULT, 'Kingston IronKey Keypad 200 Series', 'Photos/Kingston/Kingston-USB-19.jpg', 271.75,1000, '3', '5', '8GB', '145MB/s read, 115MB/s write', 'Blue', '5 years', '80mm x 20mm x 11mm', 'The Kingston IronKey Keypad 200 Series is a secure USB flash drive designed for enhanced data protection. It features a built-in alphanumeric keypad for PIN authentication, adding an extra layer of security.'),
	(DEFAULT, 'Kingston IronKey D300S Encrypted USB Flash Drive', 'Photos/Kingston/Kingston-USB-20.jpg', 59,1000, '3', '5', '64GB', '250MB/s read, 85MB/s write', 'Black', '5 years', '77.9 mm x 22.2 mm x 12.05 mm', 'The Kingston IronKey D300S is an encrypted USB flash drive designed for secure data storage. It features hardware-based encryption, using 256-bit AES in XTS mode, providing robust protection for sensitive information.'),
	(DEFAULT, 'High-Endurance microSD Memory Card', 'Photos/Kingston/Kingston-MemoryCard-21.jpg', 26.76,1000, '4', '5', '64GB', '95MB/s Read and 30MB/s Write', 'Black', '3 years', '11mm x 15mm x 1mm', 'A high-endurance microSD memory card is a storage solution designed for continuous and demanding use, such as in surveillance cameras, dashcams, or other devices that require frequent read/write cycles.'),
	(DEFAULT, 'DataTraveler Max USB 3.2 Gen 2 Series Flash Drive', 'Photos/Kingston/Kingston-USB-22.jpg', 110.93,1000, '3', '5', '256GB', ' 1,000MB/s read, 900MB/s write', 'Pink', '3 years', '82.17 mm x 22.00 mm x 9.02 mm', 'The DataTraveler Max USB 3.2 Gen 2 Series is a high-performance flash drive by Kingston Technology. It features USB 3.2 Gen 2 connectivity for fast data transfer speeds. With a sleek design and durable metal casing, it provides reliable and secure storage in capacities ranging from moderate to high.'),
	(DEFAULT, 'Canvas Select Plus microSD Memory Card', 'Photos/Kingston/Kingston-MemoryCard-23.jpg', 6.56,1000, '4', '5', '32GB', '100MB/s Read, UHS-I Speed Class, U1, V10', 'Black', '5 years', '11mm x 15mm x 1mm', 'The Canvas Select Plus microSD Memory Card is a product offered by Kingston Technology. It is a microSD card designed for use in various devices such as cameras, smartphones, and tablets.'),
	(DEFAULT, 'DataTraveler Exodia M USB Flash Drive', 'Photos/Kingston/Kingston-USB-24.jpg', 3.09,1000, '3', '5', '64GB', 'USB 3.2 Gen 1 compliant', 'Blue', '5 years', '	67.4mm x 21.8mm x 11.6mm', 'The DataTraveler Exodia M is a USB flash drive manufactured by Kingston. It offers portable storage with a compact and durable design. The "M" in its name likely denotes its compatibility with USB Type-C ports. With various storage capacities.'),
    (DEFAULT, 'Ram Kingston Fury Beast White RGB 32GB', 'Photos/Kingston/Kingston-RAM-25.jpg', 160.07,1000, '5', '5', '32GB', '4800MB/s read, 5200MB/s write', 'White', '5 years', '133,35 mm x 42,23 mm x 7,11 mm', 'The Kingston Fury Beast White RGB 32GB DDR5 5600MHz Kit (KF556C40BWAK2-32) is a high-performance RAM kit designed for gaming and content creation. With a capacity of 32GB spread across two modules, it operates at a fast speed of 5600MHz, ensuring smooth multitasking and responsiveness.'),
	(DEFAULT, 'Ram Kingston Fury Beast RGB 64GB DDR5', 'Photos/Kingston/Kingston-RAM-26.jpg', 246.48,1000, '5', '5', '64GB', '4800MB/s, 5200MB/s write', 'Black', '5 years', '133,35 mm x 42,23 mm x 7,11 mm', 'The Kingston Fury Beast RGB 64GB DDR5 5200MHz Kit (KF552C40BBAK2-64) is a high-performance RAM kit designed for gaming and demanding applications. Featuring DDR5 technology, it provides fast data transfer rates at 5200MHz. The kit includes two modules, each with a capacity of 32GB, totaling 64GB. The RGB lighting adds a customizable aesthetic to your system.'),
	(DEFAULT, 'Ram Kingston Fury Beast 16GB DDR5', 'Photos/Kingston/Kingston-RAM-27.jpg', 81.88,1000, '5', '5', '16GB', '4800MB/s Read and 5200MB/s Write', 'Black', '5 years', '133,35 mm x 34,9 mm x 6,62 mm', 'The Kingston Fury Beast 16GB DDR5 5600MHz RAM (model KF556C40BB-16) is a high-performance memory module designed for gaming and other demanding applications. With a capacity of 16GB and a fast clock speed of 5600MHz, it delivers quick data transfer rates for improved system responsiveness.'),
	(DEFAULT, 'Ram Kingston Fury Beast 8GB DDR5', 'Photos/Kingston/Kingston-RAM-28.jpg', 57.20,1000, '5', '5', '8GB', '4800MB/s, 5200MB/s write', 'Black', '5 years', '133,35 mm x 34,9 mm x 6,62 mm', 'The Kingston Fury Beast 8GB DDR5 4800MHz (model KF548C38BB-8) is a high-performance RAM module designed for gaming and demanding applications. It features a capacity of 8GB and operates at a fast 4800MHz frequency, providing swift data transfer for enhanced system responsiveness.');

 
INSERT INTO `eproject`.`products` (
	`productID`, 
    `productName`, 
    `imageLink`, 
    `unitPrice`, 
    `quantity`, 
    `categoryID`, 
    `brandID`, 
    `memory`, 
    `speed`, 
    `color`, 
    `warranty`, 
    `dimension`, 
    `description`
) VALUES 
-- HDD
(DEFAULT ,'WD Red Pro NAS Hard Drive','Photos/SanDisk/SanDisk-HDD-01.png', 92.99, 70, 1, 4, '1TB', '7200RPM', 'Red', '5 year', '3.5 inch', 
    'Ideal for creative pros, medium to large businesses, and commercial/enterprise NAS systems.\nFor RAID-optimized NAS systems with an unlimited number of bays.\nRated for 550TB/year workloads1 and up to 2.5M hours MTBF.'
),
(DEFAULT ,'My Book','Photos/SanDisk/SanDisk-HDD-02.png', 134.99, 150, 1, 4, '4TB', '5Gb/s ', 'Black', '3 year', '3.5 inch', 
    'Complete, streamlined backup solution.\nEasy-to-use password protection.\n256-bit AES hardware encryption.'
),
(DEFAULT ,'WD Elements SE','Photos/SanDisk/SanDisk-HDD-03.png', 44.99, 70, 1, 4, '1TB', '291 MB/s', 'Black', '5 year', '3,5 inch', 
    'Improves PC performance .\nBuilt for durability, shock tolerance, and reliability.\nHigh capacity in a compact design.'
),
(DEFAULT ,'My Cloud Pro Series PR4100','Photos/SanDisk/SanDisk-HDD-04.png', 769.99, 210, 1, 4, '8TB', '560MB/s2', 'Black', '4 year', '12.10x44.41 mm', 
    'Third-party app support.\nFeatures four 3.5-inch hard drive bays .\nIdeal for small business and home office.'
),
-- SSD
(DEFAULT ,'SanDisk Extreme PRO SSD','Photos/SanDisk/SanDisk-SSD-01.png', 119.99, 50, 2, 4, '1TB', '2000MB/s2 read/write', 'Black', '5 year', '8.60x12.10x44.41 mm', 
    'Save time storing and transferring data with powerful NVMe solid state performances.\nA forged aluminum chassis acts as a heatsink to deliver higher sustained speeds.\nUp to three-meter drop protection and IP65 water and dust resistance.'
),
(DEFAULT ,'WD_BLACK SN770M NVMe™ SSD','Photos/SanDisk/SanDisk-SSD-02.png', 79.99, 110, 2, 4, '500GB', '5,150 MB/s2', 'Black', '5 year', '8.60x12.10x44.41 mm', 
    'Play more games wherever you are with up to 2TB of trusted Western Digital TLC 3D NAND storage.\nExclusive gaming features including PCIe® Gen 4.0, Western Digital nCache 4.0 technology, and Microsoft’s DirectStorage Support.'
),
(DEFAULT ,'WD_BLACK C50 Expansion Card for Xbox','Photos/SanDisk/SanDisk-SSD-03.png', 79.99, 200, 2, 4, '512GB', '2000 MB/s2', 'Black', '3 year', '8.60x12.10 mm', 
    'Plug-and-play with your Xbox™ Series X|S, so you don’t have to worry about compatibility or opening your console to install.\nQuick Resume-compatible, allowing you to suspend your current game, play a different game, then come back to the first game as if you never left .'
),
(DEFAULT ,'SanDisk Ultra 3D SSD','Photos/SanDisk/SanDisk-SSD-04.png', 39.99, 150, 2, 4, '500GB', '560MB/s2', 'Black', '5 year', '12.10x44.41 mm', 
    'Endurance of up to 600TBW.\nSpeed up your boot-up, shut-down, and app load and response times.\nGreater drive endurance and reliability, plus lower power usage with new 3D NAND technology.'
),
-- USB
(DEFAULT ,'Ultra Dual Drive Go USB Type-C™','Photos/SanDisk/SanDisk-USB-01.png', 9.99, 300, 3, 4, '32GB', '150MB/s2', 'Black', '4 year', '487x97 mm ', 
    'Third-party app support.\nFeatures four 3.5-inch hard drive bays .\nIdeal for small business and home office.'
),
(DEFAULT ,'SanDisk Ultra Dual Drive Luxe USB Type-C™ Flash Drive','Photos/SanDisk/SanDisk-USB-02.png', 11.49, 500, 3, 4, '32GB', '170MB/s2', ' Silver', '3 year', '487x97 mm', 
    'Dual-purpose swivel design helps protects connectors and features a keyring hole to take your drive on the go.\nSeamlessly move content between compatible smartphones, tablets, and computers .\nThe 2-in-1 flash drive with reversible USB Type-C and Type-A connectors.'
),
(DEFAULT ,'Clearance - Ultra Dual Drive Go USB Type-C™','Photos/SanDisk/SanDisk-USB-03.png', 49.99, 300, 3, 4, '512TB', '150MB/s2', 'Blue', '2 year', '487x97 mm', 
    'The 2-in-1 flash drive with USB Type-C™ and Type-A connectors.\nAutomatically back up photos with SanDisk Memory Zone app.\nThe 2-in-1 flash drive with USB Type-C™ and Type-A connectors.'
),
(DEFAULT ,'SanDisk Ultra Shift USB 3.2 Gen 1 Flash Drive','Photos/SanDisk/SanDisk-USB-04.png', 129.99, 50, 3, 4, '1TB', 'up to 100MB/s2', 'Black', '2 year', '487x97 mm', 
    'Transfer files easily and quickly with USB 3.2 Gen 1 interface.\nCompact design for on-the-go lifestyle.\nPassword-protect your files using a downloadable software .'
),
-- Memory card
(DEFAULT ,'Nintendo®-Licensed Memory Cards For Nintendo Switch™','Photos/SanDisk/SanDisk-MemoryCard-01.png', 12.99, 100, 4, 4, '64GB', 'up to 100MB/s2', 'Green', '2 year', '15 x 11 x 1.0 mm', 
    'Load games faster with transfer rates up to 100MB/s.\nInstantly add up to 1TB of additional space.\nDesigned, tested, and approved for the Nintendo Switch console  .'
),
(DEFAULT ,'SanDisk Extreme® microSDXC™ UHS-I CARD','Photos/SanDisk/SanDisk-MemoryCard-02.png', 12.99, 400, 4, 4, '128GB', 'up to 190MB/s9', 'Fold&Red', '2 year', '15 x 11 x 1.0 mm', 
    'Water-proof, temperature proof, X-ray proof, magnet proof, shock proof.\nClass 10 for Full HD video playback – watch right from the card.\nUp to 120MB/s transfer speeds let you move photos and files fast.'
),
(DEFAULT ,'SanDisk MAX ENDURANCE microSD™ Card','Photos/SanDisk/SanDisk-MemoryCard-03.png', 44.99, 156, 4, 4, '256GB', 'up to 100MB/s2', 'Silver', '2 year', '0.04 x 0.59 x 0.43 inch', 
    'Designed to last1, this microSD card can withstand a variety of extreme weather conditions because it’s temperature-proof, waterproof, shockproof, and X-ray proof.2 With capacities of up to 256GB7, you can record and store more Full HD or 4K videos3. And, with read speeds up to 100MB/s5, you’ll be able to spend less time transferring and backing up video footage, and more time living life..\nRecord Full HD and 4K video.'
),
(DEFAULT ,'SanDisk Extreme SD UHS-I Card','Photos/SanDisk/SanDisk-MemoryCard-04.png', 62.99, 263, 4, 4, '512B', 'up to 180MB/s6', 'Black Gold', '2 year', '0.04 x 0.59 x 0.43 inch', 
    'With the SanDisk Extreme SD UHS-I memory card save time transferring media with read speeds of up to 180MB/s6 powered by SanDisk® QuickFlow™ Technology8 (64GB - 512GB). Pair with the SanDisk Professional PRO-READER SD and microSD to achieve maximum speeds (sold separately). With shot speeds of up to 130MB/s6 and UHS speed Class 3 (U3)2 recording, you’re ready to capture high-resolution, stutter-free 4K UHD video1.'
),
-- RAM

(DEFAULT ,'AORUS RGB Memory DDR5','Photos/SanDisk/SanDisk-RAM-01.png', 102.66, 20, 5, 4, '32GB', '5600MT/s', 'Black', '4 year', '145 mm x 35 mm. ', 
    'AORUS DDR5 RGB memory adopts a new copper-aluminum composite material heat spreader. Besides, with NanoCarbon coating, enhance passive thermal spreader when under ultra-high performance. The coating material covers the entire heat spreaders. High voltage may cause a memory peak over 70°C and failure.'
),
(DEFAULT ,'Crucial Pro RAM DDR5','Photos/SanDisk/SanDisk-RAM-02.png', 88.65, 320, 5, 4, '32GB', '4800MT/s', 'Black', '4 year', '145 mm x 35 mm ', 
    'Plug-and-play extreme performance. Downclock capable for systems that only support 5200MT/s or 4800MT/s.\nUniversal compatibility. Compatible with 12th–13th Gen Intel Core or AMD Ryzen 7000 Series desktop CPUs.'
),
(DEFAULT ,'Corsair VENGEANCE LPX DDR4 RAM','Photos/SanDisk/SanDisk-RAM-03.png', 67.99, 230, 5, 4, '32GB', '	3200 MHz', 'Black', '4 year', '145 mm x 35 mm', 
    'Hand-sorted memory chips ensure high performance with generous overclocking headroom.\nVENGEANCE LPX is optimized for wide compatibility with the latest Intel and AMD DDR4 motherboards.\nA low-profile height of just 34mm ensures that VENGEANCE LPX even fits in most small-form-factor builds.'
),
(DEFAULT ,'Lexar ARES RGB DDR4','Photos/SanDisk/SanDisk-RAM-04.png', 44.99, 512, 5, 4, '16GB', '3600MT/s ', 'White', '4 year', '145 mm x 35 mm ', 
    'Delivering blazing-fast DDR4 overclocked performance to elevate your gaming experience.\n Full range RGB support – customize your colors and effects with a vibrant RGB light bar.'
),
-- portable
(DEFAULT ,'WD 5TB Elements Portable HDD, External Hard Drive','Photos/SanDisk/SanDisk-Portable-01.png', 119.99, 30, 6, 4, '5TB', ' 5Gbps', 'Black', '4 year', '2.5 Inches ', 
    'Improve PC performance - When your internal hard drive is almost full your PC slows down. Don’t delete files. Free up space on your internal hard drive by transferring files to your WD Elements portable hard drive and get your laptop moving again.Plug-and-play ready for Windows PC'
),
(DEFAULT ,'Seagate Portable 4TB External Hard Drive HDD','Photos/SanDisk/SanDisk-Portable-02.png', 59.99, 629, 6, 4, '4TB', '10Gbps', 'Black', '5 year', '18 Inches', 
    'Easily store and access 4TB of content on the go with the Seagate Portable Drive, a USB external hard drive.Specific uses: Personal.Designed to work with Windows or Mac computers, this external hard drive makes backup a snap just drag and drop.'
),
(DEFAULT ,'Toshiba Canvio Basics 1TB Portable External Hard Drive','Photos/SanDisk/SanDisk-Portable-03.png', 61.899, 90, 6, 4, '4TB', '5Gbps', 'Black', '5 year', '2.5 Inches ', 
    'Sleek profile design with a matte, smudge-resistance finish.Plug & Play - Easy to use with no software to install.Quickly add more storage capacity to your PC and other compatible devices.'
),
(DEFAULT ,'Seagate Portable 5TB External Hard Drive HDD','Photos/SanDisk/SanDisk-Portable-04.png', 109.99, 700, 6, 4, '32GB', '10Gbps', 'Black', '5 year', '18 Inches ', 
    'Easily store and access 5TB of content on the go with the Seagate portable drive, a USB external hard Drive.Designed to work with Windows or Mac computers, this external hard drive makes backup a snap just drag and drop.'
);


INSERT INTO `eproject`.`products` (
  `productID`,
  `productName`,
  `imageLink`,
  `unitPrice`,
  `quantity`,
  `categoryID`,
  `brandID`,
  `memory`,
  `speed`,
  `color`,
  `warranty`,
  `dimension`,
  `description`
)
VALUES
	(DEFAULT,'Transcend USB Flash Drive 32GB','Photos/Transcend/Transcend-USB-32G.jpg',15,200,3,6,'32GB','USB 3.0','Black','3 year','5x2x1 cm','JetFlash 700 supports USB 3.1 Gen 1 standard, making it much easier for you to access your rich content. \n With a combination of speed and great looks, the JetFlash 700 is the perfect entry-level USB 3.1 Gen 1 peripheral for those who demand a stylish aesthetic with leading-edge technology.'),
	(DEFAULT,'Transcend USB Flash Drive 16GB','Photos/Transcend/Transcend-USB-16G.jpg',9.99,100,3,6,'16GB','USB 2.0','Black','3 year','5x2x1 cm','JetFlash 700 supports USB 3.1 Gen 1 standard, making it much easier for you to access your rich content. \nWith a combination of speed and great looks, the JetFlash 700 is the perfect entry-level USB 3.1 Gen 1 peripheral for those who demand a stylish aesthetic with leading-edge technology.'),
	(DEFAULT,'Transcend USB Flash Drive 64GB','Photos/Transcend/Transcend-USB-64G.jpg',24.99,50,3,6,'64GB','USB 3.0','Black','3 years','7x2.5x1 cm','JetFlash 700 supports USB 3.1 Gen 1 standard, making it much easier for you to access your rich content. \nWith a combination of speed and great looks, the JetFlash 700 is the perfect entry-level USB 3.1 Gen 1 peripheral for those who demand a stylish aesthetic with leading-edge technology.'),
	(DEFAULT,'Transcend USB Flash Drive 128GB','Photos/Transcend/Transcend-USB-128G.jpg',39.99,30,3,6,'128GB','USB 3.1 Gen 1','Black','3 years','8x2.5x0.8 cm','JetFlash 700 supports USB 3.1 Gen 1 standard, making it much easier for you to access your rich content. \nWith a combination of speed and great looks, the JetFlash 700 is the perfect entry-level USB 3.1 Gen 1 peripheral for those who demand a stylish aesthetic with leading-edge technology.'),
	(DEFAULT,'Transcend 32GB microSDHC Memory Card','Photos/Transcend/Transcend-Memory Card-32G.jpg',22.99,40,4,6,'32GB','UHS-I U1','Black','3 years','2x1.5x0.1 cm','Combining next-generation Ultra High Speed ​​Class 1 technology with high capacity, Transcend \n  microSDXC UHS-I memory cards not only provide the best possible performance across a wide range of mobile activities, but also have enough space. archive to carry your entire collection of personal files.'),
	(DEFAULT,'Transcend 64GB SDXC Memory Card','Photos/Transcend/Transcend-SDXC-Memory Card-64G.jpg',34.99,25,4,6,'64GB','UHS-I U3','Black','5 years','3x2x0.2 cm','Transcend s SDXC UHS-I Speed ​​Class 3 (U3) card provides the performance and capacity needed to get the most out of your UHS-I compliant camera.\n Incredible read and write capabilities speeds of up to 95 MB/s and 85 MB/s, these cards can easily record high-quality 4K and significantly reduce the time it takes to transfer video to your computer.'),
	(DEFAULT,'Transcend 128GB microSDXC Memory Card','Photos/Transcend/Transcend-SDXC-Memory Card-128G.jpg',49.99,15,4,6,'128GB','UHS-I U3','Black','3 years','2x1.5x0.1 cm','Combining next-generation Ultra High Speed ​​Class 1 technology with high capacity, Transcend \n  microSDXC UHS-I memory cards not only provide the best possible performance across a wide range of mobile activities, but also have enough space. archive to carry your entire collection of personal files.'),
	(DEFAULT,'Transcend 256GB SDXC Memory Card','Photos/Transcend/Transcend-SDXC-Memory Card-256G.jpg',79.99,10,4,6,'256GB','UHS-II U3','Gold','5 years','3x2x0.2 cm','Transcend s SDXC UHS-I Speed ​​Class 3 (U3) card provides the performance and capacity needed to get the most out of your UHS-I compliant camera.\nIncredible read and write capabilities speeds of up to 95 MB/s and 85 MB/s, these cards can easily record high-quality 4K and significantly reduce the time it takes to transfer video to your computer.'),
	(DEFAULT,'Transcend RAM 8GB DDR4','Photos/Transcend/Transcend-RAM-8G.jpg',59.99,30,5,6,'8GB','DDR4','Green','3 years','15x5x1 cm','High-performance DDR4 RAM for improved system speed and stability.'),
	(DEFAULT,'Transcend RAM 16GB DDR4','Photos/Transcend/Transcend-RAM-16G.jpg',109.99,20,5,6,'16GB','DDR4','Green','3 years','15x5x1 cm','High-capacity DDR4 RAM module for enhanced multitasking and gaming.'),
	(DEFAULT,'Transcend RAM 32GB DDR4','Photos/Transcend/Transcend-RAM-32G.jpg',159.99,15,5,6,'32GB','DDR4','Green','3 years','15x5x1 cm','Extreme performance DDR4 RAM for gaming enthusiasts and content creators.'),
	(DEFAULT,' Transcend RAM 4GB DDR4','Photos/Transcend/Transcend-RAM-4G.jpg',24.99,10,5,6,'4GB','DDR4','Green','Lifetime','15x5x1 cm','Ultra-high capacity DDR4 RAM for professional workstations and power users.'),
	(DEFAULT,'Transcend Portable HDD 1TB','Photos/Transcend/Transcend-Portable-HDD-1TB.jpg',79.99,50,6,6,'1TB','USB 3.0','Black','2 years','12x8x2 cm','With the desire to provide enthusiasts with fast transfer speeds, large storage capacity and a unique three-layer shock protection system, the StoreJet 25H3P USB 3.0 portable hard drive is an ideal storage device. Ideal for data backup, archiving and file movement.'),
	(DEFAULT,'Transcend Portable HDD 2TB','Photos/Transcend/Transcend-Portable-HDD-2TB.jpg',109.99,30,6,6,'2TB','USB 3.0','Black','2 years','12x8x2 cm','With the desire to provide enthusiasts with fast transfer speeds, large storage capacity and a unique three-layer shock protection system, the StoreJet 25H3P USB 3.0 portable hard drive is an ideal storage device. Ideal for data backup, archiving and file movement.'),
	(DEFAULT,'Transcend Portable HDD 4TB','Photos/Transcend/Transcend-Portable-HDD-4TB.jpg',159.99,20,6,6,'4TB','USB 3.0',' Purple','3 years','12x8x2 cm','With the desire to provide enthusiasts with fast transfer speeds, large storage capacity and a unique three-layer shock protection system, the StoreJet 25H3P USB 3.0 portable hard drive is an ideal storage device. Ideal for data backup, archiving and file movement.'),
	(DEFAULT,'Transcend Portable HDD 8TB','Photos/Transcend/Transcend-Portable-HDD-8TB.jpg',259.99,10,6,6,'8TB','USB 3.1 Gen 1','Blue','3 years','15x10x3 cm','Ultra-large storage capacity with USB 3.1 Gen 1 interface for high-speed data transfer and reliable backups.'),
	(DEFAULT,'Transcend HDD 500GB','Photos/Transcend/Transcend-HDD-500GB.jpg',59.99,50,1,6,'500GB','7200 RPM','Black','2 years','10x7x2 cm','With fast transfer speeds, massive storage capacity, and three layers of shock protection, the StoreJet 25M3 USB 3.0 portable hard drive is an ideal storage device for daily backups, archives, and file transfers. believe.'),
	(DEFAULT,'Transcend HDD 1TB','Photos/Transcend/Transcend-HDD-1TB.jpg',79.99,40,1,6,'1TB','7200 RPM','Black','2 years','10x7x2 cm','With fast transfer speeds, massive storage capacity, and three layers of shock protection, the StoreJet 25M3 USB 3.0 portable hard drive is an ideal storage device for daily backups, archives, and file transfers. believe.'),
	(DEFAULT,'Transcend HDD 2TB','Photos/Transcend/Transcend-HDD-2TB.jpg',109.99,30,1,6,'2TB','7200 RPM','Black','3 years','10x7x2 cm','Massive 2TB HDD with 7200 RPM for ample storage space and reliable performance.'),
	(DEFAULT,'Transcend HDD 4TB','Photos/Transcend/Transcend-HDD-4TB.jpg',159.99,20,1,6,'4TB','7200 RPM','Black','3 years','10x7x2 cm','Ultra-large 4TB HDD with 7200 RPM for high-capacity and high-speed data storage.'),
	(DEFAULT,'Transcend SSD 240GB','Photos/Transcend/Transcend-SSD-240GB.jpg',69.99,50,2,6,'240GB','SATA III','Black','3 years','7x5x0.7 cm','High-speed 240GB SSD with SATA III interface for improved system performance.'),
	(DEFAULT,'Transcend SSD 500GB','Photos/Transcend/Transcend-SSD-500GB.jpg',99.99,40,2,6,'500GB','SATA III','Black','3 years','7x5x0.7 cm','Large-capacity 500GB SSD with SATA III interface for fast data access and storage.'),
	(DEFAULT,'Transcend SSD 1TB','Photos/Transcend/Transcend-SSD-1TB.jpg',159.99,30,2,6,'1TB','SATA III','Black','5 years','7x5x0.7 cm','Massive 1TB SSD with SATA III interface for ultra-fast data transfer and reliability.'),
	(DEFAULT,'Transcend SSD 2TB','Photos/Transcend/Transcend-SSD-2TB.jpg',259.99,20,2,6,'2TB','NVMe PCIe Gen3 x4','Black','5 years','7x5x0.7 cm','Ultra-large 2TB SSD with NVMe PCIe Gen3 x4 interface for extreme performance and storage capacity.');
	
INSERT INTO `eproject`.`products` (
  `productID`,
  `productName`,
  `imageLink`,
  `unitPrice`,
  `quantity`,
  `categoryID`,
  `brandID`,
  `memory`,
  `speed`,
  `color`,
  `warranty`,
  `dimension`,
  `description`
)
VALUES
	(DEFAULT, 'WD_BLACK SN770M NVMe™ SSD', 'Photos/WD/WD-SSD-01.jpg', 79.99,1000, '2', '2', '500GB', '5000MB/s read, 4000MB/s write', 'Black', '5 years', '1.18" x 0.87" x 0.09"', 'The WD_BLACK SN770M NVMe SSD is a high-performance solid-state drive produced by Western Digital. It leverages NVMe technology for rapid data transfer, providing fast read and write speeds to enhance system responsiveness. With capacities available to suit different storage needs, this SSD is designed for gaming and content creation, offering reliable performance and improved load times.'),
	(DEFAULT, 'WD_BLACK SN850P NVMe™ SSD for PS5® consoles', 'Photos/WD/WD-SSD-02.jpg', 129.99,1000, '2', '2', '1TB', '7300MB/s, 6300MB/s write', 'Black', '5 years', '3.15" x 0.96" x 0.39"', 'The WD_BLACK SN850P NVMe SSD is a high-performance solid-state drive designed specifically for use with PS5 consoles. Developed by Western Digital, it features NVMe technology for ultra-fast data transfer speeds, enhancing gaming experiences with quicker load times and seamless performance.'),
	(DEFAULT, 'WD Blue SN580 NVMe™ SSD', 'Photos/WD/WD-SSD-03.jpg', 27.95,1000, '2', '2', '250GB', '4000MB/s Read and 2000MB/s Write', 'Blue', '5 years', '3.15" x 0.87" x 0.09', 'The WD Blue SN580 NVMe SSD is a solid-state drive by Western Digital, belonging to the NVMe (Non-Volatile Memory Express) storage category. It utilizes NVMe technology for faster data transfer rates compared to traditional SATA SSDs, providing high-speed performance for tasks like booting up, loading applications, and transferring files.'),
	(DEFAULT, 'WD_BLACK SN850X NVMe™ SSD', 'Photos/WD/WD-SSD-04.jpg', 349.99,1000, '2', '2', '4TB', '7300MB/s Read and 6600MB/s Write', 'Black', '5 years', '3.15" x 0.87" x 0.09"', 'The WD_BLACK SN850X NVMe SSD is a high-performance solid-state drive produced by Western Digital. It employs NVMe technology for rapid data transfer, providing exceptional speed and responsiveness for gaming and demanding applications. With capacities ranging from moderate to high, it offers gamers and power users ample storage space for their needs.'),
	(DEFAULT, 'WD Green SN350 NVMe™ SSD', 'Photos/WD/WD-SSD-05.jpg', 28.99,1000, '2', '2', '250GB', '2400MB/s Read and 1500MB/s Write', 'Green', '3 years', '3.16" x 0.87" x 0.09"', 'The WD Green SN350 NVMe SSD is a solid-state drive by Western Digital designed for high-speed data storage. It uses NVMe technology for faster data transfer, providing improved system responsiveness and quicker load times for applications. The WD Green SN350 is available in different capacities and is known for its energy efficiency and reliability.'),
	(DEFAULT, 'WD Red SN700 NVMe SSD', 'Photos/WD/WD-SSD-06.jpg', 309.99,1000, '2', '2', '4TB', '3400MB/s Read and 3100MB/s Write', 'Red', '5 years', '3.15" x 0.87" x 0.09"', 'Tackle extreme workloads in high-intensity NAS environments with the fast-caching WD Red SN700 NVMe™ SSD. The drive’s robust system responsiveness and exceptional I/O performance are perfect for multi-user, multitasking applications, letting you tame your SMB’s toughest projects from virtualization to collaborative editing to intensive database storage with efficient caching —all while helping to lower your TCO.'),
	(DEFAULT, 'WD Red Pro NAS Hard Drive', 'Photos/WD/WD-HDD-07.jpg', 92.99,1000, '1', '2', '64MB', '164MB/s', 'Red', '5 years', '5.79" x 4" x 1.03"', 'The WD Red Pro is a NAS (Network Attached Storage) hard drive designed by Western Digital. It is specifically engineered for use in professional NAS systems, offering reliable and high-performance storage solutions.'),
	(DEFAULT, 'WD Red Plus NAS Hard Drive 3.5-Inch', 'Photos/WD/WD-HDD-08.jpg', 59.99,1000, '1', '2', '256MB', '180MB/s', 'Red', '5 years', '5.787" x 4" x 1.028"', 'The WD Red Plus NAS Hard Drive is a 3.5-inch internal hard drive specifically designed for network-attached storage (NAS) systems. It is optimized for reliability and performance in multi-bay NAS environments, offering capacities suitable for home and small-business use.'),
	(DEFAULT, 'WD Gold Enterprise Class SATA HDD', 'Photos/WD/WD-HDD-09.jpg', 84.99,1000, '1', '2', '128MB', '184MB/s', 'Gold', '5 years', '5.79" x 4" x 1.03"', 'The WD Gold Enterprise Class SATA HDD is a high-performance hard disk drive designed for enterprise-level applications. Manufactured by Western Digital, it features a SATA III interface for reliable and efficient data transfer. With capacities ranging from multiple terabytes, it provides ample storage for critical business data.'),
	(DEFAULT, 'WD Blue PC Desktop Hard Drive', 'Photos/WD/WD-HDD-10.jpg', 34.99,1000, '1', '2', '32MB', '150MB/s', 'Blue', '2 years', '5.79" x 4" x 1.03"', 'The WD Blue PC Desktop Hard Drive is a reliable internal hard drive manufactured by Western Digital. Designed for desktop computers, it offers ample storage capacity for various applications, including storing documents, multimedia files, and software. With a SATA III interface, it provides efficient data transfer rates.'),
	(DEFAULT, 'WD Purple Pro Smart Video Hard Drive', 'Photos/WD/WD-HDD-11.jpg', 599.99,1000, '1', '2', '22TB', '265MB/s', 'Purple', '5 years', '5.79" x 4" x 1.03"', 'The WD Purple Pro Smart Video Hard Drive is designed for surveillance systems, offering high-capacity storage and advanced features. It is equipped with AllFrame AI technology for improved video capture and supports up to 32 HD cameras.'),
	(DEFAULT, 'WD_BLACK 3.5-Inch Gaming Hard Drive', 'Photos/WD/WD-HDD-12.jpg', 46.99,1000, '1', '2', '500GB', '150MB/s', 'Black', '5 years', '5.79" x 4" x 1.03"', 'The WD_BLACK 3.5-Inch Gaming Hard Drive is a high-performance hard drive designed for gaming enthusiasts. Manufactured by Western Digital, it offers ample storage capacity for large game libraries and multimedia files. With a 3.5-inch form factor, it is suitable for desktop systems.'),
	(DEFAULT, 'WD_BLACK D30 Game Drive SSD', 'Photos/WD/WD-SSD-13.jpg', 64.99,1000, '2', '2', '500GB', '900MB/s', 'Black', '3 years', '3.78" x 1.38" x 2.28"', 'The WD_BLACK D30 Game Drive SSD is a high-performance external storage solution designed for gaming. It offers fast data transfer speeds with its NVMe technology, providing quick access to games and reducing loading times. The drive features a compact and durable design, making it portable for gaming on the go.'),
	(DEFAULT, 'WD Elements™ SE SSD', 'Photos/WD/WD-SSD-14.jpg', 99.99,1000,  '2', '2', '2TB', '400MB/s', 'Grey', '5 years', '2.54" x 2.54" x 0.34"', 'The WD Elements SE SSD is a portable solid-state drive manufactured by Western Digital. It offers high-speed data transfer through a USB connection, providing a compact and convenient storage solution.'),

	(DEFAULT, 'WD Blue SATA SSD 2.5”/7mm cased', 'Photos/WD/WD-SSD-15.jpg', 249.99,1000, '2', '2', '4TB', '560MB/s read, 530MB/s write', 'Blue', '5 years', '2.5”/7mm', 'The WD Blue SATA SSD in the 2.5"/7mm form factor is a solid-state drive produced by Western Digital. Designed for compatibility with both desktops and laptops, it features a slim 7mm profile. This SSD connects through a SATA interface, offering fast and reliable data transfer. '),

	(DEFAULT, 'WD_BLACK D50 Game Dock NVMe™ SSD', 'Photos/WD/WD-SSD-16.jpg', 279.99,1000, '2', '2', '1TB', '3000MB/s read, 2500MB/s write', 'Black', '5 years', '4.72" x 4.72" x 2.17"', 'The WD_BLACK D50 Game Dock NVMe SSD is a multifunctional gaming accessory by Western Digital. It serves as both a high-performance NVMe SSD storage solution and a versatile gaming dock.'),

	(DEFAULT, 'WD Gold™ Enterprise Class NVMe™ SSD', 'Photos/WD/WD-SSD-17.jpg', 777.99,1000, '2', '2', '3.84TB', '3000MB/s read, 2500MB/s write', 'Gold', '5 years', '3.95" x 2.75" x 0.3"', 'The WD Gold™ Enterprise Class NVMe™ SSD is a high-performance solid-state drive designed for enterprise-level applications. Manufactured by Western Digital, it utilizes NVMe technology for faster data access and transfer speeds. With a focus on reliability and durability, this SSD is suitable for demanding workloads and critical data storage in enterprise environments.'),

	(DEFAULT, 'WD_BLACK SN750 NVMe™ SSD', 'Photos/WD/WD-SSD-18.jpg', 49.99,1000, '2', '2', '500GB', ' 3430MB/s read, 2600MB/s write', 'Black', '5 years', '3.15" x 0.95" x 0.32"', 'The WD_BLACK SN750 NVMe SSD is a high-performance solid-state drive designed for gaming and content creation. Manufactured by Western Digital, it utilizes NVMe technology for faster data transfer speeds over PCIe Gen3 lanes.'),

	(DEFAULT, 'Western Digital CL SN520 NVMe SSD', 'Photos/WD/WD-SSD-19.jpg', 271.75,1000, '2', '2', '128GB', '1500MB/s read, 800MB/s write', 'White', '5 years', '1.65" x 0.87" x 0.09"', 'The Western Digital CL SN520 NVMe SSD is a compact and high-performance solid-state drive designed for ultra-slim devices, such as ultrabooks and compact laptops. It utilizes NVMe (Non-Volatile Memory Express) technology for faster data transfer speeds compared to traditional SATA SSDs.'),

	(DEFAULT, 'PC SN540 NVMe SSD', 'Photos/WD/WD-SSD-20.jpg', 99.99,1000, '2', '2', '512GB', '3200MB/s read, 1500MB/s write', 'Black', '5 years', '3.15" x 0.87" x 0.09"', 'The PC SN540 NVMe SSD is a solid-state drive manufactured by Western Digital. It utilizes NVMe (Non-Volatile Memory Express) technology for high-speed data transfer and is designed for use in ultrabooks, laptops, and desktop computers.'),

	(DEFAULT, 'easystore Desktop HDD', 'Photos/WD/WD-HDD-21.jpg', 26.76,1000, '1', '2', '8TB', '5Gb/s', 'Black', '2 years', '5.5" x 2" x 6.7"', 'The easystore Desktop HDD is an external hard drive product line, often produced by Western Digital. Designed for easy storage expansion, it provides additional capacity for desktop computers.'),

	(DEFAULT, 'Clearance - WD Purple Surveillance Hard Drive', 'Photos/WD/WD-HDD-22.jpg', 149.99,1000, '1', '2', '6TB', ' 175MB/s', 'Purple', '3 years', '5.79" x 4" x 1.03"', 'The WD Purple Surveillance Hard Drive is designed specifically for video surveillance systems. It features high reliability, low power consumption, and supports continuous, 24/7 operation. With capacities tailored for surveillance needs, it offers efficient storage for video footage.'),
	(DEFAULT, 'WD_BLACK D10 Game Drive', 'Photos/WD/WD-HDD-23.jpg', 189.99,1000, '1', '2', '8TB', '250MB/s', 'Black', '5 years', '7.68" x 4.92" x 1.73"', 'The WD_BLACK D10 Game Drive is an external storage solution designed for gamers. Manufactured by Western Digital, it offers high-capacity storage, typically ranging from 8TB to 12TB. The drive is equipped with fast USB 3.2 Gen 1 connectivity, providing quick data transfer speeds.'),

	(DEFAULT, 'WD_BLACK Performance Mobile Hard Drive', 'Photos/WD/WD-HDD-24.jpg', 62.99,1000, '1', '2', '1TB', '6Gb/s', 'Black', '5 years', '3.94" x 2.75" x 0.28"', 'The WD_BLACK Performance Mobile Hard Drive is a high-performance storage solution designed for gaming laptops and enthusiasts. Manufactured by Western Digital, this mobile hard drive features fast data transfer speeds, large storage capacities, and is optimized for gaming applications.');


INSERT INTO `eproject`.`products` (
  `productID`,
  `productName`,
  `imageLink`,
  `unitPrice`,
  `quantity`,
  `categoryID`,
  `brandID`,
  `memory`,
  `speed`,
  `color`,
  `warranty`,
  `dimension`,
  `description`
)
VALUES	
	(DEFAULT,'Portable SSD Lacie Rugged SSD Pro 1TB','Photos/Seagate/Seagate-Portable-01.png',400,30,6,3,'1TB','USB 3.0','Black','2 years','20x10x5 cm','Built with a Seagate FireCuda NVMe M.2 SSD, LaCie 1TB SSD PRO Thunderbolt 3 external SSD provides filmmakers and DITs with data transfer speeds of up to 2800 MB/s, enough bandwidth to 6K, 8K playback without transcoding. It is also IP67 rated, making it dust and water resistant.'),
	(DEFAULT,'Portable HDD Seagate One Touch 2TB 2.5\"','Photos/Seagate/Seagate-Portable-02.png',99.99,45,6,3,'2TB','USB 3.0','Black','3 years','12x8x2 cm','Seagate One Touch HDD is an effective storage solution with AES-256 encryption, data security with password, exFAT standard compatible with Windows or Mac, helping you schedule automatic backups with Seagate Toolkit software.'),
	(DEFAULT,'Portable HDD Seagate One Touch 2TB 2.5\"','Photos/Seagate/Seagate-Portable-03.png',99.99,45,6,3,'2TB','USB 3.0','Red','3 years','12x8x2 cm','Seagate One Touch HDD has high durability and security, ensuring content is kept safe. Seagate HDDs confidently protect your data with Seagate Toolkit software that continuously backs up and synchronizes data. Secure with password and AES-256 standard hardware encryption.'),
	(DEFAULT,'Portable SSD Seagate Expansion 1TB','Photos/Seagate/Seagate-Portable-04.png',199.99,35,6,3,'2TB','USB 3.0','Black','3 years','14x8x1 cm','Seagate Expansion 1TB SSD is designed with extremely fast speed and extremely compact design, you can easily carry it everywhere without getting in the way. The product is designed with an eye-catching appearance and is easy to use for your laptop – with simple data drag and drop operations.'),
	(DEFAULT,'Seagate Expansion portable 5TB','Photos/Seagate/Seagate-Portable-05.png',239.99,35,6,3,'5TB','USB 3.0','Black','3 years','14x8x1 cm','Highlights:\n- Mobile backup, quick and easy, just drag and drop files in 1 step.\n- Slim and compact design, anti-slip embossed plastic surface.\n- Can be used for both Windows and Mac operating systems without formatting the drive.\n- Fast USB 3.0 connection\nIf you need the simplest storage solution right away, Expansion is the choice to consider.'),
	(DEFAULT,'Seagate Expansion portable 4TB','Photos/Seagate/Seagate-Portable-06.png',139.99,35,6,3,'4TB','USB 3.0','Black','3 years','15x7x2 cm','With a slim and compact design, Seagate Expansion accompanies you on all business and travel trips. Easy to use interface, just plug in and exchange data in just 1 click. With a capacity of up to 4TB, enough to hold 320,000 digital photos, the Seagate Expansion HDD portable hard drive is your perfect choice.'),
	(DEFAULT,'Portable HDD Seagate One Touch 2TB 2.5\"','Photos/Seagate/Seagate-Portable-07.png',109.99,45,6,3,'2TB','USB 3.0','Gray','3 years','12x8x2 cm','Seagate One Touch HDD is an effective storage solution with AES-256 encryption, data security with password, exFAT standard compatible with Windows or Mac, helping you schedule automatic backups with Seagate Toolkit software.'),
	(DEFAULT,'Portable HDD Seagate One Touch 2TB 2.5\"','Photos/Seagate/Seagate-Portable-08.png',109.99,45,6,3,'3TB','USB 3.0','Blue','3 years','12x8x2 cm','Seagate One Touch HDD is an effective storage solution with AES-256 encryption, data security with password, exFAT standard compatible with Windows or Mac, helping you schedule automatic backups with Seagate Toolkit software.'),
	(DEFAULT,'HDD Seagate IronWolf Pro 16Tb','Photos/Seagate/Seagate-HDD-01.png',449.99,50,1,3,'16TB','7200 RPM','Gray','5 years','10x4x1 cm','AgileArray Firmware (The Soul of IronWolf) can retain the agility and sensitivity of what NAS systems need to meet the storage needs of their users. AgileArray allows NAS hard drives to be optimized by focusing on drive balancing, RAID optimization and power management.'),
	(DEFAULT,'Firecuda HDD 4TB 3.5\"','Photos/Seagate/Seagate-HDD-02.png',149.99,50,1,3,'4TB','7200 RPM','Gray','3 years','10x4x1 cm','The 4TB SSHD hard drive is a perfect combination of an HDD and SSD. In addition to the 4TB total capacity of the hard drive, it is also equipped with 32GB of Flash chip memory to help optimize and improve game loading. or applications 5 times faster than conventional drives.'),
	(DEFAULT,' HDD Seagate Enterprise Capacity','Photos/Seagate/Seagate-HDD-03.png',149.99,50,1,3,'1TB','7200 RPM','Gray','3 years','10x4x1 cm','For all things Enterprise Storage, there is Exos E - the most secure and powerful way to take the edge off your data warehouse and unlock its full potential. Always on, the Exos E series of hard drives are loaded with advanced options for optimal performance, reliability, security and user-definable storage management.'),
	(DEFAULT,'HDD PC Seagate 6TB','Photos/Seagate/Seagate-HDD-04.png',169.99,50,1,3,'6TB','5400 RPM','Gray','3 years','10x4x1 cm','Seagate HDDs are equipped with Multi-Tier Caching Technology (MTC) to boost your computers performance, so you can load applications and files faster than ever. By applying Intelligent Layers of NAND Flash, DRAM and MLC Cache memory technology, BarraCuda delivers improved read and write performance by optimizing data flow.'),
	(DEFAULT,'HDD Seagate BarraCuda 2TB','Photos/Seagate/Seagate-HDD-05.png',109.99,50,1,3,'2TB','7200 RPM','Gray','3 years','12x5x1 cm','Seagate BarraCuda is a hard drive line with Seagates highest standards of quality and reliability, it possesses the ideal features and capacity for your computing needs. The Seagate BarraCuda hard drive has extremely durable performance for desktop computers and it has been tested and proven to be fully compatible with the system.'),
	(DEFAULT,'HDD Seagate Skyhawk 4TB','Photos/Seagate/Seagate-HDD-06.png',179.99,50,1,3,'4TB','5400 RPM','Gray','3 years','12x5x1 cm','Using the new and most special hard drive design technology from the Seagate brand, the Seagate Skyhawk 4Tb 5400rpm 256MB SATA3 ST4000VX016 HDD was created with the purpose of serving the needs of monitoring and analysis applications.'),
	(DEFAULT,'HDD Seagate Ironwolf 6TB','Photos/Seagate/Seagate-HDD-07.png',209.99,50,1,3,'6TB','5400 RPM','Gray','3 years','12x5x1 cm','Seagates IronWolf HDD line is a leader in the desktop storage industry. With capacities up to 6TB, the Seagate IronWolf HDD product line is a great choice for upgrading network attached storage (NAS) hard drives.'),
	(DEFAULT,'HDD Seagate 3TB Skyhawk','Photos/Seagate/Seagate-HDD-07.png',179.99,50,1,3,'3TB','5900 RPM','Gray','3 years','12x5x1 cm','Seagate has a whole line of surveillance hard drives called Surveillance (SkyHawk) that is optimized for surveillance camera systems of different sizes. SkyHawk is capable of supporting up to 64 HD cameras, which can minimize drops frames and time drop thanks to ImagePerfect Firmware settings.'),
	(DEFAULT,'BarraCuda SATA SSD 2TB','Photos/Seagate/Seagate-SSD-01.png',109.99,50,2,3,'2TB','6 Gb/s','Black','3 years','17x5x1 cm','Improve PC performance with Seagate’s BarraCuda SSDs offering up to 50× faster speeds than traditional HDDs. Expect optimal compatibility and easy plug-and-play installation.'),
	(DEFAULT,'Barracuda PCIe 2 TB','Photos/Seagate/Seagate-SSD-02.png',139.99,50,2,3,'2TB','6 Gb/s','Black','3 years','17x5x1 cm','Take your data to the next level of performance, reliability, and efficiency with the Seagate® BarraCuda® PCIe SSD. It’s a perfect fit for laptops, mini-PCs, and desktop PCs that need next-level SSD speed for accelerated applications and multitasking.'),
	(DEFAULT,'Barracuda PCIe 2 TB','Photos/Seagate/Seagate-SSD-03.png',139.99,50,2,3,'2TB','6 Gb/s','Black','3 years','17x5x1 cm','Take your data to the next level of performance, reliability, and efficiency with the Seagate® BarraCuda® PCIe SSD. It’s a perfect fit for laptops, mini-PCs, and desktop PCs that need next-level SSD speed for accelerated applications and multitasking.'),
	(DEFAULT,'BarraCuda 520 SSD 4TB','Photos/Seagate/Seagate-SSD-04.png',199.99,50,2,3,'4TB','12 Gb/s','Black','3 years','22x5x0.5 cm','BarraCuda® 520 is the compact PCIe NVMe SSD that elevates your laptop, mini PC, and desktop device performance. Experience quicker access to applications and files—nine times faster than SATA SSDs.');
