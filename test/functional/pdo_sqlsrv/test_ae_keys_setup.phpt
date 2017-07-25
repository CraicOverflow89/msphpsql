--TEST--
retrieval of names of column master key and column encryption key generated in the database setup
--SKIPIF--
<?php if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') die("Skipped: Test for Windows"); ?>
--FILE--
<?php
sqlsrv_configure( 'WarningsReturnAsErrors', 0 );
sqlsrv_configure( 'LogSeverity', SQLSRV_LOG_SEVERITY_ALL );

require( 'MsCommon.inc' );
$conn = Connect();
    
if (IsAEQualified($conn)){
    $query = "SELECT name FROM sys.column_master_keys";
    $stmt = $conn->query($query);
    $master_key_row = $stmt->fetch();
    
    $query = "SELECT name FROM sys.column_encryption_keys";
    $stmt = $conn->query($query);
    $encryption_key_row = $stmt->fetch();
    
    if ($master_key_row[0] == 'AEMasterKey' && $encryption_key_row[0] == 'AEColumnKey'){
        echo "Test Successfully.\n";
    }
    else {
        die("Column Master Key and Column Encryption Key not created.\n");
    }
    unset($stmt);
}
else {
    echo "Test Successfully.\n";
}
unset($conn);
?>
--EXPECT--
Test Successfully.