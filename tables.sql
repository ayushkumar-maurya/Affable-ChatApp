-- Users Table
CREATE TABLE `users` (
	userid int AUTO_INCREMENT,
	username varchar(100),
	password varchar(255),
	PRIMARY KEY (userid)
);

-- Messages Table
CREATE TABLE messages (
	msgid int AUTO_INCREMENT,
	senderid int,
	recieverid int,
	message text,
	isFile int(1),
	date_time datetime,
	PRIMARY KEY (msgid),
	FOREIGN KEY (senderid) REFERENCES users(userid),
	FOREIGN KEY (recieverid) REFERENCES users(userid)
);

-- Attachments Table
CREATE TABLE attachments (
	fileid int AUTO_INCREMENT,    
	msgid int,
	filename text,
	tempname text,
	PRIMARY KEY (fileid),
	FOREIGN KEY (msgid) REFERENCES messages(msgid)
);

-- Chats count Table
CREATE TABLE chats_count (
	chatid int AUTO_INCREMENT,
	user1id int,
	user2id int,
	msgCount int,
	user1ClrCount int,
	user2ClrCount int,
	PRIMARY KEY (chatid),
	FOREIGN KEY (user1id) REFERENCES messages(senderid),
	FOREIGN KEY (user2id) REFERENCES messages(recieverid)
);



-- Inserting Users manually
INSERT INTO users (username, password) VALUES ('User Abc', '123');
INSERT INTO users (username, password) VALUES ('User Pqrs', '1234');
INSERT INTO users (username, password) VALUES ('User Xyz', '0000');
