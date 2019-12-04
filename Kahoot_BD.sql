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
	orden int NOT NULL,
	question_points int NOT NULL,
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

INSERT INTO users (user_name,password,email,user_type) VALUES ('Joel',sha2('P@ssw0rd',512),'joel@gmail.com','admin');
INSERT INTO users (user_name,password,email,user_type) VALUES ('Didac',sha2('123JAJA',512),'didac@gmail.com','gamer');
INSERT INTO users (user_name,password,email,user_type) VALUES ('Marc',sha2('Tostadora',512),'marc@gmail.com','gamer');


INSERT INTO `kahoot` (`kahoot_id`, `user_id`, `kahoot_name`, `pin`, `active`, `limit_users`) VALUES (NULL, '1', 'Deportes', '43564', '0', '20');

INSERT INTO `kahoot` (`kahoot_id`, `user_id`, `kahoot_name`, `pin`, `active`, `limit_users`) VALUES (NULL, '1', 'Wordpress', '24223', '0', '20');

INSERT INTO `kahoot` (`kahoot_id`, `user_id`, `kahoot_name`, `pin`, `active`, `limit_users`) VALUES (NULL, '2', 'Wordpress', '12345', '0', '20');

INSERT INTO `kahoot` (`kahoot_id`, `user_id`, `kahoot_name`, `pin`, `active`, `limit_users`) VALUES (NULL, '2', 'Sport', '98989', '0', '20');
