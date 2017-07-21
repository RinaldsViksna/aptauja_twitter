<?php

use yii\db\Migration;

class m170717_125046_add_id_to_evaluations extends Migration
{
    public function up()
    {
        $this->addColumn("evaluations", "id", $this->primaryKey ( 32 ));
        $this->addColumn("evaluations", "session", $this->string(255));
        $this->addColumn("users", "role", $this->string(255));
    }

    public function down()
    {
        $this->dropColumn("evaluations", "id");
        $this->dropColumn("evaluations", "session");
        $this->dropColumn("users", "role");

        return true;
    }
}
