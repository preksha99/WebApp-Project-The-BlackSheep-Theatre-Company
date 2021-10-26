create table shows
( showid int unsigned not null auto_increment primary key,
  name char(50) not null,
  status char(30) not null,
  images char(30) not null
);

create table bookings
( bookingid int unsigned not null auto_increment primary key,
  customerid int unsigned not null,
  showid int unsigned not null,
  scheduleid int unsigned not null,
  quantity_area1 int unsigned not null,
  quantity_area2 int unsigned not null,
  quantity_area3 int unsigned not null,
  quantity_area4 int unsigned not null,
  booking_date date not null
);

create table customers
( customerid int unsigned not null auto_increment primary key,
  name char(50) not null,
  phone char(30) not null,
  email char(100) not null,
  password char(130) not null
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
