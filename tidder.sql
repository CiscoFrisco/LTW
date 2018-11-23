CREATE TABLE user (
    user_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    username VARCHAR NOT NULL UNIQUE,
    email VARCHAR NOT NULL UNIQUE,
    password VARCHAR NOT NULL,
    realname VARCHAR,
	bio VARCHAR
);

CREATE TABLE post (
    post_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    post_title VARCHAR NOT NULL, --TAMANHO DE TITULO MÁXIMO?
    post_text VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user
);

--STILL NEEDS COMMENT TO COMMENT
CREATE TABLE comment (
    comment_id INTEGER NOT NULL, --AUTOINCREMENT?
    post_id INTEGER NOT NULL REFERENCES post,
    comment_text VARCHAR NOT NULL,
    user_id INTEGER NOT NULL REFERENCES user,
    PRIMARY KEY(comment_id,post_id)
);

--MAYBE DO VOTE_COMMENT AND VOTE_POST ON SAME TABLE?
CREATE TABLE vote_post(
    post_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    value INTEGER NOT NULL CHECK (value = -1 OR value = 1),
    PRIMARY KEY(post_id,user_id)
);

CREATE TABLE vote_comment(
    comment_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    value INTEGER NOT NULL CHECK (value = -1 OR value = 1),
    PRIMARY KEY(comment_id,user_id)
);