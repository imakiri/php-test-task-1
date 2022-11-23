create table main.countries
(
    name       char(100)    not null,
    name_to    char(100)    not null,
    `to`       char(10)     not null,
    sort       int          not null,
    country_id int unsigned not null
        primary key,
    constraint `idx-country_id`
        unique (country_id),
    constraint `idx-name`
        unique (name),
    constraint name
        unique (name),
    constraint name_to
        unique (name_to),
    constraint sort
        unique (sort)
);

