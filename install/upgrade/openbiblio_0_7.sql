ALTER TABLE biblio CHANGE cover has_cover char(1) DEFAULT 'N';
ALTER TABLE member ADD COLUMN is_active char(1) DEFAULT 'Y';
