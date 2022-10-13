<?php

    function showTable($table)
    {
        return "SELECT * FROM $table";
    }
	function deleteRow($table, $col, $id)
	{
		return "DELETE FROM $table WHERE $col = $id";
	}
