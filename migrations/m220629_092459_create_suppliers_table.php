<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%suppliers}}`.
 */
class m220629_092459_create_suppliers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {


        $this->createTable('{{%suppliers}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => "varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT ''",
            'code' => "char(3) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL",
            't_status' => "enum('ok','hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok'",
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
        $this->createIndex('uk_code', '{{%suppliers}}', 'code', true);



        $this->injection_data();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%suppliers}}');
    }


    private function injection_data(){
        $rows = [
            ['love home big ltd love', 'IOZ', 'hold'],
            ['hey mini ltd ha hey', 'GOE', 'hold'],
            ['mini my mini sad testing', 'h99', 'ok'],
            ['home home hey home', 'moN', 'hold'],
            ['home home testing hey', 'z00', 'hold'],
            ['home ha hey hey ltd', 'url', 'ok'],
            ['my mini ltd big love home', 'pmK', 'ok'],
            ['hey testing ha my my', 's8m', 'ok'],
            ['sad home sad love hey sad', '4EQ', 'ok'],
            ['sad mini home sad love', 'RYT', 'hold'],
            ['love hey home mini ltd', 'wfR', 'hold'],
            ['home testing testing love ltd ha', 'SnZ', 'ok'],
            ['love mini hey testing love', 'eIK', 'ok'],
            ['ha my ha mini home testing', '9xj', 'ok'],
            ['home my ltd ltd mini', 'ZAP', 'ok'],
            ['love ha mini love sad', 'DMU', 'hold'],
            ['home home my ltd home', 'O9B', 'hold'],
            ['sad mini home mini', '29N', 'hold'],
            ['ltd testing my sad big', 'SEV', 'hold'],
            ['mini hey love my home', 'UNu', 'hold'],
            ['home sad big hey', 'BOK', 'ok'],
            ['ltd mini love hey ha', 'TSK', 'ok'],
            ['my home testing ha love', 'EDa', 'hold'],
            ['hey home mini hey', 'Dmf', 'ok'],
            ['mini hey sad testing', 'T1V', 'ok'],
            ['love ha ltd love love love', 'KGN', 'ok'],
            ['sad ltd home testing sad sad', 'jaH', 'hold'],
            ['testing ltd ltd ha', 'dgx', 'hold'],
            ['ltd big sad hey', 'JJ3', 'ok'],
            ['love mini mini ha ha', 'sb5', 'hold'],
            ['hey hey home testing hey', 'UzY', 'ok'],
            ['big sad love love testing', 'Vr8', 'hold'],
            ['hey ha home testing ltd mini', '1tw', 'ok'],
            ['big ltd ha ha big love', 'WkE', 'ok'],
            ['big testing testing my', 'Xi2', 'ok'],
            ['testing mini big ha testing ltd', 'BoW', 'hold'],
            ['my ha testing ha', '4qM', 'ok'],
            ['hey big mini hey love mini', '2QH', 'hold'],
            ['love big big mini sad ltd', 'h5p', 'ok'],
            ['home testing testing ltd home mini', '1KP', 'hold'],
            ['home my big ha mini hey', 'n6O', 'ok'],
            ['big sad love my sad big', 'Vrd', 'ok'],
            ['ltd my sad testing love my', 'nMv', 'ok'],
            ['ltd mini testing ltd ltd', 'xfF', 'ok'],
            ['sad ltd sad mini', 'P7I', 'hold'],
            ['ltd ha my testing hey ltd', 'gml', 'hold'],
            ['ha home home home home', 'l1M', 'hold'],
            ['mini mini hey big testing', 'QcP', 'ok'],
            ['my sad my testing my', 'bRf', 'ok'],
            ['testing my my big', 'zuu', 'hold'],
            ['testing hey home ha love', 'bZv', 'hold'],
            ['testing ltd home hey big', 'MPW', 'ok'],
            ['big love home ltd', 'gH9', 'hold'],
            ['ltd home big my', 'mD9', 'ok'],
            ['hey ha ltd hey ha ltd', 'x55', 'hold'],
            ['ha ltd big mini', 'SGC', 'hold'],
            ['mini hey home home love mini', '3K7', 'ok'],
            ['ltd hey sad my', 'dG3', 'hold'],
            ['hey home mini sad love', 'LGw', 'ok'],
            ['my big hey love home', 'dFw', 'hold'],
            ['hey big sad big hey', 'ZkK', 'hold'],
            ['my my my ltd', '8Zy', 'ok'],
            ['sad mini testing love', 'raD', 'hold'],
            ['home testing ha testing testing mini', 'R8t', 'ok'],
            ['home sad sad big sad my', 'xzo', 'hold'],
            ['hey sad testing home ha ltd', 'RLo', 'hold'],
            ['ha big ha sad', 'SK6', 'hold'],
            ['ltd hey mini love ha ha', 'I2Z', 'hold'],
            ['testing my hey my love ltd', 'rNs', 'hold'],
            ['hey sad home ltd', 'yna', 'hold'],
            ['home home hey ha', 't1K', 'hold'],
            ['sad big sad home', 'Boa', 'hold'],
            ['sad testing my ltd', 'ITr', 'hold'],
            ['mini love home home home', 'lMy', 'hold'],
            ['testing ha big hey my', '3VV', 'ok'],
            ['home love testing ltd mini', 'rPN', 'hold'],
            ['testing mini testing testing my', 'PLY', 'ok'],
            ['sad home big ltd', 'S3f', 'ok'],
            ['sad love testing big ha', 'fPg', 'hold'],
            ['mini hey big hey testing', 'hc4', 'ok'],
            ['ltd home big big sad', 'Kj0', 'hold'],
            ['sad mini hey home', 'AjG', 'ok'],
            ['hey love sad ltd', '2uA', 'ok'],
            ['hey my hey ltd', 'h5N', 'ok'],
            ['mini ha mini sad ltd love', '3Bf', 'ok'],
            ['hey testing ltd hey big', 'ufK', 'hold'],
            ['testing love love big sad', 'qZp', 'ok'],
            ['testing home ltd testing my ltd', '26H', 'hold'],
            ['big big testing ha big', 'WIG', 'hold'],
            ['sad mini testing sad', 'chp', 'hold'],
            ['testing my hey love love', 'TiA', 'hold'],
            ['ha hey mini ltd home home', 'tJj', 'hold'],
            ['mini love testing hey mini', '2Ks', 'hold'],
            ['big love testing sad big', '1SI', 'ok'],
            ['testing mini testing testing sad', '0nT', 'hold'],
            ['ltd ltd my ltd big testing', '3iO', 'ok'],
            ['mini testing testing hey testing', 'Aoe', 'hold'],
            ['hey mini love ltd big sad', 'fgS', 'ok'],
            ['home ha love hey home sad', 'Ews', 'hold'],
            ['testing ltd my my', 'cnU', 'ok'],
        ];
        $this->batchInsert("{{%suppliers}}", ['name', 'code', 't_status'], $rows);
    }


}
