CREATE TABLE movimientos (
    id int(11) NOT NULL AUTO_INCREMENT,
    codigo  varchar(50) DEFAULT NULL, 
    articulo varchar(250) DEFAULT NULL,
    partNumber varchar(150) DEFAULT NULL ,
    marca varchar(100) DEFAULT NULL ,
    condicion varchar(50) DEFAULT NULL, 
    cantidad int(11) DEFAULT NULL,
    imagen varchar(150) DEFAULT NULL, 
    extra1 varchar(100) DEFAULT NULL, 
    extra2 varchar(100) DEFAULT NULL, 
    extra3 varchar(100) DEFAULT NULL, 
    estado int(2) DEFAULT 1,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    user_c int(2) DEFAULT 1,
    user_m int(2) DEFAULT 1,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE stock (
    id int(11) NOT NULL AUTO_INCREMENT,
    codigo  varchar(50) DEFAULT NULL, 
    articulo varchar(250) DEFAULT NULL,
    partNumber varchar(150) DEFAULT NULL ,
    marca varchar(100) DEFAULT NULL ,
    condicion varchar(50) DEFAULT NULL, 
    stock int(11) DEFAULT NULL,
    estado int(2) DEFAULT 1,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    user_c int(2) DEFAULT 1,
    user_m int(2) DEFAULT 1,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `inventarios`.`permisos` (`nombre`, `tipo`) VALUES ('Kardex', '23');
INSERT INTO `inventarios`.`permisos` (`nombre`, `tipo`) VALUES ('Movimientos', '24');
INSERT INTO `inventarios`.`permisos` (`nombre`, `tipo`) VALUES ('Stock', '25');

ALTER TABLE movimientos ADD medida varchar(50) DEFAULT NULL ;
ALTER TABLE movimientos ADD serie varchar(50) DEFAULT NULL ;
ALTER TABLE movimientos ADD familia varchar(50) DEFAULT NULL ;

ALTER TABLE stock ADD medida varchar(50) DEFAULT NULL ;
ALTER TABLE stock ADD serie varchar(50) DEFAULT NULL ;
ALTER TABLE stock ADD familia varchar(50) DEFAULT NULL ;


CREATE TABLE dtable (
    id int(11) NOT NULL AUTO_INCREMENT,
    C_CODTAB  varchar(50) DEFAULT NULL, 
    C_NUMITM varchar(50) DEFAULT NULL,
    C_DESITM varchar(150) DEFAULT NULL,
    C_ABRITM varchar(50) DEFAULT NULL,
    C_TIPITM varchar(50) DEFAULT NULL, 
    N_VALITM varchar(50) DEFAULT NULL,
    C_ESTADO varchar(50) DEFAULT NULL,
    C_CAMITM varchar(50) DEFAULT NULL,
    PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;