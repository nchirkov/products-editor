CREATE TABLE products ( 
    id int(10) unsigned NOT NULL AUTO_INCREMENT,
    title varchar(45) NOT NULL,
    description text NOT NULL,
    price decimal(10,2) NOT NULL,
    image_url varchar(2048) NOT NULL,
    PRIMARY KEY (id),  KEY price_id_idx (price,id)
);