-- Drop the existing tables one by one
DROP TABLE IF EXISTS Likes;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Users;

-- Create the Users table
CREATE TABLE Users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL,
    UNIQUE(username)
);

-- Create the Posts table
CREATE TABLE Posts (
    post_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    date TEXT NOT NULL,
    like_count INTEGER DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Create the Comments table
CREATE TABLE Comments (
    comment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    date TEXT NOT NULL,
    parent_comment_id INTEGER,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Create the Likes table
CREATE TABLE Likes (
    like_id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    FOREIGN KEY (post_id) REFERENCES Posts(post_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    UNIQUE(post_id, user_id)
);

-- Insert sample data into Users
INSERT INTO Users (username) VALUES
('User1'),
('User2'),
('User3'),
('User4'),
('Admin');

-- Insert sample data into Posts
INSERT INTO Posts (title, user_id, message, date, like_count) VALUES
('First Post', 1, 'This is my first post.', '2023-09-10', 0),
('Second Post', 2, 'Hello, world!', '2023-09-10', 0);

-- Insert sample data into Comments
INSERT INTO Comments (post_id, user_id, message, date) VALUES
(1, 2, 'Great post, User1!', '2023-09-10'),
(1, 1, 'Thank you, User2!', '2023-09-10'),
(2, 3, 'Interesting!', '2023-09-10');
