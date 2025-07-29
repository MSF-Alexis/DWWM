CREATE TABLE posts (
	id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER NOT NULL,
	content VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT fk_users_id_post FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE group_user (
    group_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_id_group_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_groups_id_group_user FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    CONSTRAINT uq_group_id_user_id_group_user UNIQUE(group_id, user_id)
);

-- Maintenant seul un delete suffit
DELETE FROM users WHERE id = 4;