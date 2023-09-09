-- Drop the Posts table if it exists
DROP TABLE IF EXISTS Posts;

-- Drop the Comments table if it exists
DROP TABLE IF EXISTS Comments;

-- Drop the Likes table if it exists (optional)
DROP TABLE IF EXISTS Likes;

-- Create the Posts table
CREATE TABLE Posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    message TEXT NOT NULL,
    date TEXT NOT NULL,
    image_path TEXT
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

-- Create the Likes table (optional)
CREATE TABLE Likes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_id INTEGER NOT NULL,
    author TEXT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES Posts(id)
);

-- Insert sample data
INSERT INTO Posts (title, author, message, date, image_path) VALUES
('First Post', 'John', 'This is my first post.', datetime('now'), '/images/first_post.jpg'),
('Second Post', 'Jane', 'Hello, world!', datetime('now'), '/images/second_post.jpg');

INSERT INTO Comments (post_id, author, message, date, parent_comment_id) VALUES
(1, 'Jane', 'Great post, John!', datetime('now'), NULL),
(1, 'John', 'Thank you, Jane!', datetime('now'), 1),
(2, 'Emily', 'Interesting!', datetime('now'), NULL);

INSERT INTO Likes (post_id, author) VALUES
(1, 'Emily'),
(2, 'John');
