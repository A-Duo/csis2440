CREATE DATABASE catalogDB;
USE catalogDB;

CREATE TABLE user (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    password VARCHAR(512)
);

CREATE TABLE product (
    id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    description VARCHAR(500),
    image VARCHAR(100),
    price FLOAT
);

INSERT INTO product (name, image, price, description) VALUES
    ("Anvil", "1.jpg", 249.99,
    "Commonly mistaken as a blacksmithing implement, this product is the perfect weapon for crushing in cartoon conflicts."),
    ("Axle Grease", "2.jpg", 14.99,
    "The ideal lubricant. Formulated to leave your target fumbling and out of control. Best paired with pitfalls and cliffs."),
    ("Atom Re-Arranger", "3.jpg", 199999.99,
    "High tech and devestating. Can instantly \"re-arrange\" any matter in front of the device on pulling the trigger."),
    ("Bed Springs", "4.jpg", 29.99,
    "Extra height on demand! Powerful steel springs to put a little extra pep in your step when you need it. Because the moon boots recall taught us nothing."),
    ("Bird Seed", "5.jpg", 4.99,
    "Avian delicacy. ACME Co. does not condone the use of our product in hazardous environments. Do not use near cliffs covered with ACME Co. axle grease available now for only $14.99."),
    ("Blasting Powder", "6.jpg", 149.99,
    "15kg of raw black powder. Ergonomic and human carry case for discrete moving."),
    ("Cork", "7.jpg", 2.99,
    "Ordinary household cork. Ignore the image, our intern claimed they could do the job cheaper than our photographer. They were right, but the quality speaks for itself."),
    ("Disintegration Pistol", "8.jpg", 1999.99,
    'Atom "re-arrangement on a budget. Our best efforts at reproducing the original Atom Re-Arranger'),
    ("Earthquake Pills", "9.jpg", 119.99,
    "Why wait? Make your own Earthquakes-loads of fun!"),
    ("Female Roadrunner Costume", "10.jpg", 49.99,
    "Guaranteed to turn coyote heads. ACME Co. does not take any resonsibility for damages and or losses suffered by wearing this costume."),
    ("Giant Rubber Band", "11.jpg", 39.99,
    "Quality assurance guaranteed up to 10k cycles supporting 20 tons."),
    ("Instant Girl", "12.jpg", 69.99,
    "This description has been redacted by HR until further notice while R&D undergoes an ethics review."),
    ("Iron Carrot", "13.jpg", 14.99,
    "Because the best pranks either have teeth or leave your friends without them."),
    ("Jet Propelled Unicycle", "14.jpg", 79.99,
    "Top speed of 175km/h. ACME's first patent pending external combustion engine device."),
    ("Out-Board Motor", "15.jpg", 349.99,
    "Our largest motor yet! May not be legal in your state."),
    ("Railroad Track", "16.jpg", 8.46,
    "Industry standard track made with 1084 steel. Price is charged per 5 miles, installation not included in cost."),
    ("Rocket Sled", "17.jpg", 449.99,
    "Flight training device. Comes in coyote and penguin compatible variants."),
    ("Super Outfit", "18.jpg", 29.99,
    "Makes you feel invincible. Comes in strictly in XXXXL size."),
    ("Time Space Gun", "19.jpg", 2499.99,
    "Able to warp reality. Our R&D department has strictly advised not to ever use this product."),
    ("X-Ray", "20.jpg", 1499.99,
    "Real time X-Ray display. May not be compliant with local radiation dose limits.");