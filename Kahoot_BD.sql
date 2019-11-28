create table users(
	user_id int auto_increment primary key,
	user_name varchar(30) NOT NULL, 
	password varchar(512) NOT NULL,
	email varchar(50),
	user_type varchar(10) NOT NULL	
	);


create table kahoot(
	kahoot_id int auto_increment primary key,
	user_id int,
	kahoot_name varchar(30) NOT NULL,
	pin int NOT NULL,
	active BOOLEAN NOT NULL,
	limit_users int NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(user_id)
	);

create table question(
	question_id int auto_increment primary key,
	question_name varchar(30) NOT NULL,
	kahoot_id int,
	time int NOT NULL,
	user_type varchar(10) NOT NULL,
	orden int NOT NULL,
	FOREIGN KEY (kahoot_id) REFERENCES kahoot(kahoot_id)
	);

create table answer(
	answer_id int auto_increment primary key,
	answer_name varchar(30) NOT NULL,
	question_id int,
	orden int NOT NULL,
	correct BOOLEAN NOT NULL,
	FOREIGN KEY (question_id) REFERENCES question(question_id)
	);

create table gamer(
	gamer_id int auto_increment primary key,
	gamer_name varchar(30) NOT NULL,
	kahoot_id int,
	FOREIGN KEY (kahoot_id) REFERENCES kahoot(kahoot_id)
	);

create table ranking(
	ranking_id int auto_increment primary key,
	points int,
	kahoot_id int,
	gamer_id int,
	FOREIGN KEY (kahoot_id) REFERENCES kahoot(kahoot_id),
	FOREIGN KEY (gamer_id) REFERENCES gamer(gamer_id)
	);

create table selected(
	selected_id int auto_increment primary key,
	answer_name varchar(30) NOT NULL,
	answer_id int,
	gamer_id int,
	time int NOT NULL,
	FOREIGN KEY (gamer_id) REFERENCES gamer(gamer_id),
	FOREIGN KEY (answer_id) REFERENCES answer(answer_id)
	);





