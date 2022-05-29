TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER Add_like\nAFTER INSERT ON likeRecipe\nFOR EACH ROW\nUPDATE Recipe\nSET nlikes = nlikes + 1\nWHERE id = NEW.recipe' 'CREATE DEFINER=`root`@`localhost` TRIGGER Remove_like\nAFTER DELETE ON likeRecipe\nFOR EACH ROW\nUPDATE Recipe\nSET nlikes = nlikes - 1\nWHERE id = OLD.recipe'
sql_modes=1098907648 1098907648
definers='root@localhost' 'root@localhost'
client_cs_names='cp850' 'cp850'
connection_cl_names='cp850_general_ci' 'cp850_general_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
created=165356848171 165356848281
