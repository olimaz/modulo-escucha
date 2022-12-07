alter table users
    add username varchar(255);

create unique index users_username_uindex
    on users (username);

alter table users alter column google_id drop not null;

alter table users alter column email drop not null;

