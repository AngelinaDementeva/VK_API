ALTER TABLE events ADD COLUMN user_id integer;
ALTER TABLE events ADD COLUMN user_ip inet;
ALTER TABLE events ADD COLUMN authenticated boolean;
