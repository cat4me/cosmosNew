WITH RECURSIVE descendants AS
                   (
                       SELECT id
                       FROM objects
                       WHERE id = ?
                       UNION ALL
                       SELECT t.id
                       FROM descendants d, objects t
                       WHERE t.parent_id=d.id
                   )
SELECT * FROM descendants;