create table customers
( customerid int unsigned not null auto_increment primary key,
  name char(50) not null,
  phone char(30) not null,
  email char(100) not null
);

create table shows
( showid int unsigned not null auto_increment primary key,
  name char(50) not null,
  status char(30) not null
);

create table schedule
(  scheduleid int unsigned not null auto_increment primary key,
   showid int unsigned not null,
   datetime datetime not null,
   quantity_area1 int unsigned not null,
   quantity_area2 int unsigned not null,
   quantity_area3 int unsigned not null,
   quantity_area4 int unsigned not null
);
