-- Create the tables
CREATE TABLE sk_notes (
  noteID        INT(11)        NOT NULL AUTO_INCREMENT,
  title         VARCHAR(255)   NOT NULL,
  content       TEXT           NOT NULL,
  tags          VARCHAR(255),
  created_at    TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (noteID)
);

-- Insert data into the database
INSERT INTO sk_notes (title, content, tags) VALUES
('Note 1', 'This is the content of note 1.', 'tag1, tag2'),
('Note 2', 'This is the content of note 2.', 'tag2, tag3'),
('Note 3', 'This is the content of note 3.', 'tag1'),
('Note 4', 'This is the content of note 4.', 'tag3, tag4');
