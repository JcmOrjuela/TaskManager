##sintaxis MariaDB
## @autor Juan Camilo Moyano Orjuela

drop table users

create table users(
	id int not null auto_increment,
	name varchar(255),
	password varchar(255),
	email varchar(255),
	create_at datetime,
	update_at datetime,
	primary key(id)
);


create table statuses(
	id int not null auto_increment,
	name varchar(45),
	primary key(id)
);

create table tasks (
	id int not null auto_increment,
	name varchar (100),
	description varchar(1024),
	create_at date,
	update_at date,
	expire_at date,
	id_status int,
	primary key(id),
	foreign key (id_status) references statuses(id)
	 
);

create table user_task(
	id_user int,
	id_task int,
	foreign key(id_user) references users(id),
	foreign key(id_task) references tasks(id)
);


insert into statuses (name) 
values('Activo'),('Procesando'),('Cancelado'),('Con Retraso')

insert into users (name,password,email,create_at,update_at)
values ('ALI AMET CHAUCHAR GIACOMETTO ALMACEN CHAUCHARITO',   'jhsu86839jsnaj' ,'achauchar@gmail.com',NOW(),NOW()),
('JUAN MARQUEZ SAAVEDRA WANDERLEY','jhsu86839jsnaj' ,'impocasabella@hotmail.com',NOW(),NOW()),
('RODRIGO GUARIN NARVAEZ', 'jhsu86839jsnaj' ,'roguja8@hotmail.com',NOW(),NOW()),
('AGUIRRE AlZATE JOHN SCHNEIDER',  'jhsu86839jsnaj' ,'sneyderfz@gmail.com',NOW(),NOW()),
('DIEGO FERNANDO RAMOS PARRA', 'jhsu86839jsnaj' ,'ramosdiego777@hotmail.com',NOW(),NOW()),
('RODRIGO IDELFONSO PARRADO RODRIGUEZ','jhsu86839jsnaj' ,'dparrado@gmail.com',NOW(),NOW()),
('ALEXANDER CUELLAR SANCHEZ',  'jhsu86839jsnaj' ,'casa7dorada@hotmail.com',NOW(),NOW()),
('GUILLERMO MORA USAQUEN', 'jhsu86839jsnaj' ,'relojerinter@hotmail.com',NOW(),NOW())


