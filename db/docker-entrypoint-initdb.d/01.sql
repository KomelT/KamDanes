CREATE TABLE user (
  'id' int(11) PRIMARY KEY,
  'username' varchar(255) DEFAULT NULL,
  'password' varchar(255) DEFAULT NULL,
  'email' varchar(255) DEFAULT NULL,
  'name' varchar(255) DEFAULT NULL,
  'phone' varchar(255) DEFAULT NULL,
  'role' int(11) DEFAULT NULL,
  'disabled' boolean DEFAULT TRUE
);

CREATE TABLE event (
  'id' int(11) PRIMARY KEY,
  'id_user' int(11) DEFAULT NULL,
  'name' varchar(255) DEFAULT NULL,
  'organisation' varchar(255) DEFAULT NULL,
  'artist_name' varchar(255) DEFAULT NULL,
  'date_from' date DEFAULT NULL,
  'date_to' date DEFAULT NULL,
  'loc_x' double DEFAULT NULL,
  'loc_y' double DEFAULT NULL,
  'time' time DEFAULT NULL,
  'age_lim' int(11) DEFAULT NULL,
  'description' text DEFAULT NULL,
  'price' decimal(10,0) DEFAULT NULL,
  'type' int(11) DEFAULT NULL,
  'link' text DEFAULT NULL,
  'online' tinyint(1) DEFAULT NULL
);

ALTER TABLE 'event'
  ADD CONSTRAINT 'event_ibfk_1' FOREIGN KEY ('id_user') REFERENCES 'user' ('id') ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;
