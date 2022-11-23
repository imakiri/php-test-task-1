create user test encrypted password '88946731q89';

create schema test authorization test;

create table test.cities
(
    city_id   int4         not null,
    "name"    varchar(170) not null,
    name_from varchar(170) not null,
    sort      int4         not null,
    constraint cities_cities_id primary key (city_id),
    constraint cities_sort_un unique (sort),
    constraint cities_name_un unique ("name"),
    constraint cities_name_from_un unique (name_from)
);
create unique index cities_city_id_idx on test.cities using btree (city_id);
create unique index cities_name_idx on test.cities using btree ("name");

create type "To" as enum ('в', 'на', 'во');
create table test.countries
(
    country_id int4         not null,
    "name"     varchar(100) not null,
    name_to    varchar(100) not null,
    "to"       "To"         not null,
    sort       int4         not null,
    constraint countries_country_id primary key (country_id),
    constraint countries_sort_un unique (sort),
    constraint countries_name_un unique ("name"),
    constraint countries_name_to_un unique (name_to)
);
create unique index countries_city_id_idx on test.countries using btree (country_id);
create unique index countries_name_idx on test.countries using btree ("name");

create type Cur as enum ('&nbsp;тг.');
create table test.directions
(
    city_id     int4        not null,
    country_id  int4        not null,
    price       int4        not null,
    cur         Cur         not null,
    days        int[]       not null,
    defaultDate varchar(50) not null,
    constraint directions_un unique (city_id, country_id),
    constraint directions_fk_city_id foreign key (city_id) references test.cities on update cascade on delete cascade,
    constraint directions_fk_county_id foreign key (country_id) references test.countries on update cascade on delete cascade
);
create index directions_country_id_idx on test.directions using btree (country_id);
create index directions_city_id_idx on test.directions using btree (city_id);