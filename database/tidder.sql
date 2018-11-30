CREATE TABLE user (
    user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL UNIQUE,
    email VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    realname VARCHAR,
    birthday DATE,
    join_date DATE,
	bio VARCHAR
);

CREATE TABLE story (
    story_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    story_title VARCHAR NOT NULL, --TAMANHO DE TITULO MÁXIMO?
    story_text VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user
);

--STILL NEEDS COMMENT TO COMMENT
CREATE TABLE comment (
    comment_id INTEGER NOT NULL, --AUTOINCREMENT?
    story_id INTEGER NOT NULL REFERENCES story,
    comment_text VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user,
    PRIMARY KEY(comment_id,story_id)
);

--MAYBE DO VOTE_COMMENT AND VOTE_STORY ON SAME TABLE?
CREATE TABLE vote_story(
    story_id INTEGER NOT NULL REFERENCES story,
    user_id INTEGER NOT NULL REFERENCES user,
    value INTEGER NOT NULL CHECK (value = -1 OR value = 1),
    PRIMARY KEY(story_id,user_id)
);

CREATE TABLE vote_comment(
    comment_id INTEGER NOT NULL REFERENCES comment,
    user_id INTEGER NOT NULL REFERENCES user,
    value INTEGER NOT NULL CHECK (value = -1 OR value = 1),
    PRIMARY KEY(comment_id,user_id)
);