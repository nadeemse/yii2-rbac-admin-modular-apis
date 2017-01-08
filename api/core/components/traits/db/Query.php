<?php
namespace core\components\traits\db;

use Yii;
use yii\db\Migration;

/**
 * @method \yii\db\Connection getDb
 * @property \yii\db\Connection $db
 */
trait Query
{
    /**
     * check if the current DB driver name is MYSQL
     *
     * @param string $db | database driver name
     *
     * @return bool
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function isMysqlDriver($db = null)
    {
        $driverName = $db;
        if ($db === null) {
            $driverName = $this->getDb()->driverName;
        }

        return ($driverName === 'mysql');

    }

    /**
     * check if the current DB driver name is MONGO DB
     *
     * @param string $db | database driver name
     *
     * @return bool
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function isMongoDriver($db = null)
    {
        $driverName = $db;
        if ($db === null) {
            $driverName = ($this->db->dsn);
        }

        return strpos($driverName, 'mongodb') === 0;
    }

    /**
     * Drop table if exists
     *
     * @param string $tableName table name, it accepts {{%TABLE_NAME}}
     *
     * @see    \Yii\db\Connection::quoteTableName
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     * @return void
     */
    public function dropTableIfExist($tableName)
    {
        $table = $this->getDb()->quoteTableName($tableName);

        if ($this instanceof Migration) {
            echo "    > drop table $table ...";
            $time = microtime(true);
            /** @var Query $this */
            $this->dropTableByName($table);
            echo " done (time: " . sprintf('%.3f', microtime(true) - $time) . "s)\n";
        } else {
            static::dropTableByName($tableName);
        }
    }

    /**
     * Drop table name if exists
     *
     * @param string $table table name to drop if exists
     *
     * @throws \yii\db\Exception
     * @return void
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function dropTableByName($table)
    {
        $this->getDb()->createCommand("DROP TABLE IF EXISTS " . $this->db->quoteTableName($table))->execute();
    }
}
