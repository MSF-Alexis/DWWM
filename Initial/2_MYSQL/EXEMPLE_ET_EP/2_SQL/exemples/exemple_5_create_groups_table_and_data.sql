DROP table IF EXISTS groups;
CREATE TABLE groups (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    NAME VARCHAR(127) NOT NULL,
    description VARCHAR(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO groups (name, description) VALUES
    ('Amoureux des oiseaux', "Ici grand fan d'oiseaux"),
    ("Les foufous du volants", "Ici on adore le vélo"),
    ("Les foufooteux", "Pro du handball"),
    ("MCF", "Mega chuper fien");
