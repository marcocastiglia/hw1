TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER Add_Recipe\nAFTER INSERT ON Recipe\nFOR EACH ROW\nUPDATE Users\nSET nrec_written = nrec_written + 1\nWHERE username = NEW.username' 'CREATE DEFINER=`root`@`localhost` TRIGGER Delete_Recipe\nAFTER DELETE ON Recipe\nFOR EACH ROW\nUPDATE Users\nSET nrec_written = nrec_written - 1\nWHERE username = OLD.username'
sql_modes=1098907648 1098907648
definers='root@localhost' 'root@localhost'
client_cs_names='cp850' 'cp850'
connection_cl_names='cp850_general_ci' 'cp850_general_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
created=165356824515 165356824621
