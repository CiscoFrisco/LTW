CREATE TABLE user (
    user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL UNIQUE,
    email VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    realname VARCHAR,
    birthday DATE,
    join_date DATE NOT NULL,
	bio VARCHAR
);

--Opinion can be a story or a comment
--If parent_id = NULL it is a story
--Otherwise it is a comment
CREATE TABLE opinion (
    opinion_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	parent_id INTEGER REFERENCES opinion(opinion_id),
    opinion_title VARCHAR,
    opinion_text VARCHAR NOT NULL,
	channel_id INTEGER REFERENCES channel,
	posted DATETIME NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user
);

CREATE TABLE vote(
    opinion_id INTEGER NOT NULL REFERENCES opinion,
    user_id INTEGER NOT NULL REFERENCES user,
    value INTEGER NOT NULL CHECK (value = -1 OR value = 1),
    PRIMARY KEY(opinion_id,user_id)
);

CREATE TABLE channel(
	channel_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	channel_name VARCHAR NOT NULL UNIQUE
);

CREATE TABLE subscription(
	user_id INTEGER REFERENCES user,
	channel_id INTEGER REFERENCES channel,
	PRIMARY KEY(user_id, channel_id)
);