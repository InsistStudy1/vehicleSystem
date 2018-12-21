create database CarsInfo charset=utf8;
use CarsInfo;

create table if not exists users(
  uname varchar(20) primary key not null,
  upswd varchar(64) not null
)charset=utf8;

create table if not exists clxx(
  Cid varchar(7) primary key,
  Fid varchar(20),
  Chj varchar(20),
  Chrq datetime,
  Zzh char(8),
  zw char(8)
)charset=utf8;

create table if not exists sjxx(
  Sid varchar(7) PRIMARY KEY,
  Cid varchar(7),
  Sname varchar(20),
  Sex varchar(8),
  Sfid char(10),
  Phone char(10),
  Saddress varchar(20)
)charset=utf8;

create table if not exists wxxx(
  	Wid  varchar(7)  primary key,
	  Cid  varchar(7) ,
	  Nr   varchar(30) ,
    Fy  varchar(8) ,
	  Wrq  datetime ,
	  Waddress  varchar(20)
)charset=utf8;

create table if not exists sgxx(
	Gid  varchar(7)  primary key,
	Cid  varchar(7) NOT NULL,
	Sid  varchar(7)  NOT NULL,
	Grq  datetime ,
	Gaddress  varchar(20) ,
	Yy      varchar(40) ,
	Je  char(8)
)charset=utf8;

create table if not exists session(
  sess_id varchar(50) not null primary key,
  sess_content varchar(70) not null,
  LastTime int default 0 not null
)charset=utf8;

insert into users(uname,upswd) values('Admin',md5('worldhello')),('SteffenKong','helloworld');