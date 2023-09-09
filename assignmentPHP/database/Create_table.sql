-- Drop the existing tables
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Likes;

-- Create the Posts table
CREATE TABLE Posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    message TEXT NOT NULL,
    date TEXT NOT NULL,
    like_count INTEGER DEFAULT 0  -- New column for like count
);

-- Create the Comments table
CREATE TABLE Comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    author TEXT NOT NULL,
    message TEXT NOT NULL,
    date TEXT NOT NULL,
    parent_comment_id INTEGER,
    FOREIGN KEY (post_id) REFERENCES Posts(id)
);

-- Create the Likes table
CREATE TABLE Likes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    author TEXT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES Posts(id)
);

-- Insert sample data into Posts with initial like counts
INSERT INTO Posts (title, author, message, date, like_count) VALUES
('First Post', 'John', 'This is my first post.', datetime('now'), 3),
('Second Post', 'Jane', 'Hello, world!', datetime('now'), 5);


-- Insert sample data into Comments
INSERT INTO Comments (post_id, author, message, date, parent_comment_id) VALUES
(1, 'Jane', 'Great post, John!', datetime('now'), NULL),
(1, 'John', 'Thank you, Jane!', datetime('now'), 1),
(2, 'Emily', 'Interesting!', datetime('now'), NULL);

-- Insert sample data into Likes
INSERT INTO Likes (post_id, author) VALUES
(1, 'Emily'),
(2, 'John');
