TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER Add_comment\nAFTER INSERT ON comment\nFOR EACH ROW\nUPDATE Recipe\nSET ncomments = ncomments + 1\nWHERE id = NEW.recipe' 'CREATE DEFINER=`root`@`localhost` TRIGGER Remove_comment\nAFTER DELETE ON comment\nFOR EACH ROW\nUPDATE Recipe\nSET ncomments = ncomments - 1\nWHERE id = OLD.recipe'
sql_modes=1098907648 1098907648
definers='root@localhost' 'root@localhost'
client_cs_names='cp850' 'cp850'
connection_cl_names='cp850_general_ci' 'cp850_general_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
created=165366657511 165366657602
