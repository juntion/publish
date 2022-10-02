<?php 

class process_information
{
	function update_contact_info($table,$data)
	{
		zen_db_perform($table, $data);
	}
}