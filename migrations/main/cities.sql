create table main.cities
(
    name      char(170)    not null,
    name_from char(180)    not null,
    sort      int unsigned not null,
    city_id   int unsigned not null
        primary key,
    constraint `idx-city_id`
        unique (city_id),
    constraint `idx-name`
        unique (name),
    constraint name
        unique (name),
    constraint name_from
        unique (name_from),
    constraint sort
        unique (sort)
);

