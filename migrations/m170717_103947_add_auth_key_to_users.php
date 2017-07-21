<?php

use yii\db\Migration;

class m170717_103947_add_auth_key_to_users extends Migration
{
    public function up()
    {
		$this->addColumn("users", "auth_key", $this->string(32));
    }

    public function down()
    {
    	$this->dropColumn("users", "auth_key");

        return true;
    }

}
