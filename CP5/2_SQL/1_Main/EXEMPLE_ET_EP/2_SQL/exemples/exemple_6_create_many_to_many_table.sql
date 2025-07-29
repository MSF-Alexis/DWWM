DROP table IF EXISTS group_user;
CREATE TABLE group_user (
    group_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_id_group_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_groups_id_group_user FOREIGN KEY (group_id) REFERENCES groups(id),
    CONSTRAINT uq_group_id_user_id_group_user UNIQUE(group_id, user_id)
);
