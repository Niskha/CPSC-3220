DROP SCHEMA IF EXISTS SuperStore;
CREATE SCHEMA SuperStore;
USE SuperStore;

CREATE TABLE 'address' (
'address_id' int(11) NOT NULL AUTO_INCREMENT,
'street' varchar(100) DEFAULT NULL,
'city' varchar(100) DEFAULT NULL,
'state' varchar(100) DEFAULT NULL,
'zip' varchar(100) DEFAULT NULL,
PRIMARY KEY ('address_id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'customer' (
'customer_id' int(11) NOT NULL AUTO_INCREMENT,
'first_name' varchar(100) DEFAULT NULL,
'last_name' varchar(100) DEFAULT NULL,
'email' varchar(100) DEFAULT NULL,
'phone' varchar(100) DEFAULT NULL,
'address_id' int(11) DEFAULT NULL,
PRIMARY KEY ('customer_id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'order' (
'order_id' int(11) NOT NULL AUTO_INCREMENT,
'customer_id' int(11) DEFAULT NULL,
'address_id' int(11) DEFAULT NULL,
PRIMARY KEY ('order_id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'product' (
'product_id' int(11) NOT NULL AUTO_INCREMENT,
'product_name' varchar(100) DEFAULT NULL,
'description' varchar(100) DEFAULT NULL,
'weight' varchar(100) DEFAULT NULL,
'base_cost' varchar(100) DEFAULT NULL,
PRIMARY KEY ('product_id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'order_item' (
'order_id' int(11) DEFAULT NULL,
'product_id' int(11) DEFAULT NULL,
'quantity' varchar(100) DEFAULT NULL,
'price' varchar(100) DEFAULT NULL,
KEY 'order_item_order_fk' ('order_id'),
KEY 'order_item_product_fk' ('product_id'),
CONSTRAINT 'order_item_product_fk' FOREIGN KEY ('product_id') REFERENCES 'product'
('product_id') ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT 'order_item_order_fk' FOREIGN KEY ('order_id') REFERENCES 'order'
('order_id') ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'warehouse' (
'warehouse_id' int(11) NOT NULL AUTO_INCREMENT,
'name' varchar(100) DEFAULT NULL,
'address_id' int(11) DEFAULT NULL,
PRIMARY KEY ('warehouse_id')
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE 'product_warehouse' (
'product_id' int(11) DEFAULT NULL,
'warehouse_id' int(11) DEFAULT NULL,
KEY 'product_warehouse_product_fk' ('product_id'),
KEY 'product_warehouse_warehouse_fk' ('warehouse_id'),
CONSTRAINT 'product_warehouse_warehouse_fk' FOREIGN KEY ('warehouse_id') REFERENCES 'warehouse'
('warehouse_id') ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT 'product_warehouse_product_fk' FOREIGN KEY ('product_id') REFERENCES 'product'
('product_id') ON DELETE CASCADE ON UPDATE CASCADE,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

