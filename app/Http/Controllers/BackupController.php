<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class BackupController extends Controller
{
    /**
     * Show the backup configurations/actions page.
     */
    public function index(): View
    {
        return view('backup.index');
    }

    /**
     * Generate and download the database SQL backup file.
     */
    public function download(): StreamedResponse
    {
        $dbName = config('database.connections.mysql.database');
        $fileName = 'backup_' . $dbName . '_' . date('Ymd_His') . '.sql';

        $response = new StreamedResponse(function () use ($dbName) {
            $handle = fopen('php://output', 'w');
            
            // Disable foreign key checks for clean restoration
            fwrite($handle, "-- ASETRA Database Backup\n");
            fwrite($handle, "-- Generated: " . date('Y-m-d H:i:s') . "\n\n");
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");
            
            // Get all database tables
            $tables = DB::select('SHOW TABLES');
            $key = 'Tables_in_' . $dbName;

            foreach ($tables as $table) {
                if (!isset($table->$key)) {
                    continue;
                }
                
                $tableName = $table->$key;
                
                // Get CREATE TABLE statement
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                $createStatement = $createTable->{'Create Table'} ?? $createTable->{'Create View'} ?? '';
                
                fwrite($handle, "-- Table Structure for `{$tableName}`\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");
                fwrite($handle, $createStatement . ";\n\n");
                
                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    fwrite($handle, "-- Dumping data for table `{$tableName}`\n");
                    
                    $firstRow = (array) $rows->first();
                    $columns = array_keys($firstRow);
                    $escapedColumns = array_map(function($c) { return "`{$c}`"; }, $columns);
                    $insertPrefix = "INSERT INTO `{$tableName}` (" . implode(', ', $escapedColumns) . ") VALUES \n";
                    
                    fwrite($handle, $insertPrefix);
                    
                    $rowLines = [];
                    foreach ($rows as $rowIndex => $row) {
                        $values = [];
                        foreach ($columns as $col) {
                            $val = $row->$col;
                            if (is_null($val)) {
                                $values[] = 'NULL';
                            } else {
                                $values[] = "'" . addslashes($val) . "'";
                            }
                        }
                        $rowLines[] = "(" . implode(', ', $values) . ")";
                        
                        // Chunk inserts to prevent massive statements
                        if (($rowIndex + 1) % 100 === 0) {
                            fwrite($handle, implode(",\n", $rowLines) . ";\n\n");
                            if ($rowIndex + 1 < $rows->count()) {
                                fwrite($handle, $insertPrefix);
                            }
                            $rowLines = [];
                        }
                    }
                    
                    if (count($rowLines) > 0) {
                        fwrite($handle, implode(",\n", $rowLines) . ";\n\n");
                    }
                }
            }
            
            // Re-enable foreign key checks
            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'application/sql');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');

        return $response;
    }
}
