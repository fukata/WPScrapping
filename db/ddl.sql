BEGIN;

CREATE TABLE IF NOT EXISTS sc_tag_view_logs (
	id INTEGER AUTO_INCREMENT,
	tag VARCHAR(255) NOT NULL,
	view_type VARCHAR(16) NOT NULL,
	post_id INTEGER NULL,
	logged_at DATETIME NOT NULL,
	PRIMARY KEY(id)
) DEFAULT CHARACTER SET UTF8;

CREATE TABLE IF NOT EXISTS sc_tag_rankings (
	rank INT NOT NULL,
	tag VARCHAR(255) NOT NULL,
	score INT NOT NULL,
	status VARCHAR(16) NOT NULL,
	rankinged_at DATETIME NOT NULL,
	updated_at DATETIME NOT NULL
) DEFAULT CHARACTER SET UTF8;

CREATE INDEX sc_tag_view_logs_logged_at ON sc_tag_view_logs (logged_at);
CREATE INDEX sc_tag_rankings_status_rankinged_at ON sc_tag_rankings (status, rankinged_at);
CREATE INDEX sc_tag_rankings_status_score ON sc_tag_rankings (status, score);

COMMIT;