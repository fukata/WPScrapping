BEGIN;

CREATE TABLE IF NOT EXISTS sc_tag_view_logs (
	id INTEGER AUTO_INCREMENT,
	tag VARCHAR(255) NOT NULL,
	view_type VARCHAR(16) NOT NULL,
	post_id INTEGER NULL,
	ua VARCHAR(255) NULL,
	referrer VARCHAR(2024) NULL,
	ip VARCHAR(32) NULL,
	uid VARCHAR(64) NULL,
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

DROP INDEX sc_tag_view_logs_logged_at ON sc_tag_view_logs;
DROP INDEX sc_tag_rankings_status_rankinged_at ON sc_tag_rankings;
DROP INDEX sc_tag_rankings_status_score ON sc_tag_rankings;

CREATE INDEX sc_tag_view_logs_logged_at ON sc_tag_view_logs (logged_at);
CREATE INDEX sc_tag_rankings_status_rankinged_at ON sc_tag_rankings (status, rankinged_at);
CREATE INDEX sc_tag_rankings_status_score ON sc_tag_rankings (status, score);

COMMIT;
