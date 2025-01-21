CREATE table IF NOT EXISTS title (
    id serial PRIMARY KEY,
    name VARCHAR ( 50 ) NOT NULL
);

INSERT INTO title (name) VALUES ('FullStack developer'), ('Frontend developer'), ('Backend developer');
