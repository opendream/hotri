ALTER TABLE biblio ADD COLUMN has_cover char(1) DEFAULT 'N';
ALTER TABLE member ADD COLUMN is_active char(1) DEFAULT 'Y';
