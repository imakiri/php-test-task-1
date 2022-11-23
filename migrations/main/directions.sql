create table main.directions
(
    city_id      int unsigned not null,
    country_id   int unsigned not null,
    price        int          not null,
    cur          char(50)     not null,
    days         char(100)    not null,
    default_date char(100)    not null,
    primary key (city_id, country_id),
    constraint `fk-city_id`
        foreign key (city_id) references main.cities (city_id)
            on update cascade on delete cascade,
    constraint `fk-country_id`
        foreign key (country_id) references main.countries (country_id)
            on update cascade on delete cascade
);

create index `idx-city_id`
    on main.directions (city_id);

create index `idx-country_id`
    on main.directions (country_id);

