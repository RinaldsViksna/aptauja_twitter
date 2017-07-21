<?php

use yii\db\Migration;

class m170421_053827_tweet_table extends Migration
{
	public function up() {
		$this->createTable ( 'tweets', [ 
				'id' => $this->primaryKey ( 32 ),
				'text' => $this->string ( 255 )->notNull (),
				'author_name' => $this->string ( 255 ),
				'author_profile' => $this->string ( 255 ),
				'author_pic' => $this->string ( 255 ) 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'users', [ 
				'id' => $this->primaryKey ( 32 ),
				'name' => $this->string ( 255 )->notNull (),
				'password_hash' => $this->string ( 255 )->notNull (),
				'birth_year' => $this->integer ( 8 ),
				'education' => $this->string ( 255 ) 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'sentiments', [ 
				'id' => $this->primaryKey ( 32 ),
				'sentiment' => $this->string ( 255 )->notNull () 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->createTable ( 'evaluations', [ 
				'tweet_id' => $this->integer ( 32 )->notNull (),
				'user_id' => $this->integer ( 32 )->notNull (),
				'sentiment_id' => $this->integer ( 32 )->notNull (),
				'is_latvian' => $this->boolean ()->notNull ()->defaultValue ( true ) 
		], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' );
		
		
		$this->addForeignKey ( "evaluations_tweet_id", "evaluations", [ "tweet_id" ], "tweets", [ "id" ], "CASCADE", "CASCADE" );
		
		$this->addForeignKey ( "evaluations_user_id", "evaluations", [ "user_id" ], "users", [ "id" ], "CASCADE", "CASCADE" );
		
		$this->addForeignKey ( "evaluations_sentiment_id", "evaluations", [ "sentiment_id" ], "sentiments", [ "id" ], "CASCADE", "CASCADE" );
	}
	
	
	public function down() {
		
		echo "m170421_053827_tweet_table.php does not support migration down.\n";
		
		return false;
	}
}
