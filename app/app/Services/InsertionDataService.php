<?php

namespace App\Services;

class InsertionDataService
{
    /**
     * Getting the name and data types of columns from the database
     *
     * @param $tableName
     * @return array
     */
    private function getTableColumns($tableName): array
    {
        $columnTypes = array();

        $columns = \Schema::getColumnListing($tableName);

        //Inserting type of columns into array
        //and using their names like a key
        foreach ($columns as $column) {
            $columnTypes[$column] = \DB::getSchemaBuilder()
                ->getColumnType($tableName, $column);
        }

        return $columnTypes;
    }

    /**
     * Cast cell into correct date type
     *
     * @param $value
     * @param $type
     * @return float|int|string|null
     */
    private function castValue($value, $type): float|int|string|null
    {
        return match ($type) {
            'int', 'bigint' => (int)$value,
            'float', 'double' => (float)$value,
            'datetime', 'timestamp' => date('Y-m-d H:i:s', strtotime($value)),
            default => $value,
        };
    }

    /**
     * Inserting parsed info from file into table of database
     *
     * @param $data
     * @param $class
     * @return void
     * @throws \Exception
     */
    public function insertArrayIntoTable($data, $class): void
    {
        $table = (new $class)->getTable();
        $columns = $this->getTableColumns($table);

        $insertData = [];

        foreach ($data as $row) {
            $rowData = [];
            $index = 0;

            foreach ($columns as $column => $type) {
                $value = $row[$index];
                $rowData[$column] = $this->castValue($value, $type);
                $index++;
            }

            $insertData[] = $rowData;
        }

        try{
            \DB::table($table)->insert($insertData);
        } catch (\Exception $exception) {
            $errorCode = $exception->getCode();

            throw new \Exception("Database error [Code: $errorCode]: " .$exception->getMessage());
        }
    }
}
