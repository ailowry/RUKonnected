DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Likes;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Notifications;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS FriendRequests;
DROP TABLE IF EXISTS Friends;
DROP TABLE IF EXISTS Messages;
CREATE TABLE Users
(
	UserID 			INT,
	Username 		VARCHAR(250),
	Email 			VARCHAR(250),
	Fname 			VARCHAR(100),
	Lname 			VARCHAR(100),
	DOB 				DATETIME,
	LastActive	DATETIME,
	Image				VARCHAR(150),
	PRIMARY KEY (UserID),
	UNIQUE KEY (UserID)
);
CREATE TABLE Posts
(
	PostID 				INT,
	UserID				INT,
	PostContent		VARCHAR(3000),
	FriendUserID	INT,
	Time					DATETIME,
	PRIMARY KEY (PostID),
	FOREIGN KEY (FriendUserID)
		REFERENCES  Users (UserID)
);
CREATE TABLE Likes
(
	PostID 			INT,
	UserID 			INT,
	Time 				DATETIME,
	PRIMARY KEY(PostID, UserID),
	FOREIGN KEY (PostID)
		REFERENCES Posts (PostID),
	FOREIGN KEY (UserID)
		REFERENCES Users (UserID)
);
CREATE TABLE Comments
(
	CommentID		INT,
	PostID			INT,
	UserID			INT,
	Time				DATETIME,
	Comment			VARCHAR(3000),
	PRIMARY KEY (CommentID),
	FOREIGN KEY (UserID)
		REFERENCES  Users (UserID),
	FOREIGN KEY (PostID)
		REFERENCES Posts (PostID)
);
CREATE TABLE Notifications
(
	UserID			INT,
	Content			VARCHAR(200),
	Time				DATETIME,
	PRIMARY KEY (UserID, Content),
	FOREIGN KEY (UserID)
		REFERENCES  Users (UserID)
);
CREATE TABLE FriendRequests
(
	UserID 			MEDIUMINT,
	FriendID		MEDIUMINT,
	Time				DATETIME,
	PRIMARY KEY (UserID, FriendID),
	FOREIGN KEY (UserID)
		REFERENCES  Users (UserID),
	FOREIGN KEY (FriendID)
		REFERENCES Users (UserID)
);
CREATE TABLE Friends
(
	UserID			MEDIUMINT,
	FriendID		MEDIUMINT,
	Time				DATETIME,
	PRIMARY KEY (UserID, FriendID),
	FOREIGN KEY (UserID)
		REFERENCES  Users (UserID),
	FOREIGN KEY (FriendID)
		REFERENCES Users (UserID)
);
CREATE TABLE Messages
(
	MessageID		MEDIUMINT,
	SenderID		MEDIUMINT,
	ReceiverID		MEDIUMINT,
	Content			VARCHAR(3000),
	Time				DATETIME,
	PRIMARY KEY (MessageID),
	FOREIGN KEY (SenderID)
		REFERENCES  Users (UserID),
	FOREIGN KEY (ReceiverID)
		REFERENCES  Users (UserID)
);
commit;
