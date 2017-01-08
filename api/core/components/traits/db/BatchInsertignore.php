<?php

namespace core\components\traits\db;

use Yii;

trait Batchinsertignore
{
    /**
     * implement yii batchinsert with mysql 'IGNORE' keywork
     *
     * @link   http://www.yiiframework.com/doc-2.0/yii-db-command.html#batchInsert()-detail
     * @see    Command::BatchInsert();
     *
     * @param string $table   table name
     * @param array  $columns table columns
     * @param array  $rows    data to be inserted
     *
     * @return string mysql insert command
     * @throws \yii\base\NotSupportedException
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function Batchinsertignore($table, $columns, $rows)
    {
        $db = Yii::$app->getDb();

        $schema = $db->getSchema();
        if (($tableSchema = $schema->getTableSchema($table)) !== null) {
            $columnSchemas = $tableSchema->columns;
        } else {
            $columnSchemas = [];
        }

        $values = [];
        foreach ($rows as $row) {
            $vs = [];
            foreach ($row as $i => $value) {
                if (isset($columns[$i], $columnSchemas[$columns[$i]]) && !is_array($value)) {
                    $value = $columnSchemas[$columns[$i]]->dbTypecast($value);
                }
                if (is_string($value)) {
                    $value = $schema->quoteValue($value);
                } elseif ($value === false) {
                    $value = 0;
                } elseif ($value === null) {
                    $value = 'NULL';
                }
                $vs[] = $value;
            }
            $values[] = '(' . implode(', ', $vs) . ')';
        }

        foreach ($columns as $i => $name) {
            $columns[$i] = $schema->quoteColumnName($name);
        }

        return 'INSERT IGNORE INTO ' . $schema->quoteTableName($table)
               . ' (' . implode(', ', $columns) . ') VALUES ' . implode(', ', $values);
    }
}
