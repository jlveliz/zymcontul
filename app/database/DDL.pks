CREATE TABLE IF NOT EXISTS person (

    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birth_date date NOT NULL

)


CREATE TABLE IF NOT EXISTS contact (

    id INT PRIMARY KEY AUTO_INCREMENT,
    person_id int NOT NULL,
    type_contact VARCHAR(255) NOT NULL,
    contact_value VARCHAR(255) NOT NULL
  
)