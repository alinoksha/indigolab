CREATE TABLE users (
    id bigserial PRIMARY KEY ,
    telegram_id bigint NOT NULL UNIQUE,
    first_name varchar(255) NOT NULL,
    last_name varchar(255),
    username varchar(255)
);

CREATE TABLE auth_hashes (
    user_id bigint PRIMARY KEY REFERENCES users ON DELETE CASCADE,
    hash char(32) NOT NULL UNIQUE
);
